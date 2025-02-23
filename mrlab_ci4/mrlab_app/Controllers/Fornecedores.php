<?php

namespace App\Controllers;

use App\Controllers\PainelController;

class Fornecedores extends PainelController
{
	protected $funcMD = null;
	protected $arqMD = null;
	protected $cfg = null;
	protected $cfgStatus = null;

	public function __construct()
	{
		$this->funcMD = new \App\Models\FuncionariosModel();
		$this->arqMD = new \App\Models\FuncionariosArquivosModel();

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
		// if ($sessionAdmin_user_nivel == 'cliente') {
		// 	return $this->response->redirect(site_url('clientes/form'));
		// }

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

		
		$this->funcMD->orderBy('func_id', 'DESC')
			->limit(1000);
		$query = $this->funcMD->get();
	
		$this->data['lastQuery'] = $this->funcMD->getLastQuery();
		//->getCompiledSelect();

		if ($query && $query->resultID->num_rows >= 1) {
			$this->data['rs_list'] = $query;
		}

		return view($this->directory . '/funcionarios', $this->data);
	}


	public function form($func_id = 0)
	{
		$template = 'funcionarios-form';
		if ($this->request->getPost()) {
			$validation = \Config\Services::validation();
			$rules = [
				"func_nome" => [
					"label" => "Nome",
					"rules" => "required",
					'errors' => [
						'required' => 'Preencha corretamente',
					],
				],
			];

			if ($this->validate($rules)) {
				$func_registro = $this->request->getPost('func_registro');
				$func_nome = $this->request->getPost('func_nome');
				$func_nome_mae = $this->request->getPost('func_nome_mae');
				$func_nome_pai = $this->request->getPost('func_nome_pai');
				$func_cpf = $this->request->getPost('func_cpf');
				$func_uf_rg = $this->request->getPost('func_uf_rg');
				$func_rg = $this->request->getPost('func_rg');
				$func_titulo = $this->request->getPost('func_titulo');
				$func_estado_civil = $this->request->getPost('func_estado_civil');
				$func_dt_nasc = $this->request->getPost('func_dt_nasc');
				$func_email = $this->request->getPost('func_email');
				$func_cep = $this->request->getPost('func_cep');
				$func_endereco = $this->request->getPost('func_endereco');
				$func_end_numero = $this->request->getPost('func_end_numero');
				$func_end_compl = $this->request->getPost('func_end_compl');
				$func_bairro = $this->request->getPost('func_bairro');
				$func_cidade = $this->request->getPost('func_cidade');
				$func_estado = $this->request->getPost('func_estado');
				$func_telefone = $this->request->getPost('func_telefone');
				$func_celular = $this->request->getPost('func_celular');
				$func_sn_vt = $this->request->getPost('func_sn_vt');
				$func_salario = $this->request->getPost('func_salario');
				$func_observacoes = $this->request->getPost('func_observacoes');
				$func_ativo = (int)$this->request->getPost('func_ativo');

				$data_db = [
					'func_hashkey' => md5(date("Y-m-d H:i:s") . "-" . random_string('alnum', 16)),
					'func_registro' => $func_registro,
					'func_nome' => $func_nome,
					'func_nome_mae' => $func_nome_mae,
					'func_nome_pai' => $func_nome_pai,
					'func_cpf' => $func_cpf,
					'func_uf_rg' => $func_uf_rg,
					'func_rg' => $func_rg,
					'func_titulo' => $func_titulo,
					'func_estado_civil' => $func_estado_civil,
					'func_dt_nasc' => fct_date2bd($func_dt_nasc),
					'func_email' => $func_email,
					'func_cep' => $func_cep,
					'func_endereco' => $func_endereco,
					'func_end_numero' => $func_end_numero,
					'func_end_compl' => $func_end_compl,
					'func_bairro' => $func_bairro,
					'func_cidade' => $func_cidade,
					'func_estado' => $func_estado,
					'func_telefone' => $func_telefone,
					'func_celular' => $func_celular,
					'func_sn_vt' => $func_sn_vt,
					'func_salario' => $func_salario,
					'func_observacoes' => $func_observacoes,
					'func_dte_cadastro' => date("Y-m-d H:i:s"),
					'func_dte_alteracao' => date("Y-m-d H:i:s"),
					'func_ativo' => (int)$func_ativo,
				];

				$queryEdit = $this->funcMD->where('func_id', $func_id)->get();
				if ($queryEdit && $queryEdit->resultID->num_rows >= 1) {
					unset($data_db['func_hashkey']);
					unset($data_db['func_dte_cadastro']);
					$qryExecute = $this->funcMD->update($func_id, $data_db);
				} else {
					
					$func_id = $this->funcMD->insert($data_db);
				}

				// Upload de documentos
				$args_file = ['file_name' => 'func_arq_anexo', 'file_prefixo' => 'docs', 'func_id' => $func_id];
				$documentos_upload = self::upload_docs_arquivos($args_file);

				return $this->response->redirect(site_url('funcionarios'));
				exit();
			} else {
				$this->data['validation'] = $validation->getErrors();
			}
		}

		$sessionAdmin_user_nivel = session()->get('admin_nivel');
		// if ($sessionAdmin_user_nivel == 'cliente') {
		// 	$func_id = (int)session()->get('admin_id');
		// 	$template = 'clientes-visualizar';
		// }

		$query = $this->funcMD->where('func_id', $func_id)->get();
		if ($query && $query->resultID->num_rows >= 1) {
			$rs_dados = $query->getRow();
			$this->data['rs_dados'] = $rs_dados;

			// Documentos / Arquivos relacionados
			$query_arquivos = $this->arqMD
				->where('func_id', $func_id)
				->where('func_arq_tipo', 'Documento') // Filtro adicional
				->orderBy('func_arq_id', 'ASC')
				->get();
			if ($query_arquivos && $query_arquivos->resultID->num_rows >= 1) {
				$this->data['rs_list_arquivos'] = $query_arquivos;
			}
			//Exames
			$query_exames = $this->arqMD
				->where('func_id', $func_id)
				->where('func_arq_tipo', 'Exame') // Filtro adicional
				->orderBy('func_arq_id', 'ASC')
				->get();
			if ($query_exames && $query_exames->resultID->num_rows >= 1) {
				$this->data['rs_list_exames'] = $query_exames;
			}
			//Cursos
			$query_cursos = $this->arqMD
				->where('func_id', $func_id)
				->where('func_arq_tipo', 'Curso') // Filtro adicional
				->orderBy('func_arq_id', 'ASC')
				->get();
			if ($query_cursos && $query_cursos->resultID->num_rows >= 1) {
				$this->data['rs_list_cursos'] = $query_cursos;
			}
		}

		return view($this->directory . '/' . $template, $this->data);
	}

