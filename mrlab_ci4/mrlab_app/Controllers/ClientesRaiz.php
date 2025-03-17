<?php

namespace App\Controllers;

use App\Controllers\PainelController;

class ClientesRaiz extends PainelController
{
	protected $clieRaizMD = null;
	protected $cfg = null;
	protected $cfgStatus = null;

	public function __construct()
	{
		$this->clieRaizMD = new \App\Models\ClientesRaizModel();

		$this->cfg = new \Config\AppSettings();
		$this->cfgStatus = $this->cfg->getStatusDefault();
		$this->data['cfgStatus'] = $this->cfgStatus;

		helper('form');
		helper('text');

		$this->data['menu_active'] = 'categorias';
	}


	public function index()
	{

		$sessionAdmin_user_nivel = session()->get('admin_nivel');
		if ($sessionAdmin_user_nivel == 'cliente_raiz') {
			return $this->response->redirect(site_url('clientesRaiz/form'));
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


		$this->clieRaizMD->orderBy('clie_raiz_id', 'DESC')
			->limit(1000);
		$query = $this->clieRaizMD->get();

		$this->data['lastQuery'] = $this->clieRaizMD->getLastQuery();
		//->getCompiledSelect();

		if ($query && $query->resultID->num_rows >= 1) {
			$this->data['rs_list'] = $query;
		}

		return view($this->directory . '/clientes-raiz', $this->data);
	}


	public function form($clie_raiz_id = 0)
	{
		$template = 'clientes-raiz-form';

		if ($this->request->getPost()) {
			$validation = \Config\Services::validation();
			$rules = [
				"clie_raiz_nome_razao" => [
					"label" => "Nome/Razão",
					"rules" => "required",
					'errors' => [
						'required' => 'Preencha corretamente',
					],
				],
				"clie_raiz_login" => [
					"label" => "Login",
					"rules" => "required",
					'errors' => [
						'required' => 'Preencha corretamente',
					],
				],
			];

			if ($this->validate($rules)) {
				$clie_raiz_nome_razao = $this->request->getPost('clie_raiz_nome_razao');
				$clie_raiz_nome_fantasia = $this->request->getPost('clie_raiz_nome_fantasia');
				$clie_raiz_cnpj = $this->request->getPost('clie_raiz_cnpj');
				$clie_raiz_login = $this->request->getPost('clie_raiz_login');
				$clie_raiz_senha = $this->request->getPost('clie_raiz_senha');
				$clie_raiz_ativo = (int)$this->request->getPost('clie_raiz_ativo');

				$data_db = [
					'clie_raiz_hashkey' => md5(date("Y-m-d H:i:s") . "-" . random_string('alnum', 16)),
					'clie_raiz_urlpage' => url_title(convert_accented_characters($clie_raiz_nome_razao), '-', TRUE),
					'clie_raiz_nome_razao' => $clie_raiz_nome_razao,
					'clie_raiz_nome_fantasia' => $clie_raiz_nome_fantasia,
					'clie_raiz_cnpj' => $clie_raiz_cnpj,
					'clie_raiz_login' => $clie_raiz_login,
					'clie_raiz_senha' => fct_password_hash($clie_raiz_senha),
					'clie_raiz_dte_cadastro' => date("Y-m-d H:i:s"),
					'clie_raiz_dte_alteracao' => date("Y-m-d H:i:s"),
					'clie_raiz_ativo' => (int)$clie_raiz_ativo,
				];

				$queryEdit = $this->clieRaizMD->where('clie_raiz_id', $clie_raiz_id)->get();
				if ($queryEdit && $queryEdit->resultID->num_rows >= 1) {
					if (empty($clie_raiz_senha)) {
						unset($data_db['clie_raiz_raiz_senha']);
					}
					unset($data_db['clie_raiz_hashkey']);
					unset($data_db['clie_raiz_dte_cadastro']);
					$qryExecute = $this->clieRaizMD->update($clie_raiz_id, $data_db);
				} else {
					if (empty($clie_raiz_senha)) {
						unset($data_db['clie_raiz_senha']);
					}
					$clie_raiz_id = $this->clieRaizMD->insert($data_db);
				}

				

				return $this->response->redirect(site_url('clientesRaiz'));
				exit();
			} else {
				$this->data['validation'] = $validation->getErrors();
			}
		}

		$sessionAdmin_user_nivel = session()->get('admin_nivel');
		if ($sessionAdmin_user_nivel == 'cliente_raiz') {
			$clie_raiz_id = (int)session()->get('admin_id');
			$template = 'clientes-raiz-visualizar';
		}

		$query = $this->clieRaizMD->where('clie_raiz_id', $clie_raiz_id)->get();
		if ($query && $query->resultID->num_rows >= 1) {
			$rs_dados = $query->getRow();
			$this->data['rs_dados'] = $rs_dados;

		}

		return view($this->directory . '/' . $template, $this->data);
	}

	public function visualizar($clie_raiz_id = 0)
	{
		$template = 'clientes-raiz-visualizar';

		$query = $this->clieRaizMD->where('clie_raiz_id', $clie_raiz_id)->get();
		if ($query && $query->resultID->num_rows >= 1) {
			$rs_dados = $query->getRow();
			$this->data['rs_dados'] = $rs_dados;


		}

		return view($this->directory . '/' . $template, $this->data);
	}



	
}
