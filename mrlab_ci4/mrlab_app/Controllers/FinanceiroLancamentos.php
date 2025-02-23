<?php

namespace App\Controllers;

use App\Controllers\PainelController;

class FinanceiroLancamentos extends PainelController
{
	protected $fincLancMD = null;
	protected $fincLancUpdateMD = null;
	protected $fincTipoMD = null;
	protected $fincClassMD = null;
	protected $fincMD = null;
	protected $funcMD = null;
	protected $clieMD = null;
	protected $cfg = null;
	protected $cfgStatus = null;

	public function __construct()
	{
		$this->fincLancMD = new \App\Models\FinanceiroLancamentosModel();
		$this->fincLancUpdateMD = new \App\Models\FinanceiroLancamentosModel();
		$this->fincTipoMD = new \App\Models\FinanceiroTiposModel();
		$this->fincClassMD = new \App\Models\FinanceiroClassificacoesModel();
		$this->fincMD = new \App\Models\FinanceiroModel();
		$this->funcMD = new \App\Models\FuncionariosModel();
		$this->clieMD = new \App\Models\ClientesModel();

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
		$filtro_pdf = '';
		// filtrar/user:marcio/cliente:123/dini:/dteend:/status:pago

		$uri = service('uri'); // Obter a instância do objeto URI
		$segments = $uri->getSegments();
		$index = array_search('filtrar', $segments); // Encontrar o índice do segmento "filtrar"

		$filteredSegments = array_slice($segments, $index + 1); // Retornar os elementos a partir de $index + 1 até o final


		$query = $this->fincLancMD
			->from('tbl_financeiro_lancamentos as LANC', true)
			->select('LANC.*')
			->select('TIPO.finc_tipo_nome')
			->select('CLASS.finc_class_nome')
			->select('FUNC.func_nome')
			->select('CLIE.clie_nome_razao')
			->join('tbl_financeiro_tipos TIPO', 'TIPO.finc_tipo_id = LANC.finc_tipo_id')
			->join('tbl_financeiro_classificacoes CLASS', 'CLASS.finc_class_id = LANC.finc_class_id')
			->join('tbl_funcionarios FUNC', 'FUNC.func_id = LANC.func_id', 'left')
			->join('tbl_clientes CLIE', 'CLIE.clie_id = LANC.clie_id', 'left')
			->orderBy('LANC.finc_lanc_id', 'DESC')
			->get();

		$this->data['lastQuery'] = $this->fincLancMD->getLastQuery();
		//->getCompiledSelect();

		if ($query && $query->resultID->num_rows >= 1) {
			$this->data['rs_list'] = $query;
		}

		return view($this->directory . '/financeiroLancamentos', $this->data);
	}


	public function form($finc_lanc_id = 0)
	{
		$template = 'financeiroLancamentos-form';
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

			];

