<?php
namespace App\Controllers;
use App\Controllers\PainelController;

class Pedidos extends PainelController
{
	
	protected $pedMD = null;
	protected $pedItemMD = null;
	protected $arrMethodEnvio = null;
	protected $arrMethodPagto = null;

    public function __construct()
    {
        $this->pedMD = new \App\Models\PedidosModel();
		$this->pedItemMD = new \App\Models\PedidosItensModel();


		$config = new \Config\AppSettings();
		$this->arrMethodEnvio = $config->getMetodoEnvio();
		$this->arrMethodPagto = $config->getMetodoPagamento();

		$this->data['arrMethodEnvio'] = $this->arrMethodEnvio;
		$this->data['arrMethodPagto'] = $this->arrMethodPagto;


		helper('form');
		helper('text');

		$this->data['menu_active'] = 'pedidos';
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


		$query = $this->pedMD->from('tbl_pedidos As PED', true)
			->select('PED.*')
			->select('CAD.*')
			->join('tbl_cadastros CAD', 'CAD.cad_id = PED.cad_id', 'INNER')
			->orderBy('PED.ped_id', 'ASC')
			->limit(1000)
			->get();

		//$this->data['lastQuery'] = $this->pedMD->getLastQuery();
			//->getCompiledSelect();

		if( $query && $query->resultID->num_rows >=1 )
		{
			$this->data['rs_list'] = $query;
		}

		return view($this->directory .'/pedidos', $this->data);
	}


	public function form( $ped_id = 0 )
	{
		if ($this->request->getPost())
		{
		}


		$query = $this->pedMD->where('ped_id', $ped_id)->get();
		if( $query && $query->resultID->num_rows >=1 )
		{
			$rs_pedido = $query->getRow();
			$this->data['rs_pedido'] = $rs_pedido;

			$query_itens = $this->pedItemMD->where('ped_id', $ped_id)->get();
			if( $query_itens && $query_itens->resultID->num_rows >=1 )
			{
				$this->data['rs_itens'] = $query_itens;
			}
		}


		return view($this->directory .'/pedidos-form', $this->data);
	}

}
