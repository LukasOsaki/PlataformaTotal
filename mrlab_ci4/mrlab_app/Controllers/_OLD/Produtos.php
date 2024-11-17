<?php
namespace App\Controllers;
use App\Controllers\BaseController;

class Produtos extends BaseController
{

	protected $prodMD = null;

    public function __construct()
    {
        $this->prodMD = new \App\Models\ProdutosModel();

		$this->data['menu_active'] = 'dashboard';
    }


	public function index()
	{
		//$list_produtos = $this->arr_produtos;

		//print '<pre>';
		//print_r( $this->arr_produtos );
		//print '</pre>';
		//shuffle($this->arr_produtos);

		//$list_produtos = $this->arr_produtos;
		//shuffle($list_produtos);
		//$this->data['list_produtos'] = $list_produtos;

		$this->prodMD->orderBy('prod_id', 'RANDOM');
		$query = $this->prodMD->get();
		if( $query && $query->resultID->num_rows >= 1 )
		{
			$this->data['list_produtos'] = $query;
		}

		return view('produtos', $this->data);
	}


	public function categ( $categ_id = 0 )
	{
		//$list_produtos = $this->arr_produtos;

		//print '<pre>';
		//print_r( $this->arr_produtos );
		//print '</pre>';
		//shuffle($this->arr_produtos);

		//$list_produtos = $this->arr_produtos;
		//shuffle($list_produtos);
		//$this->data['list_produtos'] = $list_produtos;

		$this->prodMD->where('categ_id', (int)$categ_id)->orderBy('prod_id', 'RANDOM');
		$query = $this->prodMD->get();
		if( $query && $query->resultID->num_rows >= 1 )
		{
			$this->data['list_produtos'] = $query;
		}

		return view('produtos', $this->data);
	}


	public function detalhe($prod_id = 0, $prod_urlpage = "")
	{
		$this->prodMD->where('prod_id', (int)$prod_id)
			->where('prod_urlpage', $prod_urlpage)
			->orderBy('prod_id', 'RANDOM')
			->limit(1);
		$query = $this->prodMD->get();
		if( $query && $query->resultID->num_rows >= 1 )
		{
			$rs_dados = $query->getRow();
			$this->data['rs_produto'] = $rs_dados;
		}


		$this->prodMD->orderBy('prod_id', 'RANDOM')->limit(4);
		$query = $this->prodMD->get();
		if( $query && $query->resultID->num_rows >= 1 )
		{
			$this->data['rs_prod_relacionados'] = $query;
		}

		return view('produto', $this->data);
	}

}
