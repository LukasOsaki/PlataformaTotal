<?php

namespace App\Controllers;

use App\Controllers\PainelController;
use DateTime;

require dirname(__DIR__, 2) . '/vendor/autoload.php';


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Financeiro extends PainelController
{
	protected $fincMD = null;
	protected $fincTipoMD = null;
	protected $fincClassMD = null;
	protected $arqMD = null;
	protected $cfg = null;
	protected $cfgStatus = null;

	public function __construct()
	{
		$this->fincMD = new \App\Models\FinanceiroModel();
		$this->fincTipoMD = new \App\Models\FinanceiroTiposModel();
		$this->fincClassMD = new \App\Models\FinanceiroClassificacoesModel();
		$this->arqMD = new \App\Models\FuncionariosArquivosModel();

		$this->cfg = new \Config\AppSettings();
		$this->cfgStatus = $this->cfg->getStatusDefault();
		$this->data['cfgStatus'] = $this->cfgStatus;
		$this->data['cfgPeriodos'] = $this->cfg->getFinanceiroPeriodo();

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
		$status = $this->request->getGet('status'); // Captura o status da URL (GET)
		$classificacao = $this->request->getGet('classificacao'); // Captura o status da URL (GET)
		$periodicidade = $this->request->getGet('periodicidade'); // Captura o periodicidade da URL (GET)
		$inicio = $this->request->getGet('inicio'); // Captura o inicio da URL (GET)
		$fim = $this->request->getGet('fim'); // Captura o fim da URL (GET)

		$query = $this->fincMD
			->from('tbl_financeiro as FINC', true)
			->select('FINC.*')
			->select('TIPO.finc_tipo_nome')
			->select('CLASS.finc_class_nome')
			->join('tbl_financeiro_tipos TIPO', 'TIPO.finc_tipo_id = FINC.finc_tipo_id')
			->join('tbl_financeiro_classificacoes CLASS', 'CLASS.finc_class_id = FINC.finc_class_id');

		// Aplica o filtro de status se ele for informado
		if (!empty($status)) {
			$query->where('FINC.finc_status', $status);
		}
		if (!empty($classificacao)) {
			$query->where('FINC.finc_class_id', $classificacao);
		}
		if (!empty($periodicidade)) {
			$query->where('FINC.finc_periodicidade', $periodicidade);
		}
		if (!empty($inicio)) {
			$query->where('DATE(FINC.finc_dte_vencimento) >=', date('Y-m-d', strtotime($inicio)));
		}
		if (!empty($fim)) {
			$query->where('DATE(FINC.finc_dte_vencimento) <=', date('Y-m-d', strtotime($fim)));
		}
		$query = $query->orderBy('FINC.finc_id', 'DESC')->get();

		$this->data['lastQuery'] = $this->fincMD->getLastQuery();

		if ($query && $query->resultID->num_rows >= 1) {
			$this->data['rs_list'] = $query;
		}

		//Inclui tipo de contas
		$queryTipo = $this->fincTipoMD
			->where('finc_tipo_ativo', '1')
			->orderBy('finc_tipo_id', 'DESC')
			->get();
		if ($queryTipo && $queryTipo->resultID->num_rows >= 1) {
			$this->data['rs_list_tipo'] = $queryTipo;
		}


		//Inclui classificacoes 

		$queryClass = $this->fincClassMD
			->where('finc_class_ativo', '1')
			->orderBy('finc_class_id', 'DESC')
			->get();
		if ($queryClass && $queryClass->resultID->num_rows >= 1) {
			$this->data['rs_list_class'] = $queryClass;
		}


		// Inclui os filtros para manter na view
		$this->data['selected_status'] = $status;
		$this->data['selected_classificacao'] = $classificacao;
		$this->data['selected_periodicidade'] = $periodicidade;
		$this->data['selected_inicio'] = $inicio;
		$this->data['selected_fim'] = $fim;

		return view($this->directory . '/financeiro', $this->data);
	}


	public function exportar()
	{
		$status = $this->request->getGet('status');
		$classificacao = $this->request->getGet('classificacao');
		$periodicidade = $this->request->getGet('periodicidade');
		$inicio = $this->request->getGet('inicio');
		$fim = $this->request->getGet('fim');


		$query = $this->fincMD
			->from('tbl_financeiro as FINC', true)
			->select('FINC.finc_id, 
		FINC.finc_modalidade,
		TIPO.finc_tipo_nome, 
		CLASS.finc_class_nome,
		FINC.finc_periodicidade, 
		FINC.finc_tipo, 
		FINC.finc_nome, 
		FINC.finc_centro_custo, 
		FINC.finc_nr_parcela, 
		FINC.finc_nr_parcela_total, 
		FINC.finc_valor, 
		FINC.finc_dte_vencimento, 
		FINC.finc_efetuado, 
		FINC.finc_dte_efetuado, 
		FINC.finc_competencia, 
		FINC.finc_nr_doc, 
		FINC.finc_dte_pagamento, 
		FINC.finc_conta, 
		FINC.finc_forma_pagamento, 
		FINC.finc_observacoes, 
		FINC.finc_status, 
		FINC.finc_multa, 
		FINC.finc_juros, 
		FINC.finc_dte_cadastro, 
		FINC.finc_dte_alteracao, 
		')
			->join('tbl_financeiro_tipos TIPO', 'TIPO.finc_tipo_id = FINC.finc_tipo_id')
			->join('tbl_financeiro_classificacoes CLASS', 'CLASS.finc_class_id = FINC.finc_class_id');

		// Aplicar filtros
		if (!empty($status)) {
			$query->where('FINC.finc_status', $status);
		}
		if (!empty($classificacao)) {
			$query->where('FINC.finc_class_id', $classificacao);
		}
		if (!empty($periodicidade)) {
			$query->where('FINC.finc_periodicidade', $periodicidade);
		}
		if (!empty($inicio)) {
			$query->where('DATE(FINC.finc_dte_vencimento) >=', date('Y-m-d', strtotime($inicio)));
		}
		if (!empty($fim)) {
			$query->where('DATE(FINC.finc_dte_vencimento) <=', date('Y-m-d', strtotime($fim)));
		}

		$query->orderBy('FINC.finc_id', 'DESC');
		$result = $query->get();

		if ($result && $result->getNumRows() >= 1) {
			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();

			// Definir cabeçalhos
			$cabecalho = [
				'ID',
				'Modalidade',
				'Tipo',
				'Classificação',
				'Periodicidade',
				'Tipo',
				'Nome',
				'Centro de Custo',
				'Nº Parcela',
				'Total Parcelas',
				'Valor',
				'Data Vencimento',
				'Efetuado',
				'Data Efetuado',
				'Competência',
				'Nº Documento',
				'Data Pagamento',
				'Conta',
				'Forma de Pagamento',
				'Observações',
				'Status',
				'Multa',
				'Juros',
				'Data Cadastro',
				'Data Alteração'
			];
			$sheet->fromArray([$cabecalho], NULL, 'A1');

			// Inserir dados
			$dados = $result->getResultArray();
			$sheet->fromArray($dados, NULL, 'A2');

			// Definir cabeçalhos para download
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment; filename="relatorio.xlsx"');
			header('Cache-Control: max-age=0');

			$writer = new Xlsx($spreadsheet);
			$writer->save('php://output');
			exit;
		} else {
			return redirect()->to(site_url('financeiro'))->with('error', 'Nenhum registro encontrado para exportação.');
		}
	}




	public function form($finc_id = 0)
	{
		$template = 'financeiro-form';
		if ($this->request->getPost()) {
			$validation = \Config\Services::validation();
			$rules = [
				"finc_tipo_id" => [
					"label" => "Tipo de conta",
					"rules" => "required",
					'errors' => [
						'required' => 'Preencha corretamente',
					],
				],
				"finc_class_id" => [
					"label" => "Classificação",
					"rules" => "required",
					'errors' => [
						'required' => 'Preencha corretamente',
					],
				],
				"finc_nome" => [
					"label" => "Nome",
					"rules" => "required",
					'errors' => [
						'required' => 'Preencha corretamente',
					],
				],
				"finc_valor" => [
					"label" => "Valor",
					"rules" => "required",
					'errors' => [
						'required' => 'Preencha corretamente',
					],
				],
			];

			if ($this->validate($rules)) {
				$finc_tipo_id = $this->request->getPost('finc_tipo_id');
				$finc_class_id = $this->request->getPost('finc_class_id');
				$finc_periodicidade = $this->request->getPost('finc_periodicidade');
				$finc_tipo = $this->request->getPost('finc_tipo');
				$finc_nome = $this->request->getPost('finc_nome');
				$finc_centro_custo = $this->request->getPost('finc_centro_custo');
				$finc_nr_parcela = $this->request->getPost('finc_nr_parcela');
				$finc_nr_parcela_total = $this->request->getPost('finc_nr_parcela_total');
				$finc_valor = $this->request->getPost('finc_valor');
				$finc_dte_vencimento = $this->request->getPost('finc_dte_vencimento');
				$finc_efetuado = $this->request->getPost('finc_efetuado');
				$finc_dte_efetuado = $this->request->getPost('finc_dte_efetuado');
				$finc_competencia = $this->request->getPost('finc_competencia');
				$finc_dte_pagamento = $this->request->getPost('finc_dte_pagamento');
				$finc_anotacoes = $this->request->getPost('finc_anotacoes');
				$finc_conta = $this->request->getPost('finc_conta');
				$finc_forma_pagamento = $this->request->getPost('finc_forma_pagamento');
				$finc_observacoes = $this->request->getPost('finc_observacoes');
				$finc_multa = $this->request->getPost('finc_multa');
				$finc_juros = $this->request->getPost('finc_juros');
				$finc_status = $this->request->getPost('finc_status');
				$finc_nr_doc = $this->request->getPost('finc_nr_doc');
				$finc_ativo = (int)$this->request->getPost('finc_ativo');
				$finc_modalidade = $this->request->getPost('finc_modalidade');

				$data_db = [
					'finc_hashkey' => md5(date("Y-m-d H:i:s") . "-" . random_string('alnum', 16)),
					'finc_tipo_id' => $finc_tipo_id,
					'finc_class_id' => $finc_class_id,
					'finc_periodicidade' => $finc_periodicidade,
					'finc_tipo' => $finc_tipo,
					'finc_nome' => $finc_nome,
					'finc_centro_custo' => $finc_centro_custo,
					'finc_nr_parcela' => (int)$finc_nr_parcela,
					'finc_nr_parcela_total' => (int)$finc_nr_parcela_total,
					'finc_valor' => $finc_valor,
					'finc_dte_vencimento' => fct_date2bd($finc_dte_vencimento),
					'finc_efetuado' => (int)$finc_efetuado,
					'finc_dte_efetuado' => fct_date2bd($finc_dte_efetuado),
					'finc_competencia' => $finc_competencia,
					'finc_dte_pagamento' => fct_date2bd($finc_dte_pagamento),
					'finc_anotacoes' => $finc_anotacoes,
					'finc_conta' => $finc_conta,
					'finc_forma_pagamento' => $finc_forma_pagamento,
					'finc_observacoes' => $finc_observacoes,
					'finc_multa' => $finc_multa,
					'finc_juros' => $finc_juros,
					'finc_status' => $finc_status,
					'finc_dte_cadastro' => date("Y-m-d H:i:s"),
					'finc_dte_alteracao' => date("Y-m-d H:i:s"),
					'finc_ativo' => (int)$finc_ativo,
					'finc_nr_doc' => $finc_nr_doc,
					'finc_modalidade' => $finc_modalidade,
				];
				$queryEdit = $this->fincMD->where('finc_id', $finc_id)->get();
				if ($queryEdit && $queryEdit->resultID->num_rows >= 1) {
					unset($data_db['finc_hashkey']);
					unset($data_db['finc_dte_cadastro']);
					$qryExecute = $this->fincMD->update($finc_id, $data_db);
				} else {

					$finc_id = $this->fincMD->insert($data_db);
				}

				// Upload de documentos
				// $args_file = ['file_name' => 'finc_arq_anexo', 'file_prefixo' => 'docs', 'finc_id' => $finc_id];
				// $documentos_upload = self::upload_docs_arquivos($args_file);

				return $this->response->redirect(site_url('financeiro'));
				exit();
			} else {
				$this->data['validation'] = $validation->getErrors();
			}
		}



		$query = $this->fincMD->where('finc_id', $finc_id)->get();
		if ($query && $query->resultID->num_rows >= 1) {
			$rs_dados = $query->getRow();
			$this->data['rs_dados'] = $rs_dados;
		}

		//Inclui tipo de contas
		$queryTipo = $this->fincTipoMD
			->where('finc_tipo_ativo', '1')
			->orderBy('finc_tipo_id', 'DESC')
			->get();
		if ($queryTipo && $queryTipo->resultID->num_rows >= 1) {
			$this->data['rs_list_tipo'] = $queryTipo;
		}


		//Inclui classificacoes 

		$queryClass = $this->fincClassMD
			->where('finc_class_ativo', '1')
			->orderBy('finc_class_id', 'DESC')
			->get();
		if ($queryClass && $queryClass->resultID->num_rows >= 1) {
			$this->data['rs_list_class'] = $queryClass;
		}


		return view($this->directory . '/' . $template, $this->data);
	}


	public function salvar()
	{
		$template = 'financeiro-form';
		if ($this->request->getPost()) {
			$validation = \Config\Services::validation();
			$rules = [
				"lancamentos.*.finc_tipo_id" => [
					"label" => "Tipo de conta",
					"rules" => "required",
					'errors' => [
						'required' => 'Preencha corretamente',
					],
				],
				"lancamentos.*.finc_class_id" => [
					"label" => "Classificação",
					"rules" => "required",
					'errors' => [
						'required' => 'Preencha corretamente',
					],
				],
				"lancamentos.*.finc_nome" => [
					"label" => "Nome",
					"rules" => "required",
					'errors' => [
						'required' => 'Preencha corretamente',
					],
				],
				"lancamentos.*.finc_valor" => [
					"label" => "Valor",
					"rules" => "required|decimal",
					'errors' => [
						'required' => 'Preencha corretamente',
						'decimal' => 'O valor deve ser um número válido',
					],
				],
			];

			if ($this->validate($rules)) {
				$dados_lancamentos = $this->request->getPost('lancamento'); // Array com os lançamentos
				if (!empty($dados_lancamentos)) {
					foreach ($dados_lancamentos as $lancamento) {
						$nr_parcela = (int)$lancamento['finc_nr_parcela'];
						$nr_parcela_total = (int)$lancamento['finc_nr_parcela_total'];
						$periodicidade = $lancamento['finc_periodicidade'];
						$data_vencimento = new DateTime(fct_date2bd($lancamento['finc_dte_vencimento']));
						if ($periodicidade != "AVULSO") {
							for ($i = $nr_parcela; $i <= $nr_parcela_total; $i++) {

								$data_db = [
									'finc_hashkey' => md5(date("Y-m-d H:i:s") . "-" . random_string('alnum', 16)),
									'finc_tipo_id' => $lancamento['finc_tipo_id'],
									'finc_class_id' => $lancamento['finc_class_id'],
									'finc_periodicidade' => $periodicidade,
									'finc_tipo' => $lancamento['finc_tipo'],
									'finc_nome' => $lancamento['finc_nome'],
									'finc_centro_custo' => $lancamento['finc_centro_custo'],
									'finc_nr_parcela' => $i,
									'finc_nr_parcela_total' => $lancamento['finc_nr_parcela_total'],
									'finc_valor' => $lancamento['finc_valor'],
									'finc_dte_vencimento' => $data_vencimento->format('Y-m-d'),
									'finc_efetuado' => (int)$lancamento['finc_efetuado'],
									'finc_dte_efetuado' => fct_date2bd($lancamento['finc_dte_efetuado']),
									'finc_competencia' => $lancamento['finc_competencia'],
									'finc_dte_pagamento' => fct_date2bd($lancamento['finc_dte_pagamento']),
									'finc_conta' => $lancamento['finc_conta'],
									'finc_forma_pagamento' => $lancamento['finc_forma_pagamento'],
									'finc_observacoes' => $lancamento['finc_observacoes'],
									'finc_status' => $lancamento['finc_status'],
									'finc_juros' => $lancamento['finc_juros'],
									'finc_multa' => $lancamento['finc_multa'],
									'finc_dte_cadastro' => date("Y-m-d H:i:s"),
									'finc_dte_alteracao' => date("Y-m-d H:i:s"),
									'finc_ativo' => 1,
									'finc_nr_doc' => $lancamento['finc_nr_doc'],
								];



								$this->fincMD->insert($data_db);
								// Incrementar a data conforme periodicidade
								if ($periodicidade === 'MENSAL') {
									$data_vencimento->modify('+1 month');
								} elseif ($periodicidade === 'ANUAL') {
									$data_vencimento->modify('+1 year');
								}
							}
						} else {
							$data_db = [
								'finc_hashkey' => md5(date("Y-m-d H:i:s") . "-" . random_string('alnum', 16)),
								'finc_tipo_id' => $lancamento['finc_tipo_id'],
								'finc_class_id' => $lancamento['finc_class_id'],
								'finc_periodicidade' => $lancamento['finc_periodicidade'],
								'finc_tipo' => $lancamento['finc_tipo'],
								'finc_nome' => $lancamento['finc_nome'],
								'finc_centro_custo' => $lancamento['finc_centro_custo'],
								'finc_nr_parcela' => (int)$lancamento['finc_nr_parcela'],
								'finc_nr_parcela_total' => (int)$lancamento['finc_nr_parcela_total'],
								'finc_valor' => $lancamento['finc_valor'],
								'finc_dte_vencimento' => fct_date2bd($lancamento['finc_dte_vencimento']),
								'finc_efetuado' => (int)$lancamento['finc_efetuado'],
								'finc_dte_efetuado' => fct_date2bd($lancamento['finc_dte_efetuado']),
								'finc_competencia' => $lancamento['finc_competencia'],
								'finc_dte_pagamento' => fct_date2bd($lancamento['finc_dte_pagamento']),
								// 'finc_anotacoes' => $lancamento['finc_anotacoes'],
								'finc_conta' => $lancamento['finc_conta'],
								'finc_forma_pagamento' => $lancamento['finc_forma_pagamento'],
								'finc_observacoes' => $lancamento['finc_observacoes'],
								'finc_status' => $lancamento['finc_status'],
								'finc_dte_cadastro' => date("Y-m-d H:i:s"),
								'finc_dte_alteracao' => date("Y-m-d H:i:s"),
								'finc_ativo' => 1,
								'finc_nr_doc' => $lancamento['finc_nr_doc'],
								'finc_juros' => $lancamento['finc_juros'],
								'finc_multa' => $lancamento['finc_multa'],
								'finc_modalidade' => $lancamento['finc_modalidade'],
							];
							$this->fincMD->insert($data_db);
						}
					}
				}
				return $this->response->redirect(site_url('financeiro'));
				exit();
			} else {
				$errors = $validation->getErrors();
				$validationWithLabels = [];

				foreach ($rules as $field => $rule) {
					if (isset($errors[$field])) {
						$validationWithLabels[$rule['label']] = $errors[$field]; // Usa o label no lugar do campo
					}
				}

				$this->data['validation'] = $validationWithLabels; // Agora contém label + erro
			}
		}

		//Inclui tipo de contas
		$queryTipo = $this->fincTipoMD
			->where('finc_tipo_ativo', '1')
			->orderBy('finc_tipo_id', 'DESC')
			->get();
		if ($queryTipo && $queryTipo->resultID->num_rows >= 1) {
			$this->data['rs_list_tipo'] = $queryTipo;
		}

		//Inclui classificacoes 
		$queryClass = $this->fincClassMD
			->where('finc_class_ativo', '1')
			->orderBy('finc_class_id', 'DESC')
			->get();
		if ($queryClass && $queryClass->resultID->num_rows >= 1) {
			$this->data['rs_list_class'] = $queryClass;
		}

		return view($this->directory . '/' . $template, $this->data);
	}



	public function upload_docs_arquivos($args = [])
	{
		$file_name = (isset($args['file_name']) ? $args['file_name'] : '');
		$file_prefixo = (isset($args['file_prefixo']) ? $args['file_prefixo'] : '');
		$finc_id = (int)(isset($args['finc_id']) ? $args['finc_id'] : '');

		// Verifica se há arquivos para upload
		if ($this->request->getFiles()) {
			$arr_arq_nome_doc = $this->request->getPost('finc_arq_nome_doc');
			$arr_arq_data = $this->request->getPost('finc_arq_data');
			$arr_arq_validade = $this->request->getPost('finc_arq_validade');
			$arr_arq_tipo = $this->request->getPost('finc_arq_tipo');
			$arr_arq_status = $this->request->getPost('finc_arq_status');

			// Define o diretório de destino para os uploads
			$path_upload = $this->folder_upload . 'fincionarios/';

			foreach ($arr_arq_nome_doc as $keyDoc => $valDoc) {
				$arq_hash_item = $keyDoc;
				$arq_nome_doc = $valDoc;
				$arq_data = (isset($arr_arq_data[$keyDoc]) ? $arr_arq_data[$keyDoc] : '');
				$arq_validade = (isset($arr_arq_validade[$keyDoc]) ? $arr_arq_validade[$keyDoc] : '');
				$arq_status = (int)(isset($arr_arq_status[$keyDoc]) ? $arr_arq_status[$keyDoc] : '');
				$arq_tipo = (isset($arr_arq_tipo[$keyDoc]) ? $arr_arq_tipo[$keyDoc] : '');

				// Verifica se o arquivo já foi enviado antes
				// $existing_file = $this->arqMD->where('finc_id', $finc_id)
				// 	->where('arq_hash_item', $arq_hash_item)
				// 	->first();
				// if ($existing_file) {
				// 	// Se o arquivo já existe, não faça o upload novamente
				// 	continue;
				// }

				// Nome do arquivo
				$file_name = 'finc_arq_anexo_' . $arq_hash_item;

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
					'finc_id' => (int)$finc_id,
					'finc_arq_hashkey' => md5(date("Y-m-d H:i:s") . "-" . random_string('alnum', 16)),
					'finc_arq_urlpage' => url_title(convert_accented_characters($arq_nome_doc), '-', TRUE),
					'finc_arq_hash_item' => $arq_hash_item,
					'finc_arq_nome_doc' => $arq_nome_doc,
					'finc_arq_anexo' => $newARQUIVO,
					'finc_arq_data' => fct_date2bd($arq_data),
					'finc_arq_validade' => fct_date2bd($arq_validade),
					'finc_arq_status' => $arq_status,
					'finc_arq_tipo' => $arq_tipo,
					'finc_arq_dte_cadastro' => date("Y-m-d H:i:s"),
					'finc_arq_dte_alteracao' => date("Y-m-d H:i:s"),
					'finc_arq_ativo' => (int)$arq_status
				];
				$existing_file = $this->arqMD->where('finc_id', $finc_id)
					->where('finc_arq_hash_item', $arq_hash_item)
					->first();
				if ($existing_file) {
					// Se o 'arq_anexo' for uma string vazia, pega o valor do arquivo existente
					if ($newARQUIVO === '') {
						$newARQUIVO = $existing_file->finc_arq_anexo;
					}

					// Atualiza os dados do arquivo no banco de dados
					$data_arq_db['finc_arq_anexo'] = $newARQUIVO;
					// Atualiza o arquivo na base de dados
					$this->arqMD->update($existing_file->finc_arq_id, $data_arq_db);
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
				$finc_id = (int)$this->request->getPost('finc_id');
				$arq_hashkey = $this->request->getPost('finc_arq_hashkey');
				if (!empty($arq_hashkey)) {
					$query = $this->arqMD
						->where('finc_id', $finc_id)
						->where('finc_arq_hashkey', $arq_hashkey)
						->limit(1)
						->get();
					if ($query && $query->resultID->num_rows >= 1) {
						$rs_dados = $query->getRow();
						$this->arqMD->where('finc_id', $finc_id);
						$this->arqMD->where('finc_arq_hashkey', $arq_hashkey);
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

	//Equipe

	public function equipe()
	{

		$sessionAdmin_user_nivel = session()->get('admin_nivel');
		// if ($sessionAdmin_user_nivel == 'cliente') {
		// 	return $this->response->redirect(site_url('clientes/form'));
		// }

		return self::filtrarEquipe();
	}

	public function filtrarEquipe()
	{
		$template = 'financeiro-equipe';
		$status = $this->request->getGet('status'); // Captura o status da URL (GET)
		$classificacao = $this->request->getGet('classificacao'); // Captura o status da URL (GET)
		$periodicidade = $this->request->getGet('periodicidade'); // Captura o periodicidade da URL (GET)
		$inicio = $this->request->getGet('inicio'); // Captura o inicio da URL (GET)
		$fim = $this->request->getGet('fim'); // Captura o fim da URL (GET)


		$query = $this->fincMD
			->from('tbl_financeiro as FINC', true)
			->select('FINC.*')
			->select('TIPO.finc_tipo_nome')
			->select('CLASS.finc_class_nome')
			->join('tbl_financeiro_tipos TIPO', 'TIPO.finc_tipo_id = FINC.finc_tipo_id')
			->join('tbl_financeiro_classificacoes CLASS', 'CLASS.finc_class_id = FINC.finc_class_id')
			->where('FINC.finc_modalidade', 'EQUIPE')
			->where('FINC.finc_ativo', '1');

		// Aplica o filtro de status se ele for informado
		if (!empty($status)) {
			$query->where('FINC.finc_status', $status);
		}
		if (!empty($classificacao)) {
			$query->where('FINC.finc_class_id', $classificacao);
		}
		if (!empty($periodicidade)) {
			$query->where('FINC.finc_periodicidade', $periodicidade);
		}
		if (!empty($inicio)) {
			$query->where('DATE(FINC.finc_dte_vencimento) >=', date('Y-m-d', strtotime($inicio)));
		}
		if (!empty($fim)) {
			$query->where('DATE(FINC.finc_dte_vencimento) <=', date('Y-m-d', strtotime($fim)));
		}
		$query = $query->orderBy('FINC.finc_id', 'DESC')->get();

		$this->data['lastQuery'] = $this->fincMD->getLastQuery();

		if ($query && $query->resultID->num_rows >= 1) {
			$this->data['rs_list'] = $query;
		}

		//Inclui tipo de contas
		$queryTipo = $this->fincTipoMD
			->where('finc_tipo_ativo', '1')
			->orderBy('finc_tipo_id', 'DESC')
			->get();
		if ($queryTipo && $queryTipo->resultID->num_rows >= 1) {
			$this->data['rs_list_tipo'] = $queryTipo;
		}


		//Inclui classificacoes 

		$queryClass = $this->fincClassMD
			->where('finc_class_ativo', '1')
			->orderBy('finc_class_id', 'DESC')
			->where('finc_class_modalidade !=', 'GERENCIAL')
			->get();
		if ($queryClass && $queryClass->resultID->num_rows >= 1) {
			$this->data['rs_list_class'] = $queryClass;
		}


		// Inclui os filtros para manter na view
		$this->data['selected_status'] = $status;
		$this->data['selected_classificacao'] = $classificacao;
		$this->data['selected_periodicidade'] = $periodicidade;
		$this->data['selected_inicio'] = $inicio;
		$this->data['selected_fim'] = $fim;

		return view($this->directory . '/' . $template, $this->data);
	}

	public function exportarEquipe()
	{
		$status = $this->request->getGet('status');
		$classificacao = $this->request->getGet('classificacao');
		$periodicidade = $this->request->getGet('periodicidade');
		$inicio = $this->request->getGet('inicio');
		$fim = $this->request->getGet('fim');


		$query = $this->fincMD
			->from('tbl_financeiro as FINC', true)
			->select('FINC.finc_id, 
		FINC.finc_modalidade,
		TIPO.finc_tipo_nome, 
		CLASS.finc_class_nome,
		FINC.finc_periodicidade, 
		FINC.finc_tipo, 
		FINC.finc_nome, 
		FINC.finc_centro_custo, 
		FINC.finc_nr_parcela, 
		FINC.finc_nr_parcela_total, 
		FINC.finc_valor, 
		FINC.finc_dte_vencimento, 
		FINC.finc_efetuado, 
		FINC.finc_dte_efetuado, 
		FINC.finc_competencia, 
		FINC.finc_nr_doc, 
		FINC.finc_dte_pagamento, 
		FINC.finc_conta, 
		FINC.finc_forma_pagamento, 
		FINC.finc_observacoes, 
		FINC.finc_status, 
		FINC.finc_multa, 
		FINC.finc_juros, 
		FINC.finc_dte_cadastro, 
		FINC.finc_dte_alteracao, 
		')
			->join('tbl_financeiro_tipos TIPO', 'TIPO.finc_tipo_id = FINC.finc_tipo_id')
			->join('tbl_financeiro_classificacoes CLASS', 'CLASS.finc_class_id = FINC.finc_class_id')
			->where('FINC.finc_modalidade', 'EQUIPE')
			->where('FINC.finc_ativo', '1');

		// Aplicar filtros
		if (!empty($status)) {
			$query->where('FINC.finc_status', $status);
		}
		if (!empty($classificacao)) {
			$query->where('FINC.finc_class_id', $classificacao);
		}
		if (!empty($periodicidade)) {
			$query->where('FINC.finc_periodicidade', $periodicidade);
		}
		if (!empty($inicio)) {
			$query->where('DATE(FINC.finc_dte_vencimento) >=', date('Y-m-d', strtotime($inicio)));
		}
		if (!empty($fim)) {
			$query->where('DATE(FINC.finc_dte_vencimento) <=', date('Y-m-d', strtotime($fim)));
		}

		$query->orderBy('FINC.finc_id', 'DESC');
		$result = $query->get();

		if ($result && $result->getNumRows() >= 1) {
			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();

			// Definir cabeçalhos
			$cabecalho = [
				'ID',
				'Modalidade',
				'Tipo',
				'Classificação',
				'Periodicidade',
				'Tipo',
				'Nome',
				'Centro de Custo',
				'Nº Parcela',
				'Total Parcelas',
				'Valor',
				'Data Vencimento',
				'Efetuado',
				'Data Efetuado',
				'Competência',
				'Nº Documento',
				'Data Pagamento',
				'Conta',
				'Forma de Pagamento',
				'Observações',
				'Status',
				'Multa',
				'Juros',
				'Data Cadastro',
				'Data Alteração'
			];
			$sheet->fromArray([$cabecalho], NULL, 'A1');

			// Inserir dados
			$dados = $result->getResultArray();
			$sheet->fromArray($dados, NULL, 'A2');

			// Definir cabeçalhos para download
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment; filename="relatorio.xlsx"');
			header('Cache-Control: max-age=0');

			$writer = new Xlsx($spreadsheet);
			$writer->save('php://output');
			exit;
		} else {
			return redirect()->to(site_url('financeiro/equipe'))->with('error', 'Nenhum registro encontrado para exportação.');
		}
	}

	public function formEquipe($finc_id = 0)
	{
		$template = 'financeiro-equipe-form';
		if ($this->request->getPost()) {
			$validation = \Config\Services::validation();
			$rules = [
				"finc_tipo_id" => [
					"label" => "Tipo de conta",
					"rules" => "required",
					'errors' => [
						'required' => 'Preencha corretamente',
					],
				],
				"finc_class_id" => [
					"label" => "Classificação",
					"rules" => "required",
					'errors' => [
						'required' => 'Preencha corretamente',
					],
				],
				"finc_nome" => [
					"label" => "Nome",
					"rules" => "required",
					'errors' => [
						'required' => 'Preencha corretamente',
					],
				],
				"finc_valor" => [
					"label" => "Valor",
					"rules" => "required",
					'errors' => [
						'required' => 'Preencha corretamente',
					],
				],
			];

			if ($this->validate($rules)) {
				$finc_tipo_id = $this->request->getPost('finc_tipo_id');
				$finc_class_id = $this->request->getPost('finc_class_id');
				$finc_periodicidade = $this->request->getPost('finc_periodicidade');
				$finc_tipo = $this->request->getPost('finc_tipo');
				$finc_nome = $this->request->getPost('finc_nome');
				$finc_centro_custo = $this->request->getPost('finc_centro_custo');
				$finc_nr_parcela = $this->request->getPost('finc_nr_parcela');
				$finc_nr_parcela_total = $this->request->getPost('finc_nr_parcela_total');
				$finc_valor = $this->request->getPost('finc_valor');
				$finc_dte_vencimento = $this->request->getPost('finc_dte_vencimento');
				$finc_efetuado = $this->request->getPost('finc_efetuado');
				$finc_dte_efetuado = $this->request->getPost('finc_dte_efetuado');
				$finc_competencia = $this->request->getPost('finc_competencia');
				$finc_dte_pagamento = $this->request->getPost('finc_dte_pagamento');
				$finc_anotacoes = $this->request->getPost('finc_anotacoes');
				$finc_conta = $this->request->getPost('finc_conta');
				$finc_forma_pagamento = $this->request->getPost('finc_forma_pagamento');
				$finc_observacoes = $this->request->getPost('finc_observacoes');
				$finc_multa = $this->request->getPost('finc_multa');
				$finc_juros = $this->request->getPost('finc_juros');
				$finc_status = $this->request->getPost('finc_status');
				$finc_nr_doc = $this->request->getPost('finc_nr_doc');
				$finc_ativo = (int)$this->request->getPost('finc_ativo');

				$data_db = [
					'finc_hashkey' => md5(date("Y-m-d H:i:s") . "-" . random_string('alnum', 16)),
					'finc_tipo_id' => $finc_tipo_id,
					'finc_class_id' => $finc_class_id,
					'finc_periodicidade' => $finc_periodicidade,
					'finc_tipo' => $finc_tipo,
					'finc_nome' => $finc_nome,
					'finc_centro_custo' => $finc_centro_custo,
					'finc_nr_parcela' => (int)$finc_nr_parcela,
					'finc_nr_parcela_total' => (int)$finc_nr_parcela_total,
					'finc_valor' => $finc_valor,
					'finc_dte_vencimento' => fct_date2bd($finc_dte_vencimento),
					'finc_efetuado' => (int)$finc_efetuado,
					'finc_dte_efetuado' => fct_date2bd($finc_dte_efetuado),
					'finc_competencia' => $finc_competencia,
					'finc_dte_pagamento' => fct_date2bd($finc_dte_pagamento),
					'finc_anotacoes' => $finc_anotacoes,
					'finc_conta' => $finc_conta,
					'finc_forma_pagamento' => $finc_forma_pagamento,
					'finc_observacoes' => $finc_observacoes,
					'finc_multa' => $finc_multa,
					'finc_juros' => $finc_juros,
					'finc_status' => $finc_status,
					'finc_dte_cadastro' => date("Y-m-d H:i:s"),
					'finc_dte_alteracao' => date("Y-m-d H:i:s"),
					'finc_ativo' => (int)$finc_ativo,
					'finc_nr_doc' => $finc_nr_doc,
					'finc_modalidade' => "EQUIPE",
				];

				$queryEdit = $this->fincMD->where('finc_id', $finc_id)->get();
				if ($queryEdit && $queryEdit->resultID->num_rows >= 1) {
					unset($data_db['finc_hashkey']);
					unset($data_db['finc_dte_cadastro']);
					$qryExecute = $this->fincMD->update($finc_id, $data_db);
				} else {

					$finc_id = $this->fincMD->insert($data_db);
				}

				return $this->response->redirect(site_url('financeiro/equipe'));
				exit();
			} else {
				$errors = $validation->getErrors();
				$validationWithLabels = [];

				foreach ($rules as $field => $rule) {
					if (isset($errors[$field])) {
						$validationWithLabels[$rule['label']] = $errors[$field]; // Usa o label no lugar do campo
					}
				}

				$this->data['validation'] = $validationWithLabels; // Agora contém label + erro
			}
		}



		$query = $this->fincMD->where('finc_id', $finc_id)->get();
		if ($query && $query->resultID->num_rows >= 1) {
			$rs_dados = $query->getRow();
			$this->data['rs_dados'] = $rs_dados;
		}

		//Inclui tipo de contas
		$queryTipo = $this->fincTipoMD
			->where('finc_tipo_ativo', '1')
			->orderBy('finc_tipo_id', 'DESC')
			->get();
		if ($queryTipo && $queryTipo->resultID->num_rows >= 1) {
			$this->data['rs_list_tipo'] = $queryTipo;
		}


		//Inclui classificacoes 

		$queryClass = $this->fincClassMD
			->where('finc_class_ativo', '1')
			->where('finc_class_modalidade !=', 'GERENCIAL')
			->orderBy('finc_class_id', 'DESC')
			->get();
		if ($queryClass && $queryClass->resultID->num_rows >= 1) {
			$this->data['rs_list_class'] = $queryClass;
		}

		return view($this->directory . '/' . $template, $this->data);
	}

	public function salvarEquipe()
	{
		$template = 'financeiro-equipe-form';
		if ($this->request->getPost()) {

			$dados_lancamentos = $this->request->getPost('lancamento'); // Array com os lançamentos
			if (!empty($dados_lancamentos)) {
				foreach ($dados_lancamentos as $lancamento) {
					$nr_parcela = (int)$lancamento['finc_nr_parcela'];
					$nr_parcela_total = (int)$lancamento['finc_nr_parcela_total'];
					$periodicidade = $lancamento['finc_periodicidade'];
					$data_vencimento = new DateTime(fct_date2bd($lancamento['finc_dte_vencimento']));
					if ($periodicidade != "AVULSO") {
						for ($i = $nr_parcela; $i <= $nr_parcela_total; $i++) {

							$data_db = [
								'finc_hashkey' => md5(date("Y-m-d H:i:s") . "-" . random_string('alnum', 16)),
								'finc_tipo_id' => $lancamento['finc_tipo_id'],
								'finc_class_id' => $lancamento['finc_class_id'],
								'finc_periodicidade' => $periodicidade,
								'finc_tipo' => $lancamento['finc_tipo'],
								'finc_nome' => $lancamento['finc_nome'],
								'finc_centro_custo' => $lancamento['finc_centro_custo'],
								'finc_nr_parcela' => $i,
								'finc_nr_parcela_total' => $lancamento['finc_nr_parcela_total'],
								'finc_valor' => $lancamento['finc_valor'],
								'finc_dte_vencimento' => $data_vencimento->format('Y-m-d'),
								'finc_efetuado' => (int)$lancamento['finc_efetuado'],
								'finc_dte_efetuado' => fct_date2bd($lancamento['finc_dte_efetuado']),
								'finc_competencia' => $lancamento['finc_competencia'],
								'finc_dte_pagamento' => fct_date2bd($lancamento['finc_dte_pagamento']),
								'finc_conta' => $lancamento['finc_conta'],
								'finc_forma_pagamento' => $lancamento['finc_forma_pagamento'],
								'finc_observacoes' => $lancamento['finc_observacoes'],
								'finc_status' => $lancamento['finc_status'],
								'finc_juros' => $lancamento['finc_juros'],
								'finc_multa' => $lancamento['finc_multa'],
								'finc_dte_cadastro' => date("Y-m-d H:i:s"),
								'finc_dte_alteracao' => date("Y-m-d H:i:s"),
								'finc_ativo' => 1,
								'finc_nr_doc' => $lancamento['finc_nr_doc'],
								'finc_modalidade' => "EQUIPE",
							];



							$this->fincMD->insert($data_db);
							// Incrementar a data conforme periodicidade
							if ($periodicidade === 'MENSAL') {
								$data_vencimento->modify('+1 month');
							} elseif ($periodicidade === 'ANUAL') {
								$data_vencimento->modify('+1 year');
							}
						}
					} else {
						$data_db = [
							'finc_hashkey' => md5(date("Y-m-d H:i:s") . "-" . random_string('alnum', 16)),
							'finc_tipo_id' => $lancamento['finc_tipo_id'],
							'finc_class_id' => $lancamento['finc_class_id'],
							'finc_periodicidade' => $lancamento['finc_periodicidade'],
							'finc_tipo' => $lancamento['finc_tipo'],
							'finc_nome' => $lancamento['finc_nome'],
							'finc_centro_custo' => $lancamento['finc_centro_custo'],
							'finc_nr_parcela' => (int)$lancamento['finc_nr_parcela'],
							'finc_nr_parcela_total' => (int)$lancamento['finc_nr_parcela_total'],
							'finc_valor' => $lancamento['finc_valor'],
							'finc_dte_vencimento' => fct_date2bd($lancamento['finc_dte_vencimento']),
							'finc_efetuado' => (int)$lancamento['finc_efetuado'],
							'finc_dte_efetuado' => fct_date2bd($lancamento['finc_dte_efetuado']),
							'finc_competencia' => $lancamento['finc_competencia'],
							'finc_dte_pagamento' => fct_date2bd($lancamento['finc_dte_pagamento']),
							// 'finc_anotacoes' => $lancamento['finc_anotacoes'],
							'finc_conta' => $lancamento['finc_conta'],
							'finc_forma_pagamento' => $lancamento['finc_forma_pagamento'],
							'finc_observacoes' => $lancamento['finc_observacoes'],
							'finc_status' => $lancamento['finc_status'],
							'finc_dte_cadastro' => date("Y-m-d H:i:s"),
							'finc_dte_alteracao' => date("Y-m-d H:i:s"),
							'finc_ativo' => 1,
							'finc_nr_doc' => $lancamento['finc_nr_doc'],
							'finc_juros' => $lancamento['finc_juros'],
							'finc_multa' => $lancamento['finc_multa'],
							'finc_modalidade' => "EQUIPE",
						];

						$this->fincMD->insert($data_db);
					}
				}
			}
			return $this->response->redirect(site_url('financeiro'));
			exit();
		}

		//Inclui tipo de contas
		$queryTipo = $this->fincTipoMD
			->where('finc_tipo_ativo', '1')
			->orderBy('finc_tipo_id', 'DESC')
			->get();
		if ($queryTipo && $queryTipo->resultID->num_rows >= 1) {
			$this->data['rs_list_tipo'] = $queryTipo;
		}

		//Inclui classificacoes 
		$queryClass = $this->fincClassMD
			->where('finc_class_ativo', '1')
			->where('finc_class_modalidade !=', 'GERENCIAL')
			->orderBy('finc_class_id', 'DESC')
			->get();
		if ($queryClass && $queryClass->resultID->num_rows >= 1) {
			$this->data['rs_list_class'] = $queryClass;
		}

		return view($this->directory . '/' . $template, $this->data);
	}

	//Gerencial

	public function gerencial()
	{

		$sessionAdmin_user_nivel = session()->get('admin_nivel');
		// if ($sessionAdmin_user_nivel == 'cliente') {
		// 	return $this->response->redirect(site_url('clientes/form'));
		// }

		return self::filtrarGerencial();
	}

	public function filtrarGerencial()
	{
		$template = 'financeiro-gerencial';
		$status = $this->request->getGet('status'); // Captura o status da URL (GET)
		$classificacao = $this->request->getGet('classificacao'); // Captura o status da URL (GET)
		$periodicidade = $this->request->getGet('periodicidade'); // Captura o periodicidade da URL (GET)
		$inicio = $this->request->getGet('inicio'); // Captura o inicio da URL (GET)
		$fim = $this->request->getGet('fim'); // Captura o fim da URL (GET)


		$query = $this->fincMD
			->from('tbl_financeiro as FINC', true)
			->select('FINC.*')
			->select('TIPO.finc_tipo_nome')
			->select('CLASS.finc_class_nome')
			->join('tbl_financeiro_tipos TIPO', 'TIPO.finc_tipo_id = FINC.finc_tipo_id')
			->join('tbl_financeiro_classificacoes CLASS', 'CLASS.finc_class_id = FINC.finc_class_id')
			->where('FINC.finc_modalidade', 'GERENCIAL')
			->where('FINC.finc_ativo', '1');

		// Aplica o filtro de status se ele for informado
		if (!empty($status)) {
			$query->where('FINC.finc_status', $status);
		}
		if (!empty($classificacao)) {
			$query->where('FINC.finc_class_id', $classificacao);
		}
		if (!empty($periodicidade)) {
			$query->where('FINC.finc_periodicidade', $periodicidade);
		}
		if (!empty($inicio)) {
			$query->where('DATE(FINC.finc_dte_vencimento) >=', date('Y-m-d', strtotime($inicio)));
		}
		if (!empty($fim)) {
			$query->where('DATE(FINC.finc_dte_vencimento) <=', date('Y-m-d', strtotime($fim)));
		}
		$query = $query->orderBy('FINC.finc_id', 'DESC')->get();

		$this->data['lastQuery'] = $this->fincMD->getLastQuery();

		if ($query && $query->resultID->num_rows >= 1) {
			$this->data['rs_list'] = $query;
		}

		//Inclui tipo de contas
		$queryTipo = $this->fincTipoMD
			->where('finc_tipo_ativo', '1')
			->orderBy('finc_tipo_id', 'DESC')
			->get();
		if ($queryTipo && $queryTipo->resultID->num_rows >= 1) {
			$this->data['rs_list_tipo'] = $queryTipo;
		}


		//Inclui classificacoes 

		$queryClass = $this->fincClassMD
			->where('finc_class_ativo', '1')
			->orderBy('finc_class_id', 'DESC')
			->where('finc_class_modalidade !=', 'EQUIPE')
			->get();
		if ($queryClass && $queryClass->resultID->num_rows >= 1) {
			$this->data['rs_list_class'] = $queryClass;
		}


		// Inclui os filtros para manter na view
		$this->data['selected_status'] = $status;
		$this->data['selected_classificacao'] = $classificacao;
		$this->data['selected_periodicidade'] = $periodicidade;
		$this->data['selected_inicio'] = $inicio;
		$this->data['selected_fim'] = $fim;

		return view($this->directory . '/' . $template, $this->data);
	}

	public function exportarGerencial()
	{
		$status = $this->request->getGet('status');
		$classificacao = $this->request->getGet('classificacao');
		$periodicidade = $this->request->getGet('periodicidade');
		$inicio = $this->request->getGet('inicio');
		$fim = $this->request->getGet('fim');


		$query = $this->fincMD
			->from('tbl_financeiro as FINC', true)
			->select('FINC.finc_id, 
		FINC.finc_modalidade,
		TIPO.finc_tipo_nome, 
		CLASS.finc_class_nome,
		FINC.finc_periodicidade, 
		FINC.finc_tipo, 
		FINC.finc_nome, 
		FINC.finc_centro_custo, 
		FINC.finc_nr_parcela, 
		FINC.finc_nr_parcela_total, 
		FINC.finc_valor, 
		FINC.finc_dte_vencimento, 
		FINC.finc_efetuado, 
		FINC.finc_dte_efetuado, 
		FINC.finc_competencia, 
		FINC.finc_nr_doc, 
		FINC.finc_dte_pagamento, 
		FINC.finc_conta, 
		FINC.finc_forma_pagamento, 
		FINC.finc_observacoes, 
		FINC.finc_status, 
		FINC.finc_multa, 
		FINC.finc_juros, 
		FINC.finc_dte_cadastro, 
		FINC.finc_dte_alteracao, 
		')
			->join('tbl_financeiro_tipos TIPO', 'TIPO.finc_tipo_id = FINC.finc_tipo_id')
			->join('tbl_financeiro_classificacoes CLASS', 'CLASS.finc_class_id = FINC.finc_class_id')
			->where('FINC.finc_modalidade', 'GERENCIAL')
			->where('FINC.finc_ativo', '1');

		// Aplicar filtros
		if (!empty($status)) {
			$query->where('FINC.finc_status', $status);
		}
		if (!empty($classificacao)) {
			$query->where('FINC.finc_class_id', $classificacao);
		}
		if (!empty($periodicidade)) {
			$query->where('FINC.finc_periodicidade', $periodicidade);
		}
		if (!empty($inicio)) {
			$query->where('DATE(FINC.finc_dte_vencimento) >=', date('Y-m-d', strtotime($inicio)));
		}
		if (!empty($fim)) {
			$query->where('DATE(FINC.finc_dte_vencimento) <=', date('Y-m-d', strtotime($fim)));
		}

		$query->orderBy('FINC.finc_id', 'DESC');
		$result = $query->get();

		if ($result && $result->getNumRows() >= 1) {
			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();

			// Definir cabeçalhos
			$cabecalho = [
				'ID',
				'Modalidade',
				'Tipo',
				'Classificação',
				'Periodicidade',
				'Tipo',
				'Nome',
				'Centro de Custo',
				'Nº Parcela',
				'Total Parcelas',
				'Valor',
				'Data Vencimento',
				'Efetuado',
				'Data Efetuado',
				'Competência',
				'Nº Documento',
				'Data Pagamento',
				'Conta',
				'Forma de Pagamento',
				'Observações',
				'Status',
				'Multa',
				'Juros',
				'Data Cadastro',
				'Data Alteração',
			];
			$sheet->fromArray([$cabecalho], NULL, 'A1');

			// Inserir dados
			$dados = $result->getResultArray();
			$sheet->fromArray($dados, NULL, 'A2');

			// Definir cabeçalhos para download
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment; filename="relatorio.xlsx"');
			header('Cache-Control: max-age=0');

			$writer = new Xlsx($spreadsheet);
			$writer->save('php://output');
			exit;
		} else {
			return redirect()->to(site_url('financeiro/gerencial'))->with('error', 'Nenhum registro encontrado para exportação.');
		}
	}

	public function formGerencial($finc_id = 0)
	{
		$template = 'financeiro-gerencial-form';
		if ($this->request->getPost()) {
			$validation = \Config\Services::validation();
			$rules = [
				"finc_tipo_id" => [
					"label" => "Tipo de conta",
					"rules" => "required",
					'errors' => [
						'required' => 'Preencha corretamente',
					],
				],
				"finc_class_id" => [
					"label" => "Classificação",
					"rules" => "required",
					'errors' => [
						'required' => 'Preencha corretamente',
					],
				],
				"finc_nome" => [
					"label" => "Nome",
					"rules" => "required",
					'errors' => [
						'required' => 'Preencha corretamente',
					],
				],
				"finc_valor" => [
					"label" => "Valor",
					"rules" => "required",
					'errors' => [
						'required' => 'Preencha corretamente',
					],
				],
			];

			if ($this->validate($rules)) {

				$finc_tipo_id = $this->request->getPost('finc_tipo_id');
				$finc_class_id = $this->request->getPost('finc_class_id');
				$finc_periodicidade = $this->request->getPost('finc_periodicidade');
				$finc_tipo = $this->request->getPost('finc_tipo');
				$finc_nome = $this->request->getPost('finc_nome');
				$finc_centro_custo = $this->request->getPost('finc_centro_custo');
				$finc_nr_parcela = $this->request->getPost('finc_nr_parcela');
				$finc_nr_parcela_total = $this->request->getPost('finc_nr_parcela_total');
				$finc_valor = $this->request->getPost('finc_valor');
				$finc_dte_vencimento = $this->request->getPost('finc_dte_vencimento');
				$finc_efetuado = $this->request->getPost('finc_efetuado');
				$finc_dte_efetuado = $this->request->getPost('finc_dte_efetuado');
				$finc_competencia = $this->request->getPost('finc_competencia');
				$finc_dte_pagamento = $this->request->getPost('finc_dte_pagamento');
				$finc_anotacoes = $this->request->getPost('finc_anotacoes');
				$finc_conta = $this->request->getPost('finc_conta');
				$finc_forma_pagamento = $this->request->getPost('finc_forma_pagamento');
				$finc_observacoes = $this->request->getPost('finc_observacoes');
				$finc_multa = $this->request->getPost('finc_multa');
				$finc_juros = $this->request->getPost('finc_juros');
				$finc_status = $this->request->getPost('finc_status');
				$finc_nr_doc = $this->request->getPost('finc_nr_doc');
				$finc_ativo = (int)$this->request->getPost('finc_ativo');
				$data_db = [
					'finc_hashkey' => md5(date("Y-m-d H:i:s") . "-" . random_string('alnum', 16)),
					'finc_tipo_id' => $finc_tipo_id,
					'finc_class_id' => $finc_class_id,
					'finc_periodicidade' => $finc_periodicidade,
					'finc_tipo' => $finc_tipo,
					'finc_nome' => $finc_nome,
					'finc_centro_custo' => $finc_centro_custo,
					'finc_nr_parcela' => (int)$finc_nr_parcela,
					'finc_nr_parcela_total' => (int)$finc_nr_parcela_total,
					'finc_valor' => $finc_valor,
					'finc_dte_vencimento' => fct_date2bd($finc_dte_vencimento),
					'finc_efetuado' => (int)$finc_efetuado,
					'finc_dte_efetuado' => fct_date2bd($finc_dte_efetuado),
					'finc_competencia' => $finc_competencia,
					'finc_dte_pagamento' => fct_date2bd($finc_dte_pagamento),
					'finc_anotacoes' => $finc_anotacoes,
					'finc_conta' => $finc_conta,
					'finc_forma_pagamento' => $finc_forma_pagamento,
					'finc_observacoes' => $finc_observacoes,
					'finc_multa' => $finc_multa,
					'finc_juros' => $finc_juros,
					'finc_status' => $finc_status,
					'finc_dte_cadastro' => date("Y-m-d H:i:s"),
					'finc_dte_alteracao' => date("Y-m-d H:i:s"),
					'finc_ativo' => (int)$finc_ativo,
					'finc_nr_doc' => $finc_nr_doc,
					'finc_modalidade' => "GERENCIAL",
				];
				$queryEdit = $this->fincMD->where('finc_id', $finc_id)->get();
				if ($queryEdit && $queryEdit->resultID->num_rows >= 1) {
					unset($data_db['finc_hashkey']);
					unset($data_db['finc_dte_cadastro']);
					$qryExecute = $this->fincMD->update($finc_id, $data_db);
				} else {

					$finc_id = $this->fincMD->insert($data_db);
				}

				return $this->response->redirect(site_url('financeiro/gerencial'));
				exit();
			} else {
				$errors = $validation->getErrors();
				$validationWithLabels = [];

				foreach ($rules as $field => $rule) {
					if (isset($errors[$field])) {
						$validationWithLabels[$rule['label']] = $errors[$field]; // Usa o label no lugar do campo
					}
				}

				$this->data['validation'] = $validationWithLabels; // Agora contém label + erro
			}
		}


		$query = $this->fincMD->where('finc_id', $finc_id)->get();
		if ($query && $query->resultID->num_rows >= 1) {
			$rs_dados = $query->getRow();
			$this->data['rs_dados'] = $rs_dados;
		}

		//Inclui tipo de contas
		$queryTipo = $this->fincTipoMD
			->where('finc_tipo_ativo', '1')
			->orderBy('finc_tipo_id', 'DESC')
			->get();
		if ($queryTipo && $queryTipo->resultID->num_rows >= 1) {
			$this->data['rs_list_tipo'] = $queryTipo;
		}


		//Inclui classificacoes 

		$queryClass = $this->fincClassMD
			->where('finc_class_ativo', '1')
			->where('finc_class_modalidade !=', 'EQUIPE')
			->orderBy('finc_class_id', 'DESC')
			->get();
		if ($queryClass && $queryClass->resultID->num_rows >= 1) {
			$this->data['rs_list_class'] = $queryClass;
		}

		return view($this->directory . '/' . $template, $this->data);
	}

	public function salvarGerencial()
	{
		$template = 'financeiro-gerencial-form';
		if ($this->request->getPost()) {

			$dados_lancamentos = $this->request->getPost('lancamento'); // Array com os lançamentos
			if (!empty($dados_lancamentos)) {
				foreach ($dados_lancamentos as $lancamento) {
					$nr_parcela = (int)$lancamento['finc_nr_parcela'];
					$nr_parcela_total = (int)$lancamento['finc_nr_parcela_total'];
					$periodicidade = $lancamento['finc_periodicidade'];
					$data_vencimento = new DateTime(fct_date2bd($lancamento['finc_dte_vencimento']));
					if ($periodicidade != "AVULSO") {
						for ($i = $nr_parcela; $i <= $nr_parcela_total; $i++) {

							$data_db = [
								'finc_hashkey' => md5(date("Y-m-d H:i:s") . "-" . random_string('alnum', 16)),
								'finc_tipo_id' => $lancamento['finc_tipo_id'],
								'finc_class_id' => $lancamento['finc_class_id'],
								'finc_periodicidade' => $periodicidade,
								'finc_tipo' => $lancamento['finc_tipo'],
								'finc_nome' => $lancamento['finc_nome'],
								'finc_centro_custo' => $lancamento['finc_centro_custo'],
								'finc_nr_parcela' => $i,
								'finc_nr_parcela_total' => $lancamento['finc_nr_parcela_total'],
								'finc_valor' => $lancamento['finc_valor'],
								'finc_dte_vencimento' => $data_vencimento->format('Y-m-d'),
								'finc_efetuado' => (int)$lancamento['finc_efetuado'],
								'finc_dte_efetuado' => fct_date2bd($lancamento['finc_dte_efetuado']),
								'finc_competencia' => $lancamento['finc_competencia'],
								'finc_dte_pagamento' => fct_date2bd($lancamento['finc_dte_pagamento']),
								'finc_conta' => $lancamento['finc_conta'],
								'finc_forma_pagamento' => $lancamento['finc_forma_pagamento'],
								'finc_observacoes' => $lancamento['finc_observacoes'],
								'finc_status' => $lancamento['finc_status'],
								'finc_juros' => $lancamento['finc_juros'],
								'finc_multa' => $lancamento['finc_multa'],
								'finc_dte_cadastro' => date("Y-m-d H:i:s"),
								'finc_dte_alteracao' => date("Y-m-d H:i:s"),
								'finc_ativo' => 1,
								'finc_nr_doc' => $lancamento['finc_nr_doc'],
								'finc_modalidade' => "GERENCIAL",
							];



							$this->fincMD->insert($data_db);
							// Incrementar a data conforme periodicidade
							if ($periodicidade === 'MENSAL') {
								$data_vencimento->modify('+1 month');
							} elseif ($periodicidade === 'ANUAL') {
								$data_vencimento->modify('+1 year');
							}
						}
					} else {
						$data_db = [
							'finc_hashkey' => md5(date("Y-m-d H:i:s") . "-" . random_string('alnum', 16)),
							'finc_tipo_id' => $lancamento['finc_tipo_id'],
							'finc_class_id' => $lancamento['finc_class_id'],
							'finc_periodicidade' => $lancamento['finc_periodicidade'],
							'finc_tipo' => $lancamento['finc_tipo'],
							'finc_nome' => $lancamento['finc_nome'],
							'finc_centro_custo' => $lancamento['finc_centro_custo'],
							'finc_nr_parcela' => (int)$lancamento['finc_nr_parcela'],
							'finc_nr_parcela_total' => (int)$lancamento['finc_nr_parcela_total'],
							'finc_valor' => $lancamento['finc_valor'],
							'finc_dte_vencimento' => fct_date2bd($lancamento['finc_dte_vencimento']),
							'finc_efetuado' => (int)$lancamento['finc_efetuado'],
							'finc_dte_efetuado' => fct_date2bd($lancamento['finc_dte_efetuado']),
							'finc_competencia' => $lancamento['finc_competencia'],
							'finc_dte_pagamento' => fct_date2bd($lancamento['finc_dte_pagamento']),
							// 'finc_anotacoes' => $lancamento['finc_anotacoes'],
							'finc_conta' => $lancamento['finc_conta'],
							'finc_forma_pagamento' => $lancamento['finc_forma_pagamento'],
							'finc_observacoes' => $lancamento['finc_observacoes'],
							'finc_status' => $lancamento['finc_status'],
							'finc_dte_cadastro' => date("Y-m-d H:i:s"),
							'finc_dte_alteracao' => date("Y-m-d H:i:s"),
							'finc_ativo' => 1,
							'finc_nr_doc' => $lancamento['finc_nr_doc'],
							'finc_juros' => $lancamento['finc_juros'],
							'finc_multa' => $lancamento['finc_multa'],
							'finc_modalidade' => "GERENCIAL",
						];

						$this->fincMD->insert($data_db);
					}
				}
			}
			return $this->response->redirect(site_url('financeiro/gerencial'));
			exit();
		}

		//Inclui tipo de contas
		$queryTipo = $this->fincTipoMD
			->where('finc_tipo_ativo', '1')
			->orderBy('finc_tipo_id', 'DESC')
			->get();
		if ($queryTipo && $queryTipo->resultID->num_rows >= 1) {
			$this->data['rs_list_tipo'] = $queryTipo;
		}

		//Inclui classificacoes 
		$queryClass = $this->fincClassMD
			->where('finc_class_ativo', '1')
			->where('finc_class_modalidade !=', 'EQUIPE')
			->orderBy('finc_class_id', 'DESC')
			->get();
		if ($queryClass && $queryClass->resultID->num_rows >= 1) {
			$this->data['rs_list_class'] = $queryClass;
		}

		return view($this->directory . '/' . $template, $this->data);
	}
}
