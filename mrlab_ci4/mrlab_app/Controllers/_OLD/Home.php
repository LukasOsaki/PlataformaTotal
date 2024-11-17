<?php
namespace App\Controllers;
use App\Controllers\BaseController;

class Home extends BaseController
{
	
	protected $prodMD = null;

    public function __construct()
    {
		$this->prodMD = new \App\Models\ProdutosModel();

		$this->data['menu_active'] = 'home';
    }


	public function index()
	{

		// DESTAQUE
		// ----------------------------------
		//$rs_destaque = $this->arr_produtos;
		//shuffle($rs_destaque);
		//$this->data['rs_destaque'] = array_slice($rs_destaque, 0, 1);

		$this->prodMD->orderBy('prod_id', 'RANDOM')->limit(1);
		$query = $this->prodMD->get();
		if( $query && $query->resultID->num_rows >= 1 )
		{
			$rs_dados = $query->getRow();
			$this->data['rs_destaque'] = $rs_dados;
		}

		// DESTAQUE LATERAL
		// ----------------------------------
		//$rs_destaque_lateral = $this->arr_produtos;
		//shuffle($rs_destaque_lateral);
		//$this->data['rs_destaque_lateral'] = array_slice($rs_destaque_lateral, 0, 2);

		$this->prodMD->orderBy('prod_id', 'RANDOM')->limit(2);
		$query = $this->prodMD->get();
		if( $query && $query->resultID->num_rows >= 1 )
		{
			$this->data['rs_destaque_lateral'] = $query;
		}



		$this->prodMD->orderBy('prod_id', 'RANDOM')->limit(8);
		$query = $this->prodMD->get();
		if( $query && $query->resultID->num_rows >= 1 )
		{
			$this->data['list_acabou_chegar'] = $query;
		}

		//$list_acabou_chegar = $this->arr_produtos;
		//shuffle($list_acabou_chegar);
		//$this->data['list_acabou_chegar'] = array_slice($list_acabou_chegar, 0, 8);

		// CONHEÇA MAIS
		// ----------------------------------
		//$rs_conheca_mais = $this->arr_produtos;
		//shuffle($rs_conheca_mais);
		//$this->data['rs_conheca_mais'] = array_slice($rs_conheca_mais, 0, 2);

		$this->prodMD->orderBy('prod_id', 'RANDOM')->limit(2);
		$query = $this->prodMD->get();
		if( $query && $query->resultID->num_rows >= 1 )
		{
			$this->data['rs_conheca_mais'] = $query;
		}

		return view('index', $this->data);
	}


	public function index_old()
	{
		if( $this->session_user_permissao == '1' ){ // administradores
			$query_rows_users = $this->userMD->where('del', '0')->selectCount('id')->get();
			if( $query_rows_users && $query_rows_users->resultID->num_rows >=1 )
			{
				$rs_rows_users = $query_rows_users->getRow();
				$this->data['vendedores_count'] = (int)$rs_rows_users->id;
			}
		}

		$query_rows_prod = $this->prodMD
			->where('del', '0')
			->selectCount('id')->get();
		if( $query_rows_prod && $query_rows_prod->resultID->num_rows >=1 )
		{
			$rs_rows_prod = $query_rows_prod->getRow();
			$this->data['produtos_count'] = (int)$rs_rows_prod->id;
		}


		$this->vendMD->where('del', '0');
		if( $this->session_user_permissao == '2' ){ // vendedores
			$this->vendMD->where('usuario_id', $this->session_user_id);
		}
		$this->vendMD->selectCount('id');

		$query_rows_vend = $this->vendMD->get();
		if( $query_rows_vend && $query_rows_vend->resultID->num_rows >=1 )
		{
			$rs_rows_vend = $query_rows_vend->getRow();
			$this->data['pedidos_count'] = (int)$rs_rows_vend->id;
		}


		return view('dashboard', $this->data);
	}

}
