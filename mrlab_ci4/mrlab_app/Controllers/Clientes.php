<?php

namespace App\Controllers;

use App\Controllers\PainelController;

class Clientes extends PainelController
{
	protected $clieMD = null;
	protected $arqMD = null;
	protected $cfg = null;
	protected $cfgStatus = null;

	public function __construct()
	{
		$this->clieMD = new \App\Models\ClientesModel();
		$this->arqMD = new \App\Models\ClientesArquivosModel();

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
		if ($sessionAdmin_user_nivel == 'cliente') {
			return $this->response->redirect(site_url('clientes/form'));
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

		if ($query && $query->resultID->num_rows >= 1) {
			$this->data['rs_list'] = $query;
		}

		return view($this->directory . '/clientes', $this->data);
	}


	public function form($clie_id = 0)
	{
		$template = 'clientes-form';

		if ($this->request->getPost()) {
			$validation = \Config\Services::validation();
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
					'clie_hashkey' => md5(date("Y-m-d H:i:s") . "-" . random_string('alnum', 16)),
					'clie_urlpage' => url_title(convert_accented_characters($clie_nome_razao), '-', TRUE),
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
				if ($queryEdit && $queryEdit->resultID->num_rows >= 1) {
					if (empty($clie_senha)) {
						unset($data_db['clie_senha']);
					}
					unset($data_db['clie_hashkey']);
					unset($data_db['clie_dte_cadastro']);
					$qryExecute = $this->clieMD->update($clie_id, $data_db);
				} else {
					if (empty($clie_senha)) {
						unset($data_db['clie_senha']);
					}
					$clie_id = $this->clieMD->insert($data_db);
				}

				// Upload de documentos
				$args_file = ['file_name' => 'arq_anexo', 'file_prefixo' => 'docs', 'clie_id' => $clie_id];
				$documentos_upload = self::upload_docs_arquivos($args_file);

				return $this->response->redirect(site_url('clientes'));
				exit();
			} else {
				$this->data['validation'] = $validation->getErrors();
			}
		}

		$sessionAdmin_user_nivel = session()->get('admin_nivel');
		if ($sessionAdmin_user_nivel == 'cliente') {
			$clie_id = (int)session()->get('admin_id');
			$template = 'clientes-visualizar';
		}

		$query = $this->clieMD->where('clie_id', $clie_id)->get();
		if ($query && $query->resultID->num_rows >= 1) {
			$rs_dados = $query->getRow();
			$this->data['rs_dados'] = $rs_dados;

			// Documentos / Arquivos relacionados
			$query_arquivos = $this->arqMD
				->where('clie_id', $clie_id)
				->orderBy('arq_id', 'ASC')
				->get();
			if ($query_arquivos && $query_arquivos->resultID->num_rows >= 1) {
				$this->data['rs_list_arquivos'] = $query_arquivos;
			}
		}

		return view($this->directory . '/' . $template, $this->data);
	}

	public function visualizar($clie_id = 0)
	{
		$template = 'clientes-visualizar-teste';

		$query = $this->clieMD->where('clie_id', $clie_id)->get();
		if ($query && $query->resultID->num_rows >= 1) {
			$rs_dados = $query->getRow();
			$this->data['rs_dados'] = $rs_dados;


			/*
			 * -------------------------------------------------------------
			 * Documentos / Arquivos relacionados
			 * -------------------------------------------------------------
			**/
			$query_arquivos = $this->arqMD
				->where('clie_id', $clie_id)
				->orderBy('arq_id', 'ASC')
				->get();
			if ($query_arquivos && $query_arquivos->resultID->num_rows >= 1) {
				$this->data['rs_list_arquivos'] = $query_arquivos;
			}
		}

		return view($this->directory . '/' . $template, $this->data);
	}


