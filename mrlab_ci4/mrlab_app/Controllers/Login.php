<?php

namespace App\Controllers;

use App\Controllers\PainelController;

class Login extends PainelController
{

	protected $userMD = null;
	protected $clieMD = null;
	protected $clieRaizMD = null;

	public function __construct()
	{
		$this->userMD = new \App\Models\UsuariosModel();
		$this->clieMD = new \App\Models\ClientesModel();
		$this->clieRaizMD = new \App\Models\ClientesRaizModel();

		helper('form');
		helper('text');
	}

	public function index()
	{
		if ($this->request->getPost()) {
			self::loginAuth();
		}

		return view($this->directory . '/login', $this->data);
	}

	public function logout()
	{
		$session = session();
		$session->destroy();

		return $this->response->redirect(site_url('login'));
	}

	public function loginAuth()
	{
		$session = session();
		$user_email = $this->request->getPost('user_email');
		$user_senha = $this->request->getPost('user_senha');

		// $query_user = $this->userMD->select('*')
		// 	->groupStart()
		// 		->orGroupStart()
		// 			->where('user_email', $user_email)
		// 			//->orWhere('user_login', $email)
		// 		->groupEnd()
		// 	->groupEnd()
		// 	->where('user_senha', fct_password_hash($user_senha))
		// 	->where('user_ativo', '1')
		// 	//->getCompiledSelect();
		// 	->get();

		$query_user = $this->userMD
			->select('tbl_usuarios.*, tbl_permissoes_acoes.pract_titulo, tbl_permissoes_acoes.pract_urlpage, tbl_permissoes_acoes.pract_visualizar, tbl_permissoes.perm_titulo')
			->join('tbl_permissoes_acoes', 'tbl_permissoes_acoes.perm_id = tbl_usuarios.perm_id AND tbl_permissoes_acoes.pract_ativo = 1', 'left')
			->join('tbl_permissoes', 'tbl_permissoes.perm_id = tbl_usuarios.perm_id', 'left')
			->where('user_email', $user_email)
			->where('user_senha', fct_password_hash($user_senha))
			->where('user_ativo', '1')
			->get();


		if ($query_user && $query_user->resultID->num_rows >= 1) {
			$rs_user = $query_user->getResult();

			// Cria array de permissões
			$permissoes = [];
			foreach ($rs_user as $row) {
				if ($row->pract_visualizar) {
					$permissoes[] = [
						'titulo' => $row->pract_titulo,
						'urlpage' => $row->pract_urlpage
					];
				}
			}

			// Ordena as permissões por título em ordem alfabética
			usort($permissoes, function ($a, $b) {
				return strcmp($a['titulo'], $b['titulo']);
			});


			$ses_data = [
				'admin_hash_id' => md5(date("Y-m-d H:i:s") . "-" . random_string('alnum', 16)),
				'admin_id' => $rs_user[0]->user_id,
				'admin_nome' => $rs_user[0]->user_nome,
				'admin_email' => $rs_user[0]->user_email,
				'admin_cnpj' => '',
				'admin_nivel' => $rs_user[0]->perm_titulo,
				'permissoes' => $permissoes,
				'isLoggedInAdmin' => TRUE
			];
			$session->set($ses_data);


			// colocar aqui login por cookie tamb�m
			return $this->response->redirect(site_url('dashboard/'));
		} else {
			//verifica se o login é de cliente raiz
			$query_cliente_raiz = $this->clieRaizMD->select('*')
				->groupStart()
				->orGroupStart()
				->where('clie_raiz_login', $user_email)
				//->orWhere('user_login', $email)
				->groupEnd()
				->groupEnd()
				->where('clie_raiz_senha', fct_password_hash($user_senha))
				->where('clie_raiz_ativo', '1')
				//->getCompiledSelect();
				->get();

			if ($query_cliente_raiz && $query_cliente_raiz->resultID->num_rows >= 1) {
				$rs_cliente_raiz = $query_cliente_raiz->getRow();
				$ses_data = [
					'admin_hash_id' => md5(date("Y-m-d H:i:s") . "-" . random_string('alnum', 16)),
					'admin_id' => $rs_cliente_raiz->clie_raiz_id,
					'admin_nome' => $rs_cliente_raiz->clie_raiz_nome_razao,
					'admin_email' => $rs_cliente_raiz->clie_raiz_login,
					'admin_cnpj' => '',
					'admin_nivel' => 'cliente_raiz',
					'isLoggedInAdmin' => TRUE
				];
				$session->set($ses_data);

				return $this->response->redirect(site_url('servicos/'));
			} else {
				// Elimina possivel mascara
				$user_email = preg_replace("/[^0-9]/", "", $user_email);
				$user_email = str_pad($user_email, 14, '0', STR_PAD_LEFT); // CNPJ
				$user_email = fct_mask($user_email, '##.###.###/####-##');

				//print $user_email;
				//print '<BR> '.  fct_password_hash($user_senha);
				//exit();

				$query_cliente = $this->clieMD->select('*')
					->groupStart()
					->orGroupStart()
					->where('clie_cnpj', $user_email)
					//->orWhere('user_login', $email)
					->groupEnd()
					->groupEnd()
					->where('clie_senha', fct_password_hash($user_senha))
					->where('clie_ativo', '1')
					//->getCompiledSelect();
					->get();
				if ($query_cliente && $query_cliente->resultID->num_rows >= 1) {
					$rs_cliente = $query_cliente->getRow();

					$ses_data = [
						'admin_hash_id' => md5(date("Y-m-d H:i:s") . "-" . random_string('alnum', 16)),
						'admin_id' => $rs_cliente->clie_id,
						'admin_nome' => $rs_cliente->clie_nome_razao,
						'admin_email' => $rs_cliente->clie_email,
						'admin_cnpj' => $rs_cliente->clie_cnpj,
						'admin_nivel' => 'cliente',
						'isLoggedInAdmin' => TRUE
					];
					$session->set($ses_data);

					return $this->response->redirect(site_url('servicos/'));
				} else {

					return $this->response->redirect(site_url('login/?error'));
				}
			}
		}
	}
}