	public function visualizar($func_id = 0)
	{
		$template = 'funcionarios-visualizar-teste';

		$query = $this->funcMD->where('func_id', $func_id)->get();
		if ($query && $query->resultID->num_rows >= 1) {
			$rs_dados = $query->getRow();
			$this->data['rs_dados'] = $rs_dados;


			/*
			 * -------------------------------------------------------------
			 * Documentos / Arquivos relacionados
			 * -------------------------------------------------------------
			**/
			$query_arquivos = $this->arqMD
				->where('func_id', $func_id)
				->where('func_arq_tipo', 'Documento') // Filtro adicional
				->orderBy('func_arq_id', 'ASC')
				->get();
			if ($query_arquivos && $query_arquivos->resultID->num_rows >= 1) {
				$this->data['rs_list_arquivos'] = $query_arquivos;
			}
			//Exames
			$query_exames = $this->arqMD
				->where('func_id', $func_id)
				->where('func_arq_tipo', 'Exame') // Filtro adicional
				->orderBy('func_arq_id', 'ASC')
				->get();
			if ($query_exames && $query_exames->resultID->num_rows >= 1) {
				$this->data['rs_list_exames'] = $query_exames;
			}
			//Cursos
			$query_cursos = $this->arqMD
				->where('func_id', $func_id)
				->where('func_arq_tipo', 'Curso') // Filtro adicional
				->orderBy('func_arq_id', 'ASC')
				->get();
			if ($query_cursos && $query_cursos->resultID->num_rows >= 1) {
				$this->data['rs_list_cursos'] = $query_cursos;
			}
		}

		return view($this->directory . '/' . $template, $this->data);
	}