	public function upload_docs_arquivos($args = [])
	{
		$file_name = (isset($args['file_name']) ? $args['file_name'] : '');
		$file_prefixo = (isset($args['file_prefixo']) ? $args['file_prefixo'] : '');
		$clie_id = (int)(isset($args['clie_id']) ? $args['clie_id'] : '');

		// Verifica se há arquivos para upload
		if ($this->request->getFiles()) {
			$arr_arq_nome_doc = $this->request->getPost('arq_nome_doc');
			$arr_arq_data = $this->request->getPost('arq_data');
			$arr_arq_validade = $this->request->getPost('arq_validade');
			$arr_arq_status = $this->request->getPost('arq_status');

			// Define o diretório de destino para os uploads
			$path_upload = $this->folder_upload . 'documentos/';

			foreach ($arr_arq_nome_doc as $keyDoc => $valDoc) {
				$arq_hash_item = $keyDoc;
				$arq_nome_doc = $valDoc;
				$arq_data = (isset($arr_arq_data[$keyDoc]) ? $arr_arq_data[$keyDoc] : '');
				$arq_validade = (isset($arr_arq_validade[$keyDoc]) ? $arr_arq_validade[$keyDoc] : '');
				$arq_status = (int)(isset($arr_arq_status[$keyDoc]) ? $arr_arq_status[$keyDoc] : '');

				// Verifica se o arquivo já foi enviado antes
				// $existing_file = $this->arqMD->where('clie_id', $clie_id)
				// 	->where('arq_hash_item', $arq_hash_item)
				// 	->first();
				// if ($existing_file) {
				// 	// Se o arquivo já existe, não faça o upload novamente
				// 	continue;
				// }

				// Nome do arquivo
				$file_name = 'arq_anexo_' . $arq_hash_item;

				$fileARQUIVO = $this->request->getFile($file_name);
				$newARQUIVO = "";
				if ($fileARQUIVO) {
					if ($fileARQUIVO->isValid() && !$fileARQUIVO->hasMoved()) {
						$originalName = $fileARQUIVO->getClientName();

						$arq_original = $originalName;
						$extension = $fileARQUIVO->getClientExtension();
						$extension = empty($extension) ? '' : '.' . $extension;
						$originalName = str_replace($extension, "", $originalName);

						$originalName = url_title(convert_accented_characters($originalName), '-', TRUE);
						$newARQUIVO = $originalName . '___' . $file_prefixo . '_' . time() . '_' . random_string('alnum', 4) . $extension;

						// Move o arquivo para o diretório de destino
						$fileARQUIVO->move($path_upload, $newARQUIVO);
					}
				}

				// Prepara os dados do arquivo para inserção
				$data_arq_db = [
					'clie_id' => (int)$clie_id,
					'arq_hashkey' => md5(date("Y-m-d H:i:s") . "-" . random_string('alnum', 16)),
					'arq_urlpage' => url_title(convert_accented_characters($arq_nome_doc), '-', TRUE),
					'arq_hash_item' => $arq_hash_item,
					'arq_nome_doc' => $arq_nome_doc,
					'arq_anexo' => $newARQUIVO,
					'arq_data' => fct_date2bd($arq_data),
					'arq_validade' => fct_date2bd($arq_validade),
					'arq_status' => $arq_status,
					'arq_dte_cadastro' => date("Y-m-d H:i:s"),
					'arq_dte_alteracao' => date("Y-m-d H:i:s"),
					'arq_ativo' => (int)$arq_status
				];
				$existing_file = $this->arqMD->where('clie_id', $clie_id)
					->where('arq_hash_item', $arq_hash_item)
					->first();
				if ($existing_file) {
					// Se o 'arq_anexo' for uma string vazia, pega o valor do arquivo existente
					if ($newARQUIVO === '') {
						$newARQUIVO = $existing_file->arq_anexo;
					}

					// Atualiza os dados do arquivo no banco de dados
					$data_arq_db['arq_anexo'] = $newARQUIVO;
					// Atualiza o arquivo na base de dados
					$this->arqMD->update($existing_file->arq_id, $data_arq_db);
				} else {
					// Insere o arquivo na base de dados
					$this->arqMD->insert($data_arq_db);
				}
				// // Insere o arquivo na base de dados
				// $this->arqMD->insert($data_arq_db);
			}
		}
	}


	public function ajaxform($action = "")
	{
		$error_num = "1";
		$error_msg = "Erro inesperado";
		$redirect = "";

		switch ($action) {
			case "EXCLUIR-ARQUIVO":
				$clie_id = (int)$this->request->getPost('clie_id');
				$arq_hashkey = $this->request->getPost('arq_hashkey');
				if (!empty($arq_hashkey)) {
					$query = $this->arqMD
						->where('clie_id', $clie_id)
						->where('arq_hashkey', $arq_hashkey)
						->limit(1)
						->get();
					if ($query && $query->resultID->num_rows >= 1) {
						$rs_dados = $query->getRow();
						$this->arqMD->where('clie_id', $clie_id);
						$this->arqMD->where('arq_hashkey', $arq_hashkey);
						$this->arqMD->delete();

						$error_num = "0";
						$error_msg = "Registro excluído com sucesso!";
					} else {
						$error_num = "1";
						$error_msg = "Não localizamos o registro na base de dados!";
					}
				}

				$arr_return = array(
					"error_num" => $error_num,
					"error_msg" => $error_msg,
				);

				echo (json_encode($arr_return));
				exit();
				break;
		}
	}
}