			if ($this->validate($rules)) {
				$finc_tipo_id = $this->request->getPost('finc_tipo_id');
				$finc_class_id = $this->request->getPost('finc_class_id');
				$func_id = $this->request->getPost('func_id');
				$clie_id = $this->request->getPost('clie_id');
				$finc_lanc_periodicidade = $this->request->getPost('finc_lanc_periodicidade');
				$finc_lanc_custo = $this->request->getPost('finc_lanc_custo');
				$finc_lanc_dte_lancamento = $this->request->getPost('finc_lanc_dte_lancamento');
				$finc_lanc_ie_porcentagem = $this->request->getPost('finc_lanc_ie_porcentagem');
				$finc_lanc_porcentagem = $this->request->getPost('finc_lanc_porcentagem');
				$finc_lanc_valor = $this->request->getPost('finc_lanc_valor');
				$finc_lanc_tipo = $this->request->getPost('finc_lanc_tipo');
				$finc_lanc_ativo = (int)$this->request->getPost('finc_lanc_ativo');

				$data_db = [
					'finc_lanc_hashkey' => md5(date("Y-m-d H:i:s") . "-" . random_string('alnum', 16)),
					'finc_tipo_id' => $finc_tipo_id,
					'finc_class_id' => $finc_class_id,
					'func_id' => $func_id,
					'clie_id' => $clie_id,
					'finc_lanc_periodicidade' => $finc_lanc_periodicidade,
					'finc_lanc_custo' => $finc_lanc_custo,
					'finc_lanc_dte_lancamento' => fct_date2bd($finc_lanc_dte_lancamento),
					'finc_lanc_ie_porcentagem' => (int)$finc_lanc_ie_porcentagem,
					'finc_lanc_porcentagem' => $finc_lanc_porcentagem,
					'finc_lanc_valor' => $finc_lanc_valor,
					'finc_lanc_tipo' => $finc_lanc_tipo,
					'finc_lanc_dte_cadastro' => date("Y-m-d H:i:s"),
					'finc_lanc_dte_alteracao' => date("Y-m-d H:i:s"),
					'finc_lanc_ativo' => (int)$finc_lanc_ativo,
				];

				$queryEdit = $this->fincLancMD->where('finc_lanc_id', $finc_lanc_id)->get();
				if ($queryEdit && $queryEdit->resultID->num_rows >= 1) {
					unset($data_db['finc_lanc_hashkey']);
					unset($data_db['finc_lanc_dte_cadastro']);
					$qryExecute = $this->fincLancMD->update($finc_lanc_id, $data_db);
				} else {
					// Obtenha os IDs funcionarios
					$selectedIdsFunc = $this->request->getPost('selected_func_ids');

					if (!empty($selectedIdsFunc)) {
						// IDs selecionados
						foreach ($selectedIdsFunc as $id) {
							// Atualizar o valor de func_id no array $data_db
							$data_db['func_id'] = $id;
							$finc_lanc_id = $this->fincLancMD->insert($data_db);
						}
					}
					// Obtenha os IDs clientes
					$selectedIdsClie = $this->request->getPost('selected_clie_ids');

					if (!empty($selectedIdsClie)) {
						// IDs selecionados
						foreach ($selectedIdsClie as $id) {
							// Atualizar o valor de func_id no array $data_db
							$data_db['clie_id'] = $id;
							$finc_lanc_id = $this->fincLancMD->insert($data_db);
						}
					}
				}



				return $this->response->redirect(site_url('financeiroLancamentos'));
				exit();
			} else {
				$this->data['validation'] = $validation->getErrors();
			}
		}

		$query = $this->fincLancMD->where('finc_lanc_id', $finc_lanc_id)->get();
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

		//Inclui funcionarios 

		$queryFunc = $this->funcMD
			->where('func_ativo', '1')
			->orderBy('func_id', 'DESC')
			->get();
		if ($queryFunc && $queryFunc->resultID->num_rows >= 1) {
			$this->data['rs_list_func'] = $queryFunc;
		}

		//Inclui clientes 

		$queryClie = $this->clieMD
			->where('clie_ativo', '1')
			->orderBy('clie_id', 'DESC')
			->get();
		if ($queryClie && $queryClie->resultID->num_rows >= 1) {
			$this->data['rs_list_clie'] = $queryClie;
		}

		return view($this->directory . '/' . $template, $this->data);
	}



	public function ajaxform($action = "")
	{
		$error_num = "1";
		$error_msg = "Erro inesperado";
		$redirect = "";

		switch ($action) {
		}
	}

	public function teste(){
		$dadosT = $this->fincLancMD->where('finc_lanc_id', 6)
		->get()
		->getResultArray();
		$dadosT[0]['finc_lanc_ativo'] = 0;
		$this->fincLancMD->update($dadosT[0]['finc_lanc_id'], $dadosT[0]);
				echo $this->fincLancMD->getLastQuery();
	}

	public function gerarLancamentosPeriodicos()
	{
		$hoje = date('Y-m-d'); // Data atual
		$lancamentos = $this->fincLancMD
			->from('tbl_financeiro_lancamentos as LANC', true)
			->select('LANC.*')
			->select('TIPO.finc_tipo_nome')
			->select('CLASS.finc_class_nome')
			->select('FUNC.func_nome, FUNC.func_salario')
			->select('CLIE.clie_nome_razao')
			->join('tbl_financeiro_tipos TIPO', 'TIPO.finc_tipo_id = LANC.finc_tipo_id')
			->join('tbl_financeiro_classificacoes CLASS', 'CLASS.finc_class_id = LANC.finc_class_id')
			->join('tbl_funcionarios FUNC', 'FUNC.func_id = LANC.func_id', 'left')
			->join('tbl_clientes CLIE', 'CLIE.clie_id = LANC.clie_id', 'left')
			->where('LANC.finc_lanc_dte_lancamento', $hoje)
			->where('LANC.finc_lanc_ativo', 1) // Considerando apenas lançamentos ativos
			->get()
			->getResultArray();

		foreach ($lancamentos as $lancamento) {
			// Definir o valor do lançamento
			$valorLancamento = $lancamento['finc_lanc_ie_porcentagem'] == 1
				? ($lancamento['finc_lanc_porcentagem'] / 100) * $lancamento['func_salario']
				: $lancamento['finc_lanc_valor'];

			// Dados para o lançamento no financeiro
			$dadosFinanceiro = [
				'finc_hashkey' => md5(date("Y-m-d H:i:s") . "-" . random_string('alnum', 16)),
				'finc_tipo_id' => $lancamento['finc_tipo_id'],
				'finc_class_id' => $lancamento['finc_class_id'],
				'finc_periodicidade' => $lancamento['finc_lanc_periodicidade'],
				'finc_tipo' => $lancamento['finc_lanc_tipo'],
				'finc_nome' => isset($lancamento['func_id'])
					? $lancamento['func_nome']
					: (isset($lancamento['clie_id'])
						? $lancamento['clie_nome_razao']
						: $lancamento['finc_lanc_tipo']),
				'finc_centro_custo' => $lancamento['finc_lanc_custo'],
				'finc_valor' => $valorLancamento,
				'finc_dte_vencimento' => $lancamento['finc_lanc_dte_lancamento'],
				'finc_dte_cadastro' => date("Y-m-d H:i:s"),
				'finc_dte_alteracao' => date("Y-m-d H:i:s"),
				'finc_ativo' => 1,
			];
			print_r("Financeiro 1: ");
			print_r($dadosFinanceiro);
			print_r("\n");

			// Inserir o lançamento no financeiro
			$this->fincMD->insert($dadosFinanceiro);
			print_r("\nLancamento 1: ");
			print_r($lancamento);
			print_r("\n");
			// Atualizar a data do próximo lançamento para lançamentos periódicos
			switch ($lancamento['finc_lanc_periodicidade']) {
				case 'MENSAL':
					$novaData = date('Y-m-d', strtotime('+1 month', strtotime($lancamento['finc_lanc_dte_lancamento'])));
					break;
				case 'ANUAL':
					$novaData = date('Y-m-d', strtotime('+1 year', strtotime($lancamento['finc_lanc_dte_lancamento'])));
					break;
				default:
					$novaData = null; // Avulso não atualiza
					break;
			}

			print_r("\n data 1: ");
			print_r($novaData);
			print_r("\n");


			//Dados lancamento

			$dadosLanc = [
				'finc_lanc_id' => $lancamento['finc_lanc_id'],
				'finc_lanc_hashkey' => $lancamento['finc_lanc_hashkey'],
				'finc_tipo_id' => $lancamento['finc_tipo_id'],
				'finc_class_id' => $lancamento['finc_class_id'],
				'func_id' => $lancamento['func_id'],
				'clie_id' => $lancamento['clie_id'],
				'finc_lanc_periodicidade' => $lancamento['finc_lanc_periodicidade'],
				'finc_lanc_custo' => $lancamento['finc_lanc_custo'],
				'finc_lanc_dte_lancamento' => $lancamento['finc_lanc_dte_lancamento'],
				'finc_lanc_ie_porcentagem' => $lancamento['finc_lanc_ie_porcentagem'],
				'finc_lanc_porcentagem' => $lancamento['finc_lanc_porcentagem'],
				'finc_lanc_valor' => $lancamento['finc_lanc_valor'],
				'finc_lanc_tipo' => $lancamento['finc_lanc_tipo'],
				'finc_lanc_dte_cadastro' => $lancamento['finc_lanc_dte_cadastro'],
				'finc_lanc_dte_alteracao' => $lancamento['finc_lanc_dte_alteracao'],
				'finc_lanc_ativo' => $lancamento['finc_lanc_ativo']
			];

			print_r("\n data 1: ");
			print_r($dadosLanc);
			print_r("\n");

			$dadosT = $this->fincLancUpdateMD->where('finc_lanc_id', $dadosLanc['finc_lanc_id'])
			->get()
			->getResultArray();

			print_r(
				$dadosT[0]
			);

			// Atualização de lançamento com base no ID
			if ($novaData) {
				$dadosT[0]['finc_lanc_dte_lancamento'] = $novaData;
				// Atualiza o lançamento específico com base no ID
				$this->fincLancUpdateMD->update($dadosT[0]['finc_lanc_id'], $dadosT[0]);
				echo $this->fincLancUpdateMD->getLastQuery();
			} else {
				// Marca o lançamento como inativo
				$dadosLanc['finc_lanc_ativo'] = 0;
				// Atualiza o lançamento específico com base no ID
				$this->fincLancUpdateMD->update($dadosLanc['finc_lanc_id'], $dadosLanc);
			}
		}

		echo "Lançamentos periódicos gerados com sucesso!";
	}
}
