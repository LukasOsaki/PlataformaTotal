<?php
namespace App\Controllers;
use App\Controllers\BaseController;

class Perfil extends BaseController
{
	
	protected $cadMD = null;

    public function __construct()
    {
        $this->cadMD = new \App\Models\CadastrosModel();

		$this->data['menu_active'] = 'perfil';

		helper('form');
		helper('text');
		helper('cookie');
    }


	public function index()
	{
		

		return view('perfil', $this->data);
	}


	public function criar_conta()
	{
		$fields_post = [];
		$error_infos = [];
		if ($this->request->getPost())
		{
			$cad_nome = $this->request->getPost('cad_nome');
			$cad_email = $this->request->getPost('cad_email');
			$cad_senha = $this->request->getPost('cad_senha');

			$data_db = [
				'cad_hashkey' => md5(date("Y-m-d H:i:s") ."-". random_string('alnum', 16)),
				'cad_urlpage' => url_title( convert_accented_characters($cad_nome), '-', TRUE ),
				'cad_nome' => ($cad_nome),
				'cad_email' => ($cad_email),
				'cad_senha' => fct_password_hash($cad_senha),
				'cad_dte_cadastro' => date("Y-m-d H:i:s"),
				'cad_dte_alteracao' => date("Y-m-d H:i:s"),
				'cad_ativo' => '1',
			];
			$query = $this->cadMD
				->where('cad_email', $cad_email)
				->limit(1)
				->get();	
			if( $query && $query->resultID->num_rows >= 1 ){

				//$this->cadMD->set($data_db);
				//$this->cadMD->where('avis_id', $avis_id);
				//$this->cadMD->update();
			}else{

				$this->cadMD->set($data_db);
				$cad_id = $this->cadMD->insert();

			}

			return $this->response->redirect( site_url('dashboard') );
			exit();
		}
	}


	public function login()
	{
		$session = session();

		$fields_post = [];
		$error_infos = [];

		if ($this->request->getPost())
		{
			$cad_email = $this->request->getPost('lg_cad_email');
			$cad_senha = $this->request->getPost('lg_cad_senha');

			$query = $this->cadMD->select('*')
				->groupStart()
					->orGroupStart()
						->where('cad_email', $cad_email)
					->groupEnd()
				->groupEnd()
				->where('cad_senha', fct_password_hash($cad_senha))
				->limit(1)
				->get();
			if( $query && $query->resultID->num_rows >= 1 ){
				$rs_cad = $query->getRow();

				$ses_data = [
					'hash_id' => md5(date("Y-m-d H:i:s") ."-". random_string('alnum', 16)),
					'cad_id' => $rs_cad->cad_id,
					'cad_nome' => $rs_cad->cad_nome,
					'cad_email' => $rs_cad->cad_email,
					'isLoggedIn' => TRUE
				];
				$session->set($ses_data);

				/*
				 * -------------------------------------------------------------
				 * COOKIE
				 * -------------------------------------------------------------
				**/
					$config = new \Config\AppSettings();
					$CFG_COOKIE_NAME = $config->CFG_COOKIE_NAME;

					$cookieValue = json_encode($ses_data); // valor a ser armazenado no cookie;
					//$cookieExpiration = 3600; // Tempo em segundos (aqui, 1 hora)
					$cookieExpiration = 30 * 24 * 60 * 60; // 30 dias em segundos

					$cookie = [
						'name'   => $CFG_COOKIE_NAME,
						'value'  => $cookieValue,
						'expire' => $cookieExpiration,
						'secure' => FALSE
					];
					set_cookie($cookie);



				return $this->response->redirect( site_url('?logado=1') );

				//$this->cadMD->set($data_db);
				//$this->cadMD->where('avis_id', $avis_id);
				//$this->cadMD->update();
			}else{
				
				return $this->response->redirect( site_url('?logado=0') );

			}

			//return $this->response->redirect( site_url('dashboard') );
			exit();
		}
	}


	public function logout()
	{
		session()->destroy();

		$config = new \Config\AppSettings();
		$CFG_COOKIE_NAME = $config->CFG_COOKIE_NAME;
		delete_cookie($CFG_COOKIE_NAME);

		return $this->response->redirect( site_url() );
	}


	public function index_old()
	{
		if( $this->session_user_permissao == '1' ){ // administradores
			$query_rows_users = $this->userMD->where('del', '0')->selectCount('id')->get();
			if( $query_rows_users && $query_rows_users->resultID->num_rows >=1 )
			{
				$rs_rows_users = $query_rows_users->getRow();
				$this->data['vendedores_count'] = (int)$rs_rows_users->id;
			}
		}

		$query_rows_prod = $this->prodMD
			->where('del', '0')
			->selectCount('id')->get();
		if( $query_rows_prod && $query_rows_prod->resultID->num_rows >=1 )
		{
			$rs_rows_prod = $query_rows_prod->getRow();
			$this->data['produtos_count'] = (int)$rs_rows_prod->id;
		}


		$this->vendMD->where('del', '0');
		if( $this->session_user_permissao == '2' ){ // vendedores
			$this->vendMD->where('usuario_id', $this->session_user_id);
		}
		$this->vendMD->selectCount('id');

		$query_rows_vend = $this->vendMD->get();
		if( $query_rows_vend && $query_rows_vend->resultID->num_rows >=1 )
		{
			$rs_rows_vend = $query_rows_vend->getRow();
			$this->data['pedidos_count'] = (int)$rs_rows_vend->id;
		}


		return view('dashboard', $this->data);
	}

}
