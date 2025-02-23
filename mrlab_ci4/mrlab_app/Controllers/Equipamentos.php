<?php
namespace App\Controllers;
use App\Controllers\PainelController;

class Equipamentos extends PainelController
{
	protected $eqtoMD = null;
	protected $arqMD = null;
	protected $clieMD = null;
	protected $cfg = null;
	protected $cfgStatus = null;

    public function __construct()
    {
        $this->eqtoMD = new \App\Models\EquipamentosModel();
        $this->arqMD = new \App\Models\EquipamentosArquivosModel();
		$this->clieMD = new \App\Models\ClientesModel();


		$this->cfg = new \Config\AppSettings();
		$this->cfgStatus = $this->cfg->getStatusDefault();
		$this->data['cfgStatus'] = $this->cfgStatus;

		helper('form');
		helper('text');

		$this->data['menu_active'] = 'categorias';
    }


	public function index()
	{
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

		//$this->eqtoMD->orderBy('eqto_id', 'DESC')
		//	->limit(1000);
		//$query = $this->eqtoMD->get();

		$this->eqtoMD->from('tbl_equipamentos AS EQTO', true);
		$this->eqtoMD->select('EQTO.*');
		$this->eqtoMD->select('CLIE.clie_nome_razao');
		$this->eqtoMD->join('tbl_clientes CLIE', 'CLIE.clie_id = EQTO.clie_id', 'LEFT');
		$this->eqtoMD->orderBy('EQTO.eqto_id', 'ASC');
		$this->eqtoMD->limit(1000);
		$query = $this->eqtoMD->get();

		$this->data['lastQuery'] = $this->eqtoMD->getLastQuery();
			//->getCompiledSelect();

		if( $query && $query->resultID->num_rows >=1 )
		{
			$this->data['rs_list'] = $query;
		}

		return view($this->directory .'/equipamentos', $this->data);
	}


	public function form( $eqto_id = 0 )
	{
		$prosseguir = true;

		if ($this->request->getPost())
		{
			$validation =  \Config\Services::validation();
			$rules = [
				"eqto_titulo" => [
					"label" => "Título", 
					"rules" => "required",
					'errors' => [
						'required' => 'Preencha corretamente',
					],
				],
			];

			if ($this->validate($rules)) {
				$clie_id = (int)$this->request->getPost('clie_id');
				$eqto_titulo = $this->request->getPost('eqto_titulo');
				$eqto_tag = $this->request->getPost('eqto_tag');
				$eqto_setor = $this->request->getPost('eqto_setor');
				$eqto_local = $this->request->getPost('eqto_local');
				$eqto_capacidade = $this->request->getPost('eqto_capacidade');
				$eqto_fluido_ref = $this->request->getPost('eqto_fluido_ref');
				$eqto_fabricante = $this->request->getPost('eqto_fabricante');
				$eqto_modelo_cond = $this->request->getPost('eqto_modelo_cond');
				$eqto_modelo_evap = $this->request->getPost('eqto_modelo_evap');
				$eqto_observacoes = $this->request->getPost('eqto_observacoes');
				$eqto_ativo = $this->request->getPost('eqto_ativo');

				/*
				 * -------------------------------------------------------------
				 * Verificamos se a tag já existe
				 * -------------------------------------------------------------
				**/
					if( $prosseguir == true ){
						$query_check_tag = $this->eqtoMD
							->where('eqto_tag', $eqto_tag)
							->where('clie_id', $clie_id)
							->where('eqto_id !=', $eqto_id)
							->limit(1)
							->get();
						if( $query_check_tag && $query_check_tag->resultID->num_rows >= 1 )
						{
							$error_num = 1;
							$prosseguir = false;
						}
					}

				if( $prosseguir == true ){
					$data_db = [
						'clie_id' => $clie_id,
						'eqto_hashkey' => md5(date("Y-m-d H:i:s") ."-". random_string('alnum', 16)),
						'eqto_urlpage' => url_title( convert_accented_characters($eqto_titulo), '-', TRUE ),
						'eqto_titulo' => $eqto_titulo,
						'eqto_tag' => $eqto_tag,
						'eqto_setor' => $eqto_setor,
						'eqto_local' => $eqto_local,
						'eqto_capacidade' => $eqto_capacidade,
						'eqto_fluido_ref' => $eqto_fluido_ref,
						'eqto_fabricante' => $eqto_fabricante,
						'eqto_modelo_cond' => $eqto_modelo_cond,
						'eqto_modelo_evap' => $eqto_modelo_evap,
						'eqto_observacoes' => $eqto_observacoes,
						'eqto_dte_cadastro' => date("Y-m-d H:i:s"),
						'eqto_dte_alteracao' => date("Y-m-d H:i:s"),
						'eqto_ativo' => (int)$eqto_ativo,
					];

					$queryEdit = $this->eqtoMD->where('eqto_id', $eqto_id)->get();
					if( $queryEdit && $queryEdit->resultID->num_rows >=1 )
					{
						unset( $data_db['eqto_hashkey'] );
						unset( $data_db['eqto_dte_cadastro'] );
						$qryExecute = $this->eqtoMD->update($eqto_id, $data_db);
					}else{
						$eqto_id = $this->eqtoMD->insert($data_db);
					}

				}

				// Upload de documentos
				$args_file = ['file_name' => 'arq_anexo', 'file_prefixo' => 'docs', 'eqto_id' => $eqto_id];
				$documentos_upload = self::upload_docs_arquivos($args_file);


				return $this->response->redirect( site_url('equipamentos') );
				exit();

			} else {
				$this->data['validation'] = $validation->getErrors();
			}
		}


		$query = $this->eqtoMD->where('eqto_id', $eqto_id)->get();
		if( $query && $query->resultID->num_rows >=1 )
		{
			$rs_dados = $query->getRow();
			$this->data['rs_dados'] = $rs_dados;
			
			// Documentos / Arquivos relacionados
			$query_arquivos = $this->arqMD
				->where('eqto_id', $eqto_id)
				->orderBy('arq_id', 'ASC')
				->get();
			if ($query_arquivos && $query_arquivos->resultID->num_rows >= 1) {
				$this->data['rs_list_arquivos'] = $query_arquivos;
			}
		}

		$query_clientes = $this->clieMD
			->where('clie_ativo', '1')
			->orderBy('clie_nome_razao', 'ASC')
			->get();
		if( $query_clientes && $query_clientes->resultID->num_rows >=1 )
		{
			$this->data['rs_clientes'] = $query_clientes;
		}

		return view($this->directory .'/equipamentos-form', $this->data);
	}

