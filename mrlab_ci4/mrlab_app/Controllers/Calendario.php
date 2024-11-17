<?php
namespace App\Controllers;
use App\Controllers\PainelController;

class Calendario extends PainelController
{
	protected $pendMD = null;
	protected $clieMD = null;
	protected $eqtoMD = null;
	protected $categMD = null;

    public function __construct()
    {
        $this->pendMD = new \App\Models\PendenciasModel();
		$this->clieMD = new \App\Models\ClientesModel();
		$this->eqtoMD = new \App\Models\EquipamentosModel();
		$this->categMD = new \App\Models\CategoriasModel();

		helper('form');
		helper('text');

		$this->data['menu_active'] = 'calendario';
    }


	public function index()
	{
		$query_evet = $this->pendMD
			//->where('evet_arquivado', '0')
			->get();
		if( $query_evet && $query_evet->resultID->num_rows >= 1 )
		{
			if( $query_evet->resultID->num_rows >= 1 )
			{
				$result = [];
				foreach ($query_evet->getResult() as $row) 
				{
					$evet_id = (int)($row->pend_id);
					$evet_data = $row->pend_dte_registro;
					$evet_titulo = $row->pend_descricao;
					//$evet_tipo = $row->evet_tipo;

					$color = '#000000';
					//if( isset($this->arr_tipo_evet[$evet_tipo]) ){ $color = $this->arr_tipo_evet[$evet_tipo]['color']; }

					$arr_events_temp = [
						"title" => $evet_titulo,
						"start" => $evet_data,
						"color" => $color
					];
					array_push($result, $arr_events_temp);
				}
				$this->data['rs_eventos'] = json_encode($result);
			}
		}

		return view($this->directory .'/calendario', $this->data);
	}


	public function filtrar()
	{
		$filtro_pdf = '';
		// filtrar/user:marcio/cliente:123/dini:/dteend:/status:pago

		$uri = service('uri'); // Obter a instância do objeto URI
		$segments = $uri->getSegments();
		$index = array_search('filtrar', $segments); // Encontrar o índice do segmento "filtrar"

		$filteredSegments = array_slice($segments, $index + 1); // Retornar os elementos a partir de $index + 1 até o final

		$query = $this->pendMD->from('tbl_pendencias As PEND', true)
			->select('PEND.*')
			->select('CATEG.categ_titulo, CATEG.categ_color')
			->join('tbl_categorias CATEG', 'CATEG.categ_id = PEND.pend_status', 'LEFT')
			->orderBy('PEND.pend_id', 'ASC')
			->limit(1000)
			->get();

		//$this->pendMD->orderBy('pend_id', 'DESC')
		//	->limit(1000);
		//$query = $this->pendMD->get();

		$this->data['lastQuery'] = $this->pendMD->getLastQuery();
			//->getCompiledSelect();

		if( $query && $query->resultID->num_rows >=1 )
		{
			$this->data['rs_list'] = $query;
		}

		return view($this->directory .'/pendencias', $this->data);
	}


	public function form( $pend_id = 0 )
	{
		if ($this->request->getPost())
		{
			$validation =  \Config\Services::validation();
			$rules = [
				"pend_descricao" => [
					"label" => "Descrição", 
					"rules" => "required",
					'errors' => [
						'required' => 'Preencha corretamente',
					],
				],
			];

			if ($this->validate($rules)) {
				$pend_dte_registro = $this->request->getPost('pend_dte_registro');
				$pend_status = $this->request->getPost('pend_status');
				$pend_num_os = $this->request->getPost('pend_num_os');
				$pend_descricao = $this->request->getPost('pend_descricao');
				$pend_tag = $this->request->getPost('pend_tag');
				$pend_dte_compra = $this->request->getPost('pend_dte_compra');
				$pend_dte_instalacao = $this->request->getPost('pend_dte_instalacao');
				$pend_coment_interno = $this->request->getPost('pend_coment_interno');
				$pend_observacoes = $this->request->getPost('pend_observacoes');
				$pend_ativo = $this->request->getPost('pend_ativo');

				$data_db = [
					'pend_hashkey' => md5(date("Y-m-d H:i:s") ."-". random_string('alnum', 16)),
					//'eqto_urlpage' => url_title( convert_accented_characters($eqto_titulo), '-', TRUE ),
					'pend_dte_registro' => fct_date2bd($pend_dte_registro),
					'pend_status' => $pend_status,
					'pend_num_os' => $pend_num_os,
					'pend_descricao' => $pend_descricao,
					'pend_tag' => $pend_tag,
					'pend_dte_compra' => fct_date2bd($pend_dte_compra),
					'pend_dte_instalacao' => fct_date2bd($pend_dte_instalacao),
					'pend_coment_interno' => $pend_coment_interno,
					'pend_observacoes' => $pend_observacoes,
					'pend_dte_cadastro' => date("Y-m-d H:i:s"),
					'pend_dte_alteracao' => date("Y-m-d H:i:s"),
					'pend_ativo' => (int)$pend_ativo,
				];

				$queryEdit = $this->pendMD->where('pend_id', $pend_id)->get();
				if( $queryEdit && $queryEdit->resultID->num_rows >=1 )
				{
					unset( $data_db['pend_hashkey'] );
					unset( $data_db['pend_dte_cadastro'] );
					$qryExecute = $this->pendMD->update($pend_id, $data_db);
				}else{
					$pend_id = $this->pendMD->insert($data_db);
				}

				return $this->response->redirect( site_url('pendencias') );
				exit();

			} else {
				$this->data['validation'] = $validation->getErrors();
			}
		}


		$query = $this->pendMD->where('pend_id', $pend_id)->get();
		if( $query && $query->resultID->num_rows >=1 )
		{
			$rs_dados = $query->getRow();
			$this->data['rs_dados'] = $rs_dados;
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

		$query_status = $this->categMD->get();
		if( $query_status && $query_status->resultID->num_rows >=1 )
		{
			$this->data['rs_status'] = $query_status;
		}

		$query_clientes = $this->clieMD->where('clie_ativo', '1')->get();
		if( $query_clientes && $query_clientes->resultID->num_rows >=1 )
		{
			$this->data['rs_clientes'] = $query_clientes;
		}

		return view($this->directory .'/pendencias-form', $this->data);
	}

}
