<?php
namespace App\Controllers;
use App\Controllers\PainelController;

class Programacoes extends PainelController
{
	protected $progMD = null;
	protected $clieMD = null;
	protected $cfg = null;
	protected $cfgProgPeriodo = null;

    public function __construct()
    {
        $this->progMD = new \App\Models\ProgramacoesModel();
		$this->clieMD = new \App\Models\ClientesModel();

		$this->cfg = new \Config\AppSettings();
		$this->cfgProgPeriodo = $this->cfg->getProgPeriodo();
		$this->data['cfgProgPeriodo'] = $this->cfgProgPeriodo;

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

		//$this->progMD->orderBy('prog_id', 'DESC')
		//	->limit(1000);
		//$query = $this->progMD->get();

		$this->progMD->from('tbl_programacoes AS PROG', true);
		$this->progMD->select('PROG.*');
		$this->progMD->select('CLIE.clie_nome_razao');
		$this->progMD->join('tbl_clientes CLIE', 'CLIE.clie_id = PROG.clie_id', 'LEFT');
		$this->progMD->orderBy('PROG.prog_id', 'ASC');
		$this->progMD->limit(1000);
		$query = $this->progMD->get();

		$this->data['lastQuery'] = $this->progMD->getLastQuery();
			//->getCompiledSelect();

		if( $query && $query->resultID->num_rows >=1 )
		{
			$this->data['rs_list'] = $query;
		}

		return view($this->directory .'/programacoes', $this->data);
	}


	public function form( $prog_id = 0 )
	{
		if ($this->request->getPost())
		{
			$validation =  \Config\Services::validation();
			$rules = [
				"prog_sequencia" => [
					"label" => "Sequencia", 
					"rules" => "required",
					'errors' => [
						'required' => 'Preencha corretamente',
					],
				],
			];

			if ($this->validate($rules)) {
				$clie_id = (int)$this->request->getPost('clie_id');
				$prog_sequencia = $this->request->getPost('prog_sequencia');
				$prog_dte_visita = $this->request->getPost('prog_dte_visita');
				$prog_periodo = $this->request->getPost('prog_periodo');
				$prog_tecnico = $this->request->getPost('prog_tecnico');
				$prog_atividades = $this->request->getPost('prog_atividades');
				$prog_realizada = (int)$this->request->getPost('prog_realizada');
				$prog_ativo = (int)$this->request->getPost('prog_ativo');

				$data_db = [
					'clie_id' => $clie_id,
					'prog_hashkey' => md5(date("Y-m-d H:i:s") ."-". random_string('alnum', 16)),
					//'prog_urlpage' => url_title( convert_accented_characters($prog_titulo), '-', TRUE ),
					'prog_dte_visita' => fct_date2bd($prog_dte_visita),
					'prog_periodo' => $prog_periodo,
					'prog_sequencia' => $prog_sequencia,
					'prog_tecnico' => $prog_tecnico,
					'prog_atividades' => $prog_atividades,
					'prog_realizada' => (int)$prog_realizada,
					'prog_dte_cadastro' => date("Y-m-d H:i:s"),
					'prog_dte_alteracao' => date("Y-m-d H:i:s"),
					'prog_ativo' => (int)$prog_ativo,
				];

				$queryEdit = $this->progMD->where('prog_id', $prog_id)->get();
				if( $queryEdit && $queryEdit->resultID->num_rows >=1 )
				{
					unset( $data_db['prog_hashkey'] );
					unset( $data_db['prog_dte_cadastro'] );
					$qryExecute = $this->progMD->update($prog_id, $data_db);
				}else{
					$prog_id = $this->progMD->insert($data_db);
				}

				return $this->response->redirect( site_url('programacoes') );
				exit();

			} else {
				$this->data['validation'] = $validation->getErrors();
			}
		}


		$query = $this->progMD->where('prog_id', $prog_id)->get();
		if( $query && $query->resultID->num_rows >=1 )
		{
			$rs_dados = $query->getRow();
			$this->data['rs_dados'] = $rs_dados;
		}

		$query_clientes = $this->clieMD->where('clie_ativo', '1')->get();
		if( $query_clientes && $query_clientes->resultID->num_rows >=1 )
		{
			$this->data['rs_clientes'] = $query_clientes;
		}

		return view($this->directory .'/programacoes-form', $this->data);
	}


	public function diaria( $prog_dte_visita = "")
	{
		if( empty($prog_dte_visita) ){
			$prog_dte_visita = date("Y-m-d");
		}
		$this->data['prog_dte_visita'] = fct_formatdate($prog_dte_visita, 'd/m/Y');

		$this->progMD->from('tbl_programacoes AS PROG', true);
		$this->progMD->select('PROG.*');
		$this->progMD->select('CLIE.clie_nome_razao');
		$this->progMD->join('tbl_clientes CLIE', 'CLIE.clie_id = PROG.clie_id', 'LEFT');
		$this->progMD->where('prog_dte_visita', $prog_dte_visita);
		$this->progMD->orderBy('PROG.prog_id', 'ASC');
		$this->progMD->orderBy('PROG.prog_id', 'ASC');
		$this->progMD->limit(1000);
		$query = $this->progMD->get();

		$rs_list_periodo = [];

		if( $query && $query->resultID->num_rows >=1 )
		{
			$rs_list = $query;
			$this->data['rs_list'] = $rs_list;

			foreach ($rs_list->getResult() as $row) {
				//$prog_id = ($row->prog_id);
				//$prog_hashkey = ($row->prog_hashkey);
				//$prog_dte_visita = ($row->prog_dte_visita);
				$rs_list_periodo[$row->prog_periodo][] = $row;
			}

			$this->data['rs_list_periodo'] = $rs_list_periodo;

		}		

		return view($this->directory .'/programacoes-diaria', $this->data);
	}

}