	public function upload_docs_arquivos($args = [])
	{
		$file_name = (isset($args['file_name']) ? $args['file_name'] : '');
		$file_prefixo = (isset($args['file_prefixo']) ? $args['file_prefixo'] : '');
		$eqto_id = (int)(isset($args['eqto_id']) ? $args['eqto_id'] : '');
		
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
					'eqto_id' => (int)$eqto_id,
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
			
				$existing_file = $this->arqMD->where('eqto_id', $eqto_id)
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


	public function ajaxform( $action = "" )
	{
		$error_num = "1";
		$error_msg = "Erro inesperado";
		$redirect = "";

		switch ($action) {
		case "BUSCA-NOME-EQUIPAMENTO" :
			$clie_id = (int)$this->request->getPost('clie_id');
			$eqto_tag = $this->request->getPost('eqto_tag');

			$eqto_id = 0;
			$eqto_titulo = '';
			if( !empty($eqto_tag) ){

				$query = $this->eqtoMD
					->where('clie_id', $clie_id)
					->where('eqto_tag', $eqto_tag)
					->get();
					if( $query && $query->resultID->num_rows >=1 )
					{
						$rs_dados = $query->getRow();
						$eqto_id = $rs_dados->eqto_id;
						$eqto_titulo = $rs_dados->eqto_titulo;

						$error_num = "0";
						$error_msg = "Tag encontrada";
					}else{
						$error_num = "1";
						$error_msg = "não encontrado";			
					}
			}
		
			$arr_return = array(
				"error_num" => $error_num,
				"error_msg" => $error_msg,
				"eqto_id" => $eqto_id,
				"eqto_titulo" => $eqto_titulo,
			);

			echo( json_encode($arr_return) );
			exit();
		break;	
		case "CHECK-EQUIPAMENTO" :
			$eqto_id = (int)$this->request->getPost('eqto_id');
			$clie_id = (int)$this->request->getPost('clie_id');
			$eqto_tag = $this->request->getPost('eqto_tag');

			$eqto_titulo = '';
			if( !empty($eqto_tag) ){
				$query = $this->eqtoMD
					->where('clie_id', $clie_id)
					->where('eqto_tag', $eqto_tag)
					->where('eqto_id !=', $eqto_id)
					->get();


				if( $query && $query->resultID->num_rows >=1 )
				{
					$rs_dados = $query->getRow();
					$eqto_id = $rs_dados->eqto_id;
					$eqto_titulo = $rs_dados->eqto_titulo;

					$error_num = "1";
					$error_msg = "Existe uma tag com mesmo número<br>para o cliente selecionado.";
				}else{
					$error_num = "0";
					$error_msg = "não encontrado";
				}
			}
		
			$arr_return = array(
				"error_num" => $error_num,
				"error_msg" => $error_msg,
				"eqto_id" => $eqto_id,
				"eqto_titulo" => $eqto_titulo,
			);

			echo( json_encode($arr_return) );
			exit();
		break;	
		case "EXCLUIR-EQUIPAMENTO" :
			$eqto_hashkey = $this->request->getPost('eqto_hashkey');
			if( !empty($eqto_hashkey) ){
				$query = $this->eqtoMD
					->where('eqto_hashkey', $eqto_hashkey)
					->limit(1)
					->get();
				if( $query && $query->resultID->num_rows >=1 )
				{
					$rs_dados = $query->getRow();
					$this->eqtoMD->where('eqto_hashkey', $eqto_hashkey)->delete();

					$error_num = "0";
					$error_msg = "Equipamento excluído com sucesso!";
				}else{
					$error_num = "1";
					$error_msg = "Não localizamos o equipamento na base de dados!";
				}
			}
		
			$arr_return = array(
				"error_num" => $error_num,
				"error_msg" => $error_msg,
			);

			echo( json_encode($arr_return) );
			exit();
		break;
		case "EXCLUIR-ARQUIVO":
			$eqto_id = (int)$this->request->getPost('eqto_id');
			$arq_hashkey = $this->request->getPost('arq_hashkey');
			if (!empty($arq_hashkey)) {
				$query = $this->arqMD
					->where('eqto_id', $eqto_id)
					->where('arq_hashkey', $arq_hashkey)
					->limit(1)
					->get();
				if ($query && $query->resultID->num_rows >= 1) {
					$rs_dados = $query->getRow();
					$this->arqMD->where('eqto_id', $eqto_id);
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
