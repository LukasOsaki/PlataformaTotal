<?php
namespace App\Controllers;
use App\Controllers\PainelController;

class Clientes extends PainelController
{
	protected $clieMD = null;

    public function __construct()
    {
        $this->clieMD = new \App\Models\ClientesModel();

		helper('form');
		helper('text');

		$this->data['menu_active'] = 'categorias';
    }


	public function index()
	{
		
		$sessionAdmin_user_nivel = session()->get('admin_nivel'); 
		if( $sessionAdmin_user_nivel == 'cliente'){
			return $this->response->redirect( site_url('clientes/form') );
		}

		return self::filtrar();
	}


	public function filtrar()
	{
		$filtro_pdf = '';
		// filtrar/user:marcio/cliente:123/dini:/dteend:/status:pago

		$uri = service('uri'); // Obter a instância do objeto URI
		$segments = $uri->getSegments();
		$index = array_search('filtrar', $segments); // Encontrar o índice do segmento "filtrar"

		$filteredSegments = array_slice($segments, $index + 1); // Retornar os elementos a partir de $index + 1 até o final


		$this->clieMD->orderBy('clie_id', 'DESC')
			->limit(1000);
		$query = $this->clieMD->get();

		$this->data['lastQuery'] = $this->clieMD->getLastQuery();
			//->getCompiledSelect();

		if( $query && $query->resultID->num_rows >=1 )
		{
			$this->data['rs_list'] = $query;
		}

		return view($this->directory .'/clientes', $this->data);
	}


	public function form( $clie_id = 0 )
	{
		$template = 'clientes-form'; 

		if ($this->request->getPost())
		{
			$validation =  \Config\Services::validation();
			$rules = [
				"clie_nome_razao" => [
					"label" => "Nome/Razão", 
					"rules" => "required",
					'errors' => [
						'required' => 'Preencha corretamente',
					],
				],
			];

			if ($this->validate($rules)) {
				$clie_nome_razao = $this->request->getPost('clie_nome_razao');
				$clie_nome_fantasia = $this->request->getPost('clie_nome_fantasia');
				$clie_cnpj = $this->request->getPost('clie_cnpj');
				$clie_email = $this->request->getPost('clie_email');
				$clie_senha = $this->request->getPost('clie_senha');
				$clie_cep = $this->request->getPost('clie_cep');
				$clie_endereco = $this->request->getPost('clie_endereco');
				$clie_end_numero = $this->request->getPost('clie_end_numero');
				$clie_end_compl = $this->request->getPost('clie_end_compl');
				$clie_bairro = $this->request->getPost('clie_bairro');
				$clie_cidade = $this->request->getPost('clie_cidade');
				$clie_estado = $this->request->getPost('clie_estado');
				$clie_observacoes = $this->request->getPost('clie_observacoes');
				$clie_dte_ini_contrato = $this->request->getPost('clie_dte_ini_contrato');
				$clie_dte_end_contrato = $this->request->getPost('clie_dte_end_contrato');
				$clie_ativo = (int)$this->request->getPost('clie_ativo');

				$data_db = [
					'clie_hashkey' =>md5(date("Y-m-d H:i:s") ."-". random_string('alnum', 16)),
					'clie_urlpage' => url_title( convert_accented_characters($clie_nome_razao), '-', TRUE ),
					'clie_nome_razao' => $clie_nome_razao,
					'clie_nome_fantasia' => $clie_nome_fantasia,
					'clie_cnpj' => $clie_cnpj,
					'clie_email' => $clie_email,
					'clie_senha' => fct_password_hash($clie_senha),
					'clie_cep' => $clie_cep,
					'clie_endereco' => $clie_endereco,
					'clie_end_numero' => $clie_end_numero,
					'clie_end_compl' => $clie_end_compl,
					'clie_bairro' => $clie_bairro,
					'clie_cidade' => $clie_cidade,
					'clie_estado' => $clie_estado,
					'clie_observacoes' => $clie_observacoes,
					'clie_dte_ini_contrato' => fct_date2bd($clie_dte_ini_contrato),
					'clie_dte_end_contrato' => fct_date2bd($clie_dte_end_contrato),
					'clie_dte_cadastro' => date("Y-m-d H:i:s"),
					'clie_dte_alteracao' => date("Y-m-d H:i:s"),
					'clie_ativo' => (int)$clie_ativo,
				];

				$queryEdit = $this->clieMD->where('clie_id', $clie_id)->get();
				if( $queryEdit && $queryEdit->resultID->num_rows >=1 )
				{
					if( empty($clie_senha) ){ unset( $data_db['clie_senha'] ); }
					unset( $data_db['clie_hashkey'] );
					unset( $data_db['clie_dte_cadastro'] );
					$qryExecute = $this->clieMD->update($clie_id, $data_db);
				}else{
					if( empty($clie_senha) ){ unset( $data_db['clie_senha'] ); }
					$clie_id = $this->clieMD->insert($data_db);
				}

				return $this->response->redirect( site_url('clientes') );
				exit();

			} else {
				$this->data['validation'] = $validation->getErrors();
			}
		}


		$sessionAdmin_user_nivel = session()->get('admin_nivel'); 
		if( $sessionAdmin_user_nivel == 'cliente'){
			$clie_id = (int)session()->get('admin_id');
			$template = 'clientes-visualizar';
		}


		$query = $this->clieMD->where('clie_id', $clie_id)->get();
		if( $query && $query->resultID->num_rows >=1 )
		{
			$rs_dados = $query->getRow();
			$this->data['rs_dados'] = $rs_dados;
		}

		return view($this->directory .'/'. $template, $this->data);
	}

}
