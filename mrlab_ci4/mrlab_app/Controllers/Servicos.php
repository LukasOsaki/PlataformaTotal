<?php

namespace App\Controllers;

use App\Controllers\PainelController;

require dirname(__DIR__, 2) . '/vendor/autoload.php';


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Servicos extends PainelController
{
	protected $pendMD = null;
	protected $pendMD2 = null;
	protected $pendMD3 = null;
	protected $pendTagMD = null;
	protected $pendMatMD = null;
	protected $clieMD = null;
	protected $clieRaizMD = null;
	protected $eqtoMD = null;
	protected $categMD = null;

	public function __construct()
	{
		$this->pendMD = new \App\Models\PendenciasModel();
		$this->pendMD2 = new \App\Models\PendenciasModel();
		$this->pendMD3 = new \App\Models\PendenciasModel();
		$this->pendTagMD = new \App\Models\PendenciasTagsModel();
		$this->pendMatMD = new \App\Models\PendenciasMateriaisModel();
		$this->clieMD = new \App\Models\ClientesModel();
		$this->clieRaizMD = new \App\Models\ClientesRaizModel();
		$this->eqtoMD = new \App\Models\EquipamentosModel();
		$this->categMD = new \App\Models\CategoriasModel();

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
		$cliente = $this->request->getGet('cliente'); // Captura o status da URL (GET)
		$equipamento = $this->request->getGet('equipamento'); // Captura o status da URL (GET)
		$inicio = $this->request->getGet('inicio'); // Captura o inicio da URL (GET)
		$fim = $this->request->getGet('fim'); // Captura o fim da URL (GET)

		$template = 'servicos';
		$sessionAdmin_user_nivel = session()->get('admin_nivel');
		if ($sessionAdmin_user_nivel == 'cliente' || $sessionAdmin_user_nivel == 'cliente_raiz') {
			$template = 'servicos-cliente';
		}

		$uri = service('uri'); // Obter a instância do objeto URI
		$segments = $uri->getSegments();
		$index = array_search('filtrar', $segments); // Encontrar o índice do segmento "filtrar"

		$filteredSegments = array_slice($segments, $index + 1); // Retornar os elementos a partir de $index + 1 até o final

		$query = $this->pendMD->from('tbl_pendencias As PEND', true)
			->select('PEND.*, CLIE.clie_nome_razao, CLIE.clie_nome_fantasia, CATEG.categ_titulo, CATEG.categ_color')
			->select("GROUP_CONCAT(DISTINCT TAG.pendtag_tag ORDER BY TAG.pendtag_tag SEPARATOR '; ') as pendtag_tags")
			->select("GROUP_CONCAT(DISTINCT TAG.pendtag_descricao ORDER BY TAG.pendtag_descricao SEPARATOR '; ') as pendtag_descricao")
			->join('tbl_pendencias_tags TAG', 'TAG.pend_id = PEND.pend_id', 'LEFT')
			->join('tbl_categorias CATEG', 'CATEG.categ_id = TAG.pendtag_status', 'LEFT')
			->join('tbl_clientes CLIE', 'CLIE.clie_id = PEND.clie_id', 'LEFT')
			->groupBy('PEND.pend_id')
			->orderBy('PEND.pend_id', 'DESC')
			// ->get()
		;

		if ($sessionAdmin_user_nivel == 'cliente') {
			$clie_id = (int)session()->get('admin_id');
			$this->pendMD->where('PEND.clie_id', $clie_id);
		}
		if ($sessionAdmin_user_nivel == 'cliente_raiz') {
			$clie_id = (int)session()->get('admin_id');
			$this->pendMD->where('CLIE.clie_raiz_id', $clie_id);
		}

		// Aplica o filtro de status se ele for informado
		if (!empty($cliente)) {
			$query->where('PEND.clie_id', $cliente);
		}

		if (!empty($periodicidade)) {
			$query->where('PEND.finc_periodicidade', $periodicidade);
		}
		if (!empty($inicio)) {
			$query->where('DATE(PEND.pend_dte_instalacao) >=', date('Y-m-d', strtotime($inicio)));
		}
		if (!empty($fim)) {
			$query->where('DATE(PEND.pend_dte_instalacao) <=', date('Y-m-d', strtotime($fim)));
		}

		if (!empty($equipamento)) {
			$query->like('TAG.pendtag_tag', $equipamento);
		}


		$query = $this->pendMD->orderBy('PEND.pend_id', 'DESC')
			// ->limit(1000)
			->get();

		$this->data['lastQuery'] = $this->pendMD->getLastQuery();
		//->getCompiledSelect();

		if ($query && $query->resultID->num_rows >= 1) {
			$this->data['rs_list'] = $query;
		}

		$query_clientes = $this->clieMD->where('clie_ativo', '1')->get();
		if ($query_clientes && $query_clientes->resultID->num_rows >= 1) {
			$this->data['rs_clientes'] = $query_clientes;
		}

		// Inclui os filtros para manter na view
		$this->data['selected_cliente'] = $cliente;
		$this->data['selected_inicio'] = $inicio;
		$this->data['selected_fim'] = $fim;
		$this->data['selected_equipamento'] = $equipamento;

		return view($this->directory . '/' . $template, $this->data);
	}

	public function filtrarApi()
	{
		$token = $this->request->getHeaderLine('X-Authorization');
		if (empty($token)) {
			return $this->response->setJSON(['message' => 'Token não fornecido.'], 401);
		}

		// Verifica se o token pertence a um cliente ou cliente raiz
		$cliente = $this->clieMD->where('clie_hashkey', $token)->first();
		$clienteRaiz = $this->clieRaizMD->where('clie_raiz_hashkey', $token)->first();

		if (!$cliente && !$clienteRaiz) {
			return $this->response->setJSON(['message' => 'Token inválido.'], 401);
		}

		$clienteId = $cliente ? $cliente->clie_id : null;
		$clienteRaizId = $clienteRaiz ? $clienteRaiz->clie_raiz_id : null;

		$cliente = $this->request->getGet('cliente_id'); // Captura o status da URL (GET)
		$equipamento = $this->request->getGet('equipamento'); // Captura o status da URL (GET)
		$inicio = $this->request->getGet('inicio'); // Captura o inicio da URL (GET)
		$fim = $this->request->getGet('fim'); // Captura o fim da URL (GET)

		$query = $this->pendMD->from('tbl_pendencias As PEND', true)
			->select('PEND.pend_id, PEND.pend_dte_registro, PEND.pend_dte_instalacao, PEND.pend_equipe, PEND.pend_coment_interno, PEND.clie_id, CLIE.clie_nome_razao, CLIE.clie_nome_fantasia, CATEG.categ_titulo, CATEG.categ_color')
			->select("GROUP_CONCAT(DISTINCT TAG.pendtag_tag ORDER BY TAG.pendtag_tag SEPARATOR '; ') as pendtag_tags")
			->select("GROUP_CONCAT(DISTINCT TAG.pendtag_descricao ORDER BY TAG.pendtag_descricao SEPARATOR '; ') as pendtag_descricao")
			->join('tbl_pendencias_tags TAG', 'TAG.pend_id = PEND.pend_id', 'LEFT')
			->join('tbl_categorias CATEG', 'CATEG.categ_id = TAG.pendtag_status', 'LEFT')
			->join('tbl_clientes CLIE', 'CLIE.clie_id = PEND.clie_id', 'LEFT')
			->groupBy('PEND.pend_id')
			->orderBy('PEND.pend_id', 'DESC');

		if ($clienteId) {
			$query->where('PEND.clie_id', $clienteId);
		} elseif ($clienteRaizId) {
			$query->where('CLIE.clie_raiz_id', $clienteRaizId);
		}

		if (!empty($inicio)) {
			$query->where('DATE(PEND.pend_dte_instalacao) >=', date('Y-m-d', strtotime($inicio)));
		}
		if (!empty($fim)) {
			$query->where('DATE(PEND.pend_dte_instalacao) <=', date('Y-m-d', strtotime($fim)));
		}
		if (!empty($equipamento)) {
			$query->like('TAG.pendtag_tag', $equipamento);
		}
		if (!empty($cliente)) {
			$query->like('PEND.clie_id', $cliente);
		}

		$result = $query->get();

		if ($result && $result->resultID->num_rows >= 1) {
			$pendencias = $result->getResultArray();

			foreach ($pendencias as &$pendencia) {
				$pend_id = $pendencia['pend_id'];

				//Retorno das tags
				$this->pendTagMD->from('tbl_pendencias_tags As TAG', true)
					->select('TAG.pendtag_tag AS  eqto, TAG.pendtag_descricao AS descricao, TAG.pendtag_tipo_serv AS tipo_serv, TAG.pendtag_status AS status')
					->select('EQTO.eqto_tag, EQTO.eqto_titulo')
					->join('tbl_equipamentos EQTO', 'EQTO.eqto_id = TAG.eqto_id', 'LEFT');
				$this->pendTagMD->where('TAG.pend_id', $pend_id);
				$this->pendTagMD->orderBy('TAG.pend_id', 'ASC');
				$query_tags = $this->pendTagMD->get();
				//$query_tags = $this->pendTagMD->where('pend_id', $pend_id)->get();
				if ($query_tags && $query_tags->resultID->num_rows >= 1) {
					$pendencia['tags']  = $query_tags->getResultArray();
				}

				//Retorno dos materiais utilizados
				$query_mats_utilizados = $this->pendMatMD
					->select('pend_mat_qtd AS qtd, pend_mat_eqto AS eqto, pend_mat_material AS tipo, pend_mat_observacoes AS comentario')
					->where('pend_id', $pend_id)
					->where('pend_mat_tipo', 'Utilizado')
					->orderBy('pend_id', 'ASC')
					->get();
				if ($query_mats_utilizados && $query_mats_utilizados->resultID->num_rows >= 1) {
					$pendencia['materiais_utilizados'] = $query_mats_utilizados->getResultArray();
				}

				//Retorno dos materiais solicitados
				$query_mats_solicitados = $this->pendMatMD
					->select('pend_mat_qtd AS qtd, pend_mat_eqto AS eqto, pend_mat_material AS tipo, pend_mat_observacoes AS comentario')
					->select('pend_mat_dte_compra AS dte_compra, pend_mat_dte_disponivel AS dte_disponivel, pend_mat_dte_utilizado AS dte_utilizado')
					->where('pend_id', $pend_id)
					->where('pend_mat_tipo', 'Solicitado')
					->orderBy('pend_id', 'ASC')
					->get();
				if ($query_mats_solicitados && $query_mats_solicitados->resultID->num_rows >= 1) {
					$pendencia['materiais_solicitados'] = $query_mats_solicitados->getResultArray();
				}



				// Obter tags
				// $tagsQuery = $this->pendTagMD
				// 	->select('TAG.*')
				// 	->select('EQTO.eqto_tag, EQTO.eqto_titulo')
				// 	->join('tbl_equipamentos EQTO', 'EQTO.eqto_id = TAG.eqto_id', 'LEFT')
				// 	->where('TAG.pend_id', $pend_id)
				// 	->orderBy('TAG.pend_id', 'ASC')
				// 	->get();
				// $pendencia['tags'] = $tagsQuery->getResultArray();

				// Obter materiais utilizados
				// $materiaisUtilizadosQuery = $this->pendMatMD
				// 	->where('pend_id', $pend_id)
				// 	->where('pend_mat_tipo', 'Utilizado')
				// 	->orderBy('pend_id', 'ASC')
				// 	->get();
				// $pendencia['materiais_utilizados'] = $materiaisUtilizadosQuery->getResultArray();

				// Obter materiais solicitados
				// $materiaisSolicitadosQuery = $this->pendMatMD
				// 	->where('pend_id', $pend_id)
				// 	->where('pend_mat_tipo', 'Solicitado')
				// 	->orderBy('pend_id', 'ASC')
				// 	->get();
				// $pendencia['materiais_solicitados'] = $materiaisSolicitadosQuery->getResultArray();
			}

			return $this->response->setJSON($pendencias);
		} else {
			return $this->response->setJSON(['message' => 'Nenhum registro encontrado.']);
		}
	}

	public function form($pend_id = 0)
	{
		if ($this->request->getPost()) {
			$validation =  \Config\Services::validation();
			$rules = [
				"clie_id" => [
					"label" => "Cliente",
					"rules" => "required",
					'errors' => [
						'required' => 'Preencha corretamente',
					],
				],
			];

			if ($this->validate($rules)) {
				$clie_id = (int)$this->request->getPost('clie_id');
				//$pend_dte_registro = $this->request->getPost('pend_dte_registro');
				$pend_tipo_serv = $this->request->getPost('pend_tipo_serv');
				$pend_status = $this->request->getPost('pend_status');
				$pend_num_os = $this->request->getPost('pend_num_os');
				//$pend_descricao = $this->request->getPost('pend_descricao');
				$pend_tag = $this->request->getPost('pend_tag');
				//$pend_dte_compra = $this->request->getPost('pend_dte_compra');
				//$pend_dte_instalacao = $this->request->getPost('pend_dte_instalacao');
				$pend_coment_interno = $this->request->getPost('pend_coment_interno');
				$pend_observacoes = $this->request->getPost('pend_observacoes');
				$pend_ativo = $this->request->getPost('pend_ativo');
				$pend_dte_registro = $this->request->getPost('pend_dte_registro');
				$pend_dte_instalacao = $this->request->getPost('pend_dte_instalacao');
				$pend_equipe = $this->request->getPost('pend_equipe');

				$data_db = [
					'clie_id' => $clie_id,
					'pend_hashkey' => md5(date("Y-m-d H:i:s") . "-" . random_string('alnum', 16)),
					//'eqto_urlpage' => url_title( convert_accented_characters($eqto_titulo), '-', TRUE ),
					//'pend_dte_registro' => fct_date2bd($pend_dte_registro),
					//'pend_tipo_serv' => $pend_tipo_serv,
					//'pend_status' => $pend_status,
					'pend_num_os' => $pend_num_os,
					//'pend_descricao' => $pend_descricao,
					'pend_tag' => $pend_tag,
					//'pend_dte_compra' => fct_date2bd($pend_dte_compra),
					//'pend_dte_instalacao' => fct_date2bd($pend_dte_instalacao),
					'pend_coment_interno' => $pend_coment_interno,
					'pend_observacoes' => $pend_observacoes,
					'pend_dte_registro' => isset($pend_dte_registro) ? fct_date2bd($pend_dte_registro) : null,
					'pend_dte_instalacao' => isset($pend_dte_instalacao) ? fct_date2bd($pend_dte_instalacao) : null,
					'pend_equipe' => $pend_equipe,
					'pend_dte_cadastro' => date("Y-m-d H:i:s"),
					'pend_dte_alteracao' => date("Y-m-d H:i:s"),
					'pend_ativo' => (int)$pend_ativo,
				];

				$queryEdit = $this->pendMD->where('pend_id', $pend_id)->get();
				if ($queryEdit && $queryEdit->resultID->num_rows >= 1) {
					unset($data_db['pend_hashkey']);
					unset($data_db['pend_dte_cadastro']);
					$qryExecute = $this->pendMD->update($pend_id, $data_db);
				} else {
					$pend_id = $this->pendMD->insert($data_db);
				}


				// ------------------------------------------------------------
				// Valores Tag --- FORMATO ANTIGO
				// ------------------------------------------------------------
				/*
				$arr_pendtag_tag = $this->request->getPost('pendtag_tag');
				$arr_pendtag_tipo_serv = $this->request->getPost('pendtag_tipo_serv');
				$arr_pendtag_status = $this->request->getPost('pendtag_status');
				$arr_pendtag_descricao = $this->request->getPost('pendtag_descricao');
				$arr_pendtag_retornar = $this->request->getPost('pendtag_retornar');
				$arr_pendtag_materiais = $this->request->getPost('pendtag_materiais');
				$arr_pendtag_coment_interno = $this->request->getPost('pendtag_coment_interno');
				$arr_pendtag_id = $this->request->getPost('pendtag_id');
					foreach ($arr_pendtag_id as $key => $val) {
						//echo('<hr>');
						$pendtag_eqto_id = (int)$val;
						$pendtag_tag = $arr_pendtag_tag[$key];
						$pendtag_tipo_serv = $arr_pendtag_tipo_serv[$key];
						$pendtag_status = $arr_pendtag_status[$key];
						$pendtag_descricao = $arr_pendtag_descricao[$key];
						$pendtag_retornar = $arr_pendtag_retornar[$key];
						$pendtag_materiais = $arr_pendtag_materiais[$key];
						$pendtag_coment_interno = $arr_pendtag_coment_interno[$key];
						$pendtag_id = (int)$arr_pendtag_id[$key];

						$acaoTAGS = 'INSERT';
						$query_tag = $this->pendTagMD
							->where('pendtag_id', $pendtag_id)
							->where('pend_id', $pend_id)
							->orderBy('pendtag_id', 'DESC')
							->limit(1)
							->get();
						if ($query_tag && $query_tag->resultID->num_rows >= 1) {
							$acaoTAGS = 'UPDATE';
						}
						$data_tag_db = [
							'pend_id' => $pend_id,
							'eqto_id' => $pendtag_eqto_id,
							'pendtag_hashkey' => md5(date("Y-m-d H:i:s") . "-" . random_string('alnum', 16)),
							'pendtag_tipo_serv' => $pendtag_tipo_serv,
							'pendtag_status' => $pendtag_status,
							'pendtag_tag' => $pendtag_tag ,
							'pendtag_descricao' => $pendtag_descricao,
							'pendtag_retornar' => $pendtag_retornar,
							'pendtag_materiais' => $pendtag_materiais,
							'pendtag_coment_interno' => $pendtag_coment_interno,
							'pendtag_dte_cadastro' => date("Y-m-d H:i:s"),
							'pendtag_dte_alteracao' => date("Y-m-d H:i:s"),
							'pendtag_ativo' => 1
						];
						if ($acaoTAGS == "INSERT") {
							$pendtag_id = $this->pendTagMD->insert($data_tag_db);
						}
						if ($acaoTAGS == "UPDATE") {
							unset($data_tag_db['pendtag_hashkey']);
							unset($data_tag_db['pendtag_dte_cadastro']);
							$qryExecuteTAGS = $this->pendTagMD->update($pendtag_id, $data_tag_db);
						}
					}
				*/
				/*
					desc_servicos_eqto
					desc_servicos_coment
					desc_servicos_tipo
					desc_servicos_status
					desc_servicos_id
				*/
				// ------------------------------------------------------------
				// Desrição de Serviços
				// ------------------------------------------------------------
				$arr_pendtag_tag = $this->request->getPost('desc_servicos_eqto');
				$arr_pendtag_descricao = $this->request->getPost('desc_servicos_coment');
				$arr_pendtag_tipo_serv = $this->request->getPost('desc_servicos_tipo');
				$arr_pendtag_status = $this->request->getPost('desc_servicos_status');
				$arr_pendtag_id = $this->request->getPost('desc_servicos_id');
				foreach ($arr_pendtag_id as $key => $val) {
					$pendtag_id = (int)$val;
					$pendtag_tag = $arr_pendtag_tag[$key];
					$pendtag_descricao = $arr_pendtag_descricao[$key];
					$pendtag_tipo_serv = $arr_pendtag_tipo_serv[$key];
					$pendtag_status = $arr_pendtag_status[$key];

					$acaoTAGS = 'INSERT';
					$query_tag = $this->pendTagMD
						->where('pendtag_id', $pendtag_id)
						->where('pend_id', $pend_id)
						->orderBy('pendtag_id', 'DESC')
						->limit(1)
						->get();
					if ($query_tag && $query_tag->resultID->num_rows >= 1) {
						$acaoTAGS = 'UPDATE';
					}
					$data_tag_db = [
						'pend_id' => $pend_id,
						'eqto_id' => 0,
						'pendtag_hashkey' => md5(date("Y-m-d H:i:s") . "-" . random_string('alnum', 16)),
						'pendtag_tipo_serv' => (int)$pendtag_tipo_serv,
						'pendtag_status' => (int)$pendtag_status,
						'pendtag_tag' => $pendtag_tag,
						'pendtag_descricao' => $pendtag_descricao,
						//'pendtag_retornar' => $pendtag_retornar,
						//'pendtag_materiais' => $pendtag_materiais,
						//'pendtag_coment_interno' => $pendtag_coment_interno,
						'pendtag_dte_cadastro' => date("Y-m-d H:i:s"),
						'pendtag_dte_alteracao' => date("Y-m-d H:i:s"),
						'pendtag_ativo' => 1
					];
					if ($acaoTAGS == "INSERT") {
						$pendtag_id = $this->pendTagMD->insert($data_tag_db);
					}
					if ($acaoTAGS == "UPDATE") {
						unset($data_tag_db['pendtag_hashkey']);
						unset($data_tag_db['pendtag_dte_cadastro']);
						$this->pendTagMD->set($data_tag_db);
						$this->pendTagMD->where('pendtag_id', $pendtag_id);
						$this->pendTagMD->where('pend_id', $pend_id);
						$this->pendTagMD->update();
					}
				}


				// ------------------------------------------------------------
				// Valores Mat 
				// ------------------------------------------------------------
				$arr_pend_mat_material = $this->request->getPost('pend_mat_material');
				$arr_pend_mat_eqto = $this->request->getPost('pend_mat_eqto');
				$arr_pend_mat_qtd = $this->request->getPost('pend_mat_qtd');
				$arr_pend_mat_tipo = $this->request->getPost('pend_mat_tipo');
				$arr_pend_mat_observacoes = $this->request->getPost('pend_mat_observacoes');
				$arr_pend_mat_id = $this->request->getPost('pend_mat_id');
				$arr_pend_mat_dte_compra = $this->request->getPost('pend_mat_dte_compra');
				$arr_pend_mat_dte_disponivel = $this->request->getPost('pend_mat_dte_disponivel');
				$arr_pend_mat_dte_utilizado = $this->request->getPost('pend_mat_dte_utilizado');

				foreach ($arr_pend_mat_id as $key => $val) {

					$pend_mat_material = $arr_pend_mat_material[$key];
					$pend_mat_eqto = $arr_pend_mat_eqto[$key];
					$pend_mat_tipo = $arr_pend_mat_tipo[$key];
					$pend_mat_observacoes = $arr_pend_mat_observacoes[$key];
					$pend_mat_qtd = (int)$arr_pend_mat_qtd[$key];
					$pend_mat_id = (int)$arr_pend_mat_id[$key];
					$pend_mat_id = (int)$arr_pend_mat_id[$key];
					$pend_mat_id = (int)$arr_pend_mat_id[$key];
					$pend_mat_dte_compra = isset($arr_pend_mat_dte_compra[$key]) ? fct_date2bd($arr_pend_mat_dte_compra[$key]) : null;
					$pend_mat_dte_disponivel = isset($arr_pend_mat_dte_disponivel[$key]) ? fct_date2bd($arr_pend_mat_dte_disponivel[$key]) : null;
					$pend_mat_dte_utilizado = isset($arr_pend_mat_dte_utilizado[$key]) ? fct_date2bd($arr_pend_mat_dte_utilizado[$key]) : null;

					$acaoMats = 'INSERT';
					if ($pend_mat_id > 0) {
						$query_mat = $this->pendMatMD
							->where('pend_mat_id', $pend_mat_id)
							->where('pend_id', $pend_id)
							->orderBy('pend_mat_id', 'DESC')
							->limit(1)
							->get();
						if ($query_mat && $query_mat->resultID->num_rows >= 1) {
							$acaoMats = 'UPDATE';
						}
					}
					$data_mat_db = [
						'pend_id' => $pend_id,
						'pendtag_hashkey' => md5(date("Y-m-d H:i:s") . "-" . random_string('alnum', 16)),
						'pend_mat_tipo' => $pend_mat_tipo,
						'pend_mat_material' => $pend_mat_material,
						'pend_mat_eqto' => $pend_mat_eqto,
						'pend_mat_observacoes' => $pend_mat_observacoes,
						'pend_mat_qtd' => $pend_mat_qtd,
						'pend_mat_dte_compra' => $pend_mat_dte_compra,
						'pend_mat_dte_disponivel' => $pend_mat_dte_disponivel,
						'pend_mat_dte_utilizado' => $pend_mat_dte_utilizado,
						'pend_mat_dte_cadastro' => date("Y-m-d H:i:s"),
						'pend_mat_dte_alteracao' => date("Y-m-d H:i:s"),
						'pend_mat_ativo' => 1
					];
					if ($acaoMats == "INSERT") {
						$pend_mat_id = $this->pendMatMD->insert($data_mat_db);
					}
					if ($acaoMats == "UPDATE") {
						unset($data_mat_db['pend_mat_hashkey']);
						unset($data_mat_db['pend_mat_dte_cadastro']);
						$this->pendMatMD->update($pend_mat_id, $data_mat_db);
					}
				}

				return $this->response->redirect(site_url('servicos'));
				exit();
			} else {
				$this->data['validation'] = $validation->getErrors();
			}
		}


		$this->pendMD->where('pend_id', $pend_id);

		$template = 'servicos-form';
		$sessionAdmin_user_nivel = session()->get('admin_nivel');

		if ($sessionAdmin_user_nivel == 'cliente') {
			$template = 'servicos-cliente-form';

			$clie_id = (int)session()->get('admin_id');
			$this->pendMD->where('clie_id', $clie_id);
		}

		$query = $this->pendMD->get();

		if ($query && $query->resultID->num_rows >= 1) {
			$rs_dados = $query->getRow();
			$this->data['rs_dados'] = $rs_dados;







			//Retorno das tags
			$this->pendTagMD->from('tbl_pendencias_tags As TAG', true)
				->select('TAG.*')
				->select('EQTO.eqto_tag, EQTO.eqto_titulo')
				->join('tbl_equipamentos EQTO', 'EQTO.eqto_id = TAG.eqto_id', 'LEFT');
			$this->pendTagMD->where('TAG.pend_id', $pend_id);
			$this->pendTagMD->orderBy('TAG.pend_id', 'ASC');
			$query_tags = $this->pendTagMD->get();
			//$query_tags = $this->pendTagMD->where('pend_id', $pend_id)->get();
			if ($query_tags && $query_tags->resultID->num_rows >= 1) {
				$this->data['rs_tags'] = $query_tags;
			}

			//Retorno dos materiais utilizados
			$query_mats_utilizados = $this->pendMatMD
				->where('pend_id', $pend_id)
				->where('pend_mat_tipo', 'Utilizado')
				->orderBy('pend_id', 'ASC')
				->get();
			if ($query_mats_utilizados && $query_mats_utilizados->resultID->num_rows >= 1) {
				$this->data['rs_mats_utilizados'] = $query_mats_utilizados;
			}

			//Retorno dos materiais solicitados
			$query_mats_solicitados = $this->pendMatMD
				->where('pend_id', $pend_id)
				->where('pend_mat_tipo', 'Solicitado')
				->orderBy('pend_id', 'ASC')
				->get();
			if ($query_mats_solicitados && $query_mats_solicitados->resultID->num_rows >= 1) {
				$this->data['rs_mats_solicitados'] = $query_mats_solicitados;
			}
		}

		//$query_cliente = $this->clieMD->where('clie_ativo', 1)->get();
		//if( $query_cliente && $query_cliente->resultID->num_rows >=1 )
		//{
		//	$this->data['rs_clientes'] = $query_cliente;
		//}

		//$query_equipamentos = $this->eqtoMD->where('clie_ativo', 1)->get();
		//if( $query_equipamentos && $query_equipamentos->resultID->num_rows >=1 )
		//{
		//	$this->data['rs_equipamento'] = $query_equipamentos;
		//}

		$query_status = $this->categMD->where('categ_area', 'pendencias-status')->get();
		if ($query_status && $query_status->resultID->num_rows >= 1) {
			$this->data['rs_status'] = $query_status;
		}

		$query_tipo_serv = $this->categMD->where('categ_area', 'pendencias-tipo-serv')->get();
		if ($query_tipo_serv && $query_tipo_serv->resultID->num_rows >= 1) {
			$this->data['rs_tipo_serv'] = $query_tipo_serv;
		}

		$query_clientes = $this->clieMD->where('clie_ativo', '1')->get();
		if ($query_clientes && $query_clientes->resultID->num_rows >= 1) {
			$this->data['rs_clientes'] = $query_clientes;
		}

		return view($this->directory . '/' . $template, $this->data);
	}


	public function impressao($pend_id = 0)
	{
		if ($this->request->getPost()) {
			$validation =  \Config\Services::validation();
			$rules = [
				"clie_id" => [
					"label" => "Cliente",
					"rules" => "required",
					'errors' => [
						'required' => 'Preencha corretamente',
					],
				],
			];

			if ($this->validate($rules)) {
				$clie_id = (int)$this->request->getPost('clie_id');
				//$pend_dte_registro = $this->request->getPost('pend_dte_registro');
				$pend_tipo_serv = $this->request->getPost('pend_tipo_serv');
				$pend_status = $this->request->getPost('pend_status');
				$pend_num_os = $this->request->getPost('pend_num_os');
				//$pend_descricao = $this->request->getPost('pend_descricao');
				$pend_tag = $this->request->getPost('pend_tag');
				//$pend_dte_compra = $this->request->getPost('pend_dte_compra');
				//$pend_dte_instalacao = $this->request->getPost('pend_dte_instalacao');
				$pend_coment_interno = $this->request->getPost('pend_coment_interno');
				$pend_observacoes = $this->request->getPost('pend_observacoes');
				$pend_ativo = $this->request->getPost('pend_ativo');

				$data_db = [
					'clie_id' => $clie_id,
					'pend_hashkey' => md5(date("Y-m-d H:i:s") . "-" . random_string('alnum', 16)),
					//'eqto_urlpage' => url_title( convert_accented_characters($eqto_titulo), '-', TRUE ),
					//'pend_dte_registro' => fct_date2bd($pend_dte_registro),
					//'pend_tipo_serv' => $pend_tipo_serv,
					//'pend_status' => $pend_status,
					'pend_num_os' => $pend_num_os,
					//'pend_descricao' => $pend_descricao,
					'pend_tag' => $pend_tag,
					//'pend_dte_compra' => fct_date2bd($pend_dte_compra),
					//'pend_dte_instalacao' => fct_date2bd($pend_dte_instalacao),
					'pend_coment_interno' => $pend_coment_interno,
					'pend_observacoes' => $pend_observacoes,
					'pend_dte_cadastro' => date("Y-m-d H:i:s"),
					'pend_dte_alteracao' => date("Y-m-d H:i:s"),
					'pend_ativo' => (int)$pend_ativo,
				];

				$queryEdit = $this->pendMD->where('pend_id', $pend_id)->get();
				if ($queryEdit && $queryEdit->resultID->num_rows >= 1) {
					unset($data_db['pend_hashkey']);
					unset($data_db['pend_dte_cadastro']);
					$qryExecute = $this->pendMD->update($pend_id, $data_db);
				} else {
					$pend_id = $this->pendMD->insert($data_db);
				}


				// ------------------------------------------------------------
				// Valores
				// ------------------------------------------------------------
				$arr_pendtag_tag = $this->request->getPost('pendtag_tag');
				$arr_pendtag_eqto_id = $this->request->getPost('pendtag_eqto_id');
				$arr_pendtag_equipamento = $this->request->getPost('pendtag_equipamento');

				$arr_pendtag_dte_registro = $this->request->getPost('pendtag_dte_registro');
				$arr_pendtag_dte_instalacao = $this->request->getPost('pendtag_dte_instalacao');
				$arr_pendtag_tipo_serv = $this->request->getPost('pendtag_tipo_serv');
				$arr_pendtag_status = $this->request->getPost('pendtag_status');

				$arr_pendtag_descricao = $this->request->getPost('pendtag_descricao');
				$arr_pendtag_observacoes = $this->request->getPost('pendtag_observacoes');
				$arr_pendtag_id = $this->request->getPost('pendtag_id');
				//$arr_pendtag_anexos = $this->request->getPost('pendtag_anexos');
				//$arr_tvlr_valor = $this->request->getPost('tvlr_valor');
				//$arr_tvlr_id = $this->request->getPost('tvlr_id');
				//var_dump( $arr_tvlr_titulo );
				//exit();
				if (is_array($arr_pendtag_eqto_id)) {
					foreach ($arr_pendtag_eqto_id as $key => $val) {
						//echo('<hr>');
						$pendtag_eqto_id = (int)$val;
						$pendtag_tag = $arr_pendtag_tag[$key];
						$pendtag_equipamento = $arr_pendtag_equipamento[$key];
						$pendtag_dte_registro = $arr_pendtag_dte_registro[$key];
						$pendtag_dte_instalacao = $arr_pendtag_dte_instalacao[$key];
						$pendtag_tipo_serv = $arr_pendtag_tipo_serv[$key];
						$pendtag_status = $arr_pendtag_status[$key];
						$pendtag_descricao = $arr_pendtag_descricao[$key];
						$pendtag_observacoes = $arr_pendtag_observacoes[$key];
						$pendtag_id = (int)$arr_pendtag_id[$key];

						if ($pendtag_eqto_id > 0) {
							$acaoTAGS = 'INSERT';
							if ($pendtag_id > 0) {
								$query_tag = $this->pendTagMD
									->where('pendtag_id', $pendtag_id)
									->where('pend_id', $pend_id)
									->orderBy('pendtag_id', 'DESC')
									->limit(1)
									->get();
								if ($query_tag && $query_tag->resultID->num_rows >= 1) {
									$acaoTAGS = 'UPDATE';
								}
							}
							$data_tag_db = [
								'pend_id' => $pend_id,
								'eqto_id' => $pendtag_eqto_id,
								'pendtag_hashkey' => md5(date("Y-m-d H:i:s") . "-" . random_string('alnum', 16)),
								'pendtag_dte_registro' => fct_date2bd($pendtag_dte_registro),
								'pendtag_dte_instalacao' => fct_date2bd($pendtag_dte_instalacao),
								'pendtag_tipo_serv' => $pendtag_tipo_serv,
								'pendtag_status' => $pendtag_status,
								'pendtag_tag' => $pendtag_tag . " | " . $pendtag_equipamento,
								'pendtag_descricao' => $pendtag_descricao,
								'pendtag_observacoes' => $pendtag_observacoes,
								'pendtag_dte_cadastro' => date("Y-m-d H:i:s"),
								'pendtag_dte_alteracao' => date("Y-m-d H:i:s"),
								'pendtag_ativo' => 1
							];
							if ($acaoTAGS == "INSERT") {
								$pendtag_id = $this->pendTagMD->insert($data_tag_db);
							}
							if ($acaoTAGS == "UPDATE") {
								unset($data_tag_db['pendtag_hashkey']);
								unset($data_tag_db['pendtag_dte_cadastro']);
								$qryExecuteTAGS = $this->pendTagMD->update($pendtag_id, $data_tag_db);
							}
						}
					}
				}

				return $this->response->redirect(site_url('servicos'));
				exit();
			} else {
				$this->data['validation'] = $validation->getErrors();
			}
		}


		$this->pendMD->where('pend_id', $pend_id);

		$template = 'servicos-impressao';
		$sessionAdmin_user_nivel = session()->get('admin_nivel');

		if ($sessionAdmin_user_nivel == 'cliente') {
			$template = 'servicos-cliente-form';

			$clie_id = (int)session()->get('admin_id');
			$this->pendMD->where('clie_id', $clie_id);
		}

		$query = $this->pendMD->get();

		if ($query && $query->resultID->num_rows >= 1) {
			$rs_dados = $query->getRow();
			$this->data['rs_dados'] = $rs_dados;








			$this->pendTagMD->from('tbl_pendencias_tags As TAG', true)
				->select('TAG.*')
				->select('EQTO.eqto_tag, EQTO.eqto_titulo')
				->join('tbl_equipamentos EQTO', 'EQTO.eqto_id = TAG.eqto_id', 'LEFT');
			$this->pendTagMD->where('TAG.pend_id', $pend_id);
			$this->pendTagMD->orderBy('TAG.pend_id', 'ASC');
			$query_tags = $this->pendTagMD->get();
			//$query_tags = $this->pendTagMD->where('pend_id', $pend_id)->get();
			if ($query_tags && $query_tags->resultID->num_rows >= 1) {
				$this->data['rs_tags'] = $query_tags;
			}

			//Retorno dos materiais utilizados
			$query_mats_utilizados = $this->pendMatMD
				->where('pend_id', $pend_id)
				->where('pend_mat_tipo', 'Utilizado')
				->orderBy('pend_id', 'ASC')
				->get();
			if ($query_mats_utilizados && $query_mats_utilizados->resultID->num_rows >= 1) {
				$this->data['rs_mats_utilizados'] = $query_mats_utilizados;
			}

			//Retorno dos materiais solicitados
			$query_mats_solicitados = $this->pendMatMD
				->where('pend_id', $pend_id)
				->where('pend_mat_tipo', 'Solicitado')
				->orderBy('pend_id', 'ASC')
				->get();
			if ($query_mats_solicitados && $query_mats_solicitados->resultID->num_rows >= 1) {
				$this->data['rs_mats_solicitados'] = $query_mats_solicitados;
			}
		}

		//$query_cliente = $this->clieMD->where('clie_ativo', 1)->get();
		//if( $query_cliente && $query_cliente->resultID->num_rows >=1 )
		//{
		//	$this->data['rs_clientes'] = $query_cliente;
		//}

		//$query_equipamentos = $this->eqtoMD->where('clie_ativo', 1)->get();
		//if( $query_equipamentos && $query_equipamentos->resultID->num_rows >=1 )
		//{
		//	$this->data['rs_equipamento'] = $query_equipamentos;
		//}

		$query_status = $this->categMD->where('categ_area', 'pendencias-status')->get();
		if ($query_status && $query_status->resultID->num_rows >= 1) {
			$this->data['rs_status'] = $query_status;
		}

		$query_tipo_serv = $this->categMD->where('categ_area', 'pendencias-tipo-serv')->get();
		if ($query_tipo_serv && $query_tipo_serv->resultID->num_rows >= 1) {
			$this->data['rs_tipo_serv'] = $query_tipo_serv;
		}

		$query_clientes = $this->clieMD->where('clie_ativo', '1')->get();
		if ($query_clientes && $query_clientes->resultID->num_rows >= 1) {
			$this->data['rs_clientes'] = $query_clientes;
		}

		return view($this->directory . '/servicos-impressao', $this->data);
	}


	public function ajaxform($action = "")
	{
		$error_num = "1";
		$error_msg = "Erro inesperado";
		$redirect = "";

		switch ($action) {
			case "EXCLUIR-PENDENCIA-TAG":

				$pendtag_hashkey = $this->request->getPost('hashkey');
				$queryDeleteTag = $this->pendTagMD->where('pendtag_hashkey', $pendtag_hashkey)->get();
				if ($queryDeleteTag && $queryDeleteTag->resultID->num_rows >= 1) {
					$rs_registro = $queryDeleteTag->getRow();
					$pendtag_id = (int)$rs_registro->pendtag_id;

					// excluir inscricao
					$this->pendTagMD->where('pendtag_hashkey', $pendtag_hashkey)->delete();

					$error_num = "0";
					$error_msg = "Registro excluído com sucesso!";
					$redirect = "";
				}

				$arr_return = array(
					"error_num" => $error_num,
					"error_msg" => $error_msg,
				);

				echo (json_encode($arr_return));
				exit();
				break;

			case "EXCLUIR-PENDENCIA-MAT":
				$pend_mat_hashkey = $this->request->getPost('hashkey');
				$queryDeleteTag = $this->pendMatMD->where('pend_mat_hashkey', $pend_mat_hashkey)->get();
				if ($queryDeleteTag && $queryDeleteTag->resultID->num_rows >= 1) {
					$rs_registro = $queryDeleteTag->getRow();
					$pend_mat_id = (int)$rs_registro->pend_mat_id;

					// excluir inscricao
					$this->pendMatMD->where('pend_mat_hashkey', $pend_mat_hashkey)->delete();

					$error_num = "0";
					$error_msg = "Registro excluído com sucesso!";
					$redirect = "";
				}

				$arr_return = array(
					"error_num" => $error_num,
					"error_msg" => $error_msg,
				);

				echo (json_encode($arr_return));
				exit();
				break;



				$cad_hashkey = $this->request->getPost('cad_hashkey');

				if ($query && $query->resultID->num_rows >= 1) {
					$rs = $query->getRow();
					$cad_id = (int)$rs->cad_id;
					$cad_hashkey = $rs->cad_hashkey;
					$cad_email = $rs->cad_email;
					$cad_cpf = $rs->cad_cpf;
					$cad_nome_completo = $rs->cad_nome_completo;
					$cad_qrcode = $rs->cad_qrcode;

					// caso o Numero do QRCode não exista, geramos um novo
					if (empty($cad_qrcode)) {
						helper('text');
						$num_random = random_string('alnum', 3);
						$num_random = strtoupper($num_random);

						$rand_id = str_pad($cad_id, 4, '0', STR_PAD_LEFT);
						$cad_qrcode = strtoupper('LCSU' . $rand_id . $num_random);
					}

					/*
				* -------------------------------------------------------------
				* Gerar o QRCode e PDF
				* -------------------------------------------------------------
				**/
					$libQRCode->GerarQRCode($cad_qrcode);
					$libQRCode->GerarPDF($cad_qrcode, $cad_nome_completo);

					/*
				* -------------------------------------------------------------
				* log
				* -------------------------------------------------------------
				**/
					$fields_log = [];
					$fields_log['log_ip'] = $_SERVER['REMOTE_ADDR'];
					$fields_log['log_tipo'] = "admin-gerar-pdf";
					$fields_log['cad_id'] = $cad_id;
					$fields_log['cad_qrcode'] = $cad_qrcode;
					$fields_log['cad_cpf'] = $cad_cpf;
					$fields_log['cad_email'] = $cad_email;

					$error_num = "0";
					$error_msg = "Ingresso gerado com sucesso!";
					$redirect = "";

					$arr_return = array(
						"error_num" => $error_num,
						"error_msg" => $error_msg,
					);
				}

				echo (json_encode($arr_return));
				exit();
				break;
		}
	}

	public function exportar()
	{
		if (is_cli()) {
			exit("Este método não pode ser acessado via linha de comando.");
		}
		$cliente = $this->request->getGet('cliente'); // Captura o status da URL (GET)
		$inicio = $this->request->getGet('inicio'); // Captura o inicio da URL (GET)
		$fim = $this->request->getGet('fim'); // Captura o fim da URL (GET)
		$equipamento = $this->request->getGet('equipamento'); // Captura o status da URL (GET)

		$template = 'servicos';
		$sessionAdmin_user_nivel = session()->get('admin_nivel');
		if ($sessionAdmin_user_nivel == 'cliente') {
			$template = 'servicos-cliente';
		}

		$query = $this->pendMD->from('tbl_pendencias As PEND', true)
			->select('PEND.pend_id, CLIE.clie_nome_razao, PEND.pend_dte_instalacao')
			->select('TAG.pendtag_tag, TAG.pendtag_descricao, SERV.categ_titulo AS tipo, CATEG.categ_titulo ')
			->join('tbl_pendencias_tags TAG', 'TAG.pend_id = PEND.pend_id', 'LEFT')
			->join('tbl_categorias SERV', 'SERV.categ_id = TAG.pendtag_tipo_serv', 'LEFT')
			->join('tbl_categorias CATEG', 'CATEG.categ_id = TAG.pendtag_status', 'LEFT')
			->join('tbl_clientes CLIE', 'CLIE.clie_id = PEND.clie_id', 'LEFT');


		$query2 = $this->pendMD2->from('tbl_pendencias As PEND', true)
			->select('PEND.pend_id, CLIE.clie_nome_razao, PEND.pend_dte_instalacao')
			->select('MAT.pend_mat_qtd, MAT.pend_mat_eqto, MAT.pend_mat_material, MAT.pend_mat_observacoes')
			->join('tbl_pendencias_materiais MAT', 'MAT.pend_id = PEND.pend_id', 'LEFT')
			->join('tbl_clientes CLIE', 'CLIE.clie_id = PEND.clie_id', 'LEFT')
			->where('MAT.pend_mat_tipo', 'Utilizado');

		$query3 = $this->pendMD3->from('tbl_pendencias As PEND', true)
			->select('PEND.pend_id, CLIE.clie_nome_razao, PEND.pend_dte_instalacao')
			->select('MAT.pend_mat_qtd, MAT.pend_mat_eqto, MAT.pend_mat_material, 
			MAT.pend_mat_observacoes, MAT.pend_mat_dte_compra, MAT.pend_mat_dte_disponivel, MAT.pend_mat_dte_utilizado')
			->join('tbl_pendencias_materiais MAT', 'MAT.pend_id = PEND.pend_id', 'LEFT')
			->join('tbl_clientes CLIE', 'CLIE.clie_id = PEND.clie_id', 'LEFT')
			->where('MAT.pend_mat_tipo', 'Solicitado');


		if ($sessionAdmin_user_nivel == 'cliente') {
			$clie_id = (int)session()->get('admin_id');
			$this->pendMD->where('PEND.clie_id', $clie_id);
		}

		// Aplica o filtro de status se ele for informado
		if (!empty($cliente)) {
			$query->where('PEND.clie_id', $cliente);
			$query2->where('PEND.clie_id', $cliente);
			$query3->where('PEND.clie_id', $cliente);
		}

		if (!empty($periodicidade)) {
			$query->where('PEND.finc_periodicidade', $periodicidade);
			$query2->where('PEND.finc_periodicidade', $periodicidade);
			$query3->where('PEND.finc_periodicidade', $periodicidade);
		}
		if (!empty($inicio)) {
			$query->where('DATE(PEND.pend_dte_instalacao) >=', date('Y-m-d', strtotime($inicio)));
			$query2->where('DATE(PEND.pend_dte_instalacao) >=', date('Y-m-d', strtotime($inicio)));
			$query3->where('DATE(PEND.pend_dte_instalacao) >=', date('Y-m-d', strtotime($inicio)));
		}
		if (!empty($fim)) {
			$query->where('DATE(PEND.pend_dte_instalacao) <=', date('Y-m-d', strtotime($fim)));
			$query2->where('DATE(PEND.pend_dte_instalacao) <=', date('Y-m-d', strtotime($fim)));
			$query3->where('DATE(PEND.pend_dte_instalacao) <=', date('Y-m-d', strtotime($fim)));
		}
		if (!empty($equipamento)) {
			$query->like('TAG.pendtag_tag', $equipamento);
		}


		$query = $this->pendMD->orderBy('PEND.pend_id', 'DESC');
		$query2 = $this->pendMD2->orderBy('PEND.pend_id', 'DESC');
		$query3 = $this->pendMD3->orderBy('PEND.pend_id', 'DESC');
		$result = $query->get();
		$result2 = $query2->get();
		$result3 = $query3->get();

		if ($result && $result->getNumRows() >= 1) {
			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();
			$sheet->setTitle('Equipamentos');
			// Definir cabeçalhos
			$cabecalho = [
				'ID',
				'Cliente',
				'Data da execução',
				'Equipamento',
				'Descrição',
				'Tipo',
				'Status'
			];
			$sheet->fromArray([$cabecalho], NULL, 'A1');

			// Inserir dados
			$dados = $result->getResultArray();
			$sheet->fromArray($dados, NULL, 'A2');
			// 🟠 Segunda aba (Materiais Utilizados)
			if ($result2 && $result2->getNumRows() >= 1) {
				$spreadsheet->createSheet();
				$sheet2 = $spreadsheet->setActiveSheetIndex(1);
				$sheet2->setTitle('Materiais Utilizados');

				// Definir cabeçalhos
				$cabecalho2 = [
					'ID',
					'Cliente',
					'Data da execução',
					'Quantidade',
					'Equipamento',
					'Tipo',
					'Comentário'
				];
				$sheet2->fromArray([$cabecalho2], NULL, 'A1');

				// Inserir dados
				$dados2 = $result2->getResultArray();
				$sheet2->fromArray($dados2, NULL, 'A2');
			}
			// 🟠 Terceira aba (Materiais Solicitados)
			if ($result3 && $result3->getNumRows() >= 1) {
				$spreadsheet->createSheet();
				$sheet3 = $spreadsheet->setActiveSheetIndex(2);
				$sheet3->setTitle('Materiais Solicitados');

				// Definir cabeçalhos
				$cabecalho3 = [
					'ID',
					'Cliente',
					'Data da execução',
					'Quantidade',
					'Equipamento',
					'Tipo',
					'Comentário',
					'Data da compra',
					'Data Disponível',
					'Data Utilizado'
				];
				$sheet3->fromArray([$cabecalho3], NULL, 'A1');

				// Inserir dados
				$dados3 = $result3->getResultArray();
				$sheet3->fromArray($dados3, NULL, 'A2');
			}

			// Voltar para a primeira aba antes de salvar
			$spreadsheet->setActiveSheetIndex(0);

			// Definir cabeçalhos para download
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment; filename="relatorio.xlsx"');
			header('Cache-Control: max-age=0');

			$writer = new Xlsx($spreadsheet);
			$writer->save('php://output');
			exit;
		} else {
			return redirect()->to(site_url($template))->with('error', 'Nenhum registro encontrado para exportação.');
		}
	}
}