	public function upload_docs_arquivos($args = [])
	{
		$file_name = (isset($args['file_name']) ? $args['file_name'] : '');
		$file_prefixo = (isset($args['file_prefixo']) ? $args['file_prefixo'] : '');
		$func_id = (int)(isset($args['func_id']) ? $args['func_id'] : '');

		// Verifica se há arquivos para upload
		if ($this->request->getFiles()) {
			$arr_arq_nome_doc = $this->request->getPost('func_arq_nome_doc');
			$arr_arq_data = $this->request->getPost('func_arq_data');
			$arr_arq_validade = $this->request->getPost('func_arq_validade');
			$arr_arq_tipo = $this->request->getPost('func_arq_tipo');
			$arr_arq_status = $this->request->getPost('func_arq_status');
			
			// Define o diretório de destino para os uploads
			$path_upload = $this->folder_upload . 'funcionarios/';

			foreach ($arr_arq_nome_doc as $keyDoc => $valDoc) {
				$arq_hash_item = $keyDoc;
				$arq_nome_doc = $valDoc;
				$arq_data = (isset($arr_arq_data[$keyDoc]) ? $arr_arq_data[$keyDoc] : '');
				$arq_validade = (isset($arr_arq_validade[$keyDoc]) ? $arr_arq_validade[$keyDoc] : '');
				$arq_status = (int)(isset($arr_arq_status[$keyDoc]) ? $arr_arq_status[$keyDoc] : '');
				$arq_tipo = (isset($arr_arq_tipo[$keyDoc]) ? $arr_arq_tipo[$keyDoc] : '');

				// Verifica se o arquivo já foi enviado antes
				// $existing_file = $this->arqMD->where('func_id', $func_id)
				// 	->where('arq_hash_item', $arq_hash_item)
				// 	->first();
				// if ($existing_file) {
				// 	// Se o arquivo já existe, não faça o upload novamente
				// 	continue;
				// }

				// Nome do arquivo
				$file_name = 'func_arq_anexo_' . $arq_hash_item;

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
					'func_id' => (int)$func_id,
					'func_arq_hashkey' => md5(date("Y-m-d H:i:s") . "-" . random_string('alnum', 16)),
					'func_arq_urlpage' => url_title(convert_accented_characters($arq_nome_doc), '-', TRUE),
					'func_arq_hash_item' => $arq_hash_item,
					'func_arq_nome_doc' => $arq_nome_doc,
					'func_arq_anexo' => $newARQUIVO,
					'func_arq_data' => fct_date2bd($arq_data),
					'func_arq_validade' => fct_date2bd($arq_validade),
					'func_arq_status' => $arq_status,
					'func_arq_tipo' => $arq_tipo,
					'func_arq_dte_cadastro' => date("Y-m-d H:i:s"),
					'func_arq_dte_alteracao' => date("Y-m-d H:i:s"),
					'func_arq_ativo' => (int)$arq_status
				];
				$existing_file = $this->arqMD->where('func_id', $func_id)
					->where('func_arq_hash_item', $arq_hash_item)
					->first();
				if ($existing_file) {
					// Se o 'arq_anexo' for uma string vazia, pega o valor do arquivo existente
					if ($newARQUIVO === '') {
						$newARQUIVO = $existing_file->func_arq_anexo;
					}

					// Atualiza os dados do arquivo no banco de dados
					$data_arq_db['func_arq_anexo'] = $newARQUIVO;
					// Atualiza o arquivo na base de dados
					$this->arqMD->update($existing_file->func_arq_id, $data_arq_db);
				} else {
					// Insere o arquivo na base de dados
					$this->arqMD->insert($data_arq_db);
				}
				
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
				$func_id = (int)$this->request->getPost('func_id');
				$arq_hashkey = $this->request->getPost('func_arq_hashkey');
				if (!empty($arq_hashkey)) {
					$query = $this->arqMD
						->where('func_id', $func_id)
						->where('func_arq_hashkey', $arq_hashkey)
						->limit(1)
						->get();
					if ($query && $query->resultID->num_rows >= 1) {
						$rs_dados = $query->getRow();
						$this->arqMD->where('func_id', $func_id);
						$this->arqMD->where('func_arq_hashkey', $arq_hashkey);
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
