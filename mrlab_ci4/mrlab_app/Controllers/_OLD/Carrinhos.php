<?php
namespace App\Controllers;
use App\Controllers\BaseController;

class Carrinhos extends BaseController
{

	protected $prodMD = null;
	protected $cartMD = null;
	protected $pedMD = null;
	protected $pedItemMD = null;

    public function __construct()
    {
        $this->prodMD = new \App\Models\ProdutosModel();
		$this->cartMD = new \App\Models\CarrinhosModel();
		$this->pedMD = new \App\Models\PedidosModel();
		$this->pedItemMD = new \App\Models\PedidosItensModel();

		$this->data['menu_active'] = 'dashboard';
    }


	public function index()
	{
		
		if ($this->request->getPost())
		{
			$tipo_envio = $this->request->getPost('tipo_envio');
			//$ses_data = [
			//	'tipo_envio' => $tipo_envio,
			//	'isLoggedIn' => TRUE
			//];
			////session()->set($ses_data);
			//session()->set('tipo_envio', $tipo_envio);

			//$ped_nome = $this->request->getPost('ped_nome');
			//$ped_sobrenome = $this->request->getPost('ped_sobrenome');
			//$ped_cep = $this->request->getPost('ped_cep');
			//$ped_endereco = $this->request->getPost('ped_endereco');
			//$ped_bairro = $this->request->getPost('ped_bairro');
			//$ped_cidade = $this->request->getPost('ped_cidade');
			//$ped_estado = $this->request->getPost('ped_estado');
			//$ped_observacoes = $this->request->getPost('ped_observacoes');
			//$checkout_payment_method = $this->request->getPost('checkout_payment_method');

			$query_cart = $this->cartMD->where('cad_id', (int)session()->get('cad_id'))->get();
			if( $query_cart && $query_cart->resultID->num_rows >=1 )
			{
				$rs_cart = $query_cart->getRow();
				$this->data['rs_cart'] = $rs_cart;

				$data_db = [
					'cad_id' => (int)session()->get('cad_id'),
					'ped_hashkey' => md5(date("Y-m-d H:i:s") ."-". random_string('alnum', 16)),
					'ped_nome' => session()->get('user_nome'), 
					'ped_envio_tipo' => $tipo_envio,
					'ped_pagto_tipo' => '',
					'ped_dte_cadastro' => date("Y-m-d H:i:s"),
					'ped_dte_alteracao' => date("Y-m-d H:i:s"),
					'ped_ativo' => '1',
				];
				$this->pedMD->set($data_db);
				$ped_id = $this->pedMD->insert();

				foreach ($query_cart->getResult() as $row) {
					$prod_id = (int)$row->prod_id;
					$cart_produto = $row->cart_produto;
					$cart_valor = $row->cart_valor;
					$cart_quant = (int)$row->cart_quant;

					$data_db_itens = [
						'cad_id' => (int)session()->get('cad_id'),
						'prod_id' => (int)$prod_id,
						'ped_id' => (int)$ped_id,
						'item_hashkey' => md5(date("Y-m-d H:i:s") ."-". random_string('alnum', 16)),
						'item_produto' => $cart_produto,
						'item_valor' => $cart_valor,
						'item_quant' => (int)$cart_quant,
						'item_dte_cadastro' => date("Y-m-d H:i:s"),
						'item_dte_alteracao' => date("Y-m-d H:i:s"),
						'item_ativo' => '1',
					];
					$this->pedItemMD->set($data_db_itens);
					$this->pedItemMD->insert();
				}

				$query = $this->cartMD->where('cad_id', (int)session()->get('cad_id'))->delete();
			}

			return $this->response->redirect( site_url('carrinho/finalizado') );
			//return $this->response->redirect( site_url('carrinho/checkout') );	
		}

		$query = $this->cartMD->from('tbl_carrinhos As CART', true)
			->select('CART.*')
			->select('PROD.*')
			->join('tbl_produtos PROD', 'PROD.prod_id = CART.prod_id', 'INNER')
			->where('CART.cad_id', (int)session()->get('cad_id'))
			->get();
		if( $query && $query->resultID->num_rows >= 1 ){
			
			$this->data['rs_carrinho'] = $query;

		}

		return view('carrinhos', $this->data);
	}


	public function add($prod_id = 0, $prod_urlpage = "")
	{
		if ($this->request->getPost())
		{
			$quantidade = $this->request->getPost('quantidade');

			$this->prodMD->where('prod_id', (int)$prod_id)
				->where('prod_urlpage', $prod_urlpage)
				->limit(1);
			$query = $this->prodMD->get();
			if( $query && $query->resultID->num_rows >= 1 )
			{
				$rs_dados = $query->getRow();
				$this->data['rs_produto'] = $rs_dados;

				$data_db = [
					'prod_id' => (int)$prod_id,
					'cad_id' => (int)session()->get('cad_id'),
					'cart_hashkey' => md5(date("Y-m-d H:i:s") ."-". random_string('alnum', 16)),
					'cart_quant' => (int)$quantidade,
					'cart_produto' => $rs_dados->prod_titulo,
					'cart_valor' => $rs_dados->prod_valor,
					'cart_dte_cadastro' => date("Y-m-d H:i:s"),
					'cart_dte_alteracao' => date("Y-m-d H:i:s"),
					'cart_ativo' => '1',
				];
				$query = $this->cartMD
					->where('prod_id', $prod_id)
					->where('cad_id', (int)session()->get('cad_id'))
					->limit(1)
					->get();	
				if( $query && $query->resultID->num_rows >= 1 ){
					$this->cartMD->set($data_db);
					$this->cartMD->where('prod_id', $prod_id);
					$this->cartMD->where('cad_id', (int)session()->get('cad_id'));
					$this->cartMD->update();
				}else{
					$this->cartMD->set($data_db);
					$cad_id = $this->cartMD->insert();
				}



			}

			return $this->response->redirect( site_url('carrinho') );

			
			print 'prod_id: '. $prod_id;
			print '<hr>';
			
			print 'prod_urlpage: '. $prod_urlpage;
			print '<hr>';

			print 'quantidade: '. $quantidade;
			print '<hr>';





			//$query = $this->cadMD->select('*')
			//	->groupStart()
			//		->orGroupStart()
			//			->where('cad_email', $cad_email)
			//		->groupEnd()
			//	->groupEnd()
			//	->where('cad_senha', fct_password_hash($cad_senha))
			//	->limit(1)
			//	->get();
			//if( $query && $query->resultID->num_rows >= 1 ){
			//	$rs_cad = $query->getRow();

			//	$ses_data = [
			//		'hash_id' => md5(date("Y-m-d H:i:s") ."-". random_string('alnum', 16)),
			//		'cad_id' => $rs_cad->cad_id,
			//		'cad_nome' => $rs_cad->cad_nome,
			//		'cad_email' => $rs_cad->cad_email,
			//		'isLoggedIn' => TRUE
			//	];
			//	$session->set($ses_data);

			//	return $this->response->redirect( site_url('dashboard/?logado') );

			//	//$this->cadMD->set($data_db);
			//	//$this->cadMD->where('avis_id', $avis_id);
			//	//$this->cadMD->update();
			//}else{
			//	
			//	return $this->response->redirect( site_url('dashboard/?nao-logado') );

			//}

			//return $this->response->redirect( site_url('dashboard') );
			exit();
		}
		
		return $this->response->redirect( site_url() );
		//return view('carrinho-add', $this->data);
	}


	public function delete($cart_hashkey = "")
	{
		$this->cartMD->where('cart_hashkey', $cart_hashkey)
			->limit(1);
		$query = $this->cartMD->get();
		if( $query && $query->resultID->num_rows >= 1 )
		{
			//$rs_dados = $query->getRow();
			$this->cartMD->where('cart_hashkey', $cart_hashkey);
			$this->cartMD->delete();
		}
		return $this->response->redirect( site_url('carrinho') );
	}


	public function checkout()
	{
		if ($this->request->getPost())
		{
			$ped_nome = $this->request->getPost('ped_nome');
			$ped_sobrenome = $this->request->getPost('ped_sobrenome');
			$ped_cep = $this->request->getPost('ped_cep');
			$ped_endereco = $this->request->getPost('ped_endereco');
			$ped_bairro = $this->request->getPost('ped_bairro');
			$ped_cidade = $this->request->getPost('ped_cidade');
			$ped_estado = $this->request->getPost('ped_estado');
			$ped_observacoes = $this->request->getPost('ped_observacoes');
			$checkout_payment_method = $this->request->getPost('checkout_payment_method');

			$query_cart = $this->cartMD->where('cad_id', (int)session()->get('cad_id'))->get();
			if( $query_cart && $query_cart->resultID->num_rows >=1 )
			{
				$rs_cart = $query_cart->getRow();
				$this->data['rs_cart'] = $rs_cart;

				$data_db = [
					'cad_id' => (int)session()->get('cad_id'),
					'ped_hashkey' => md5(date("Y-m-d H:i:s") ."-". random_string('alnum', 16)),
					'ped_nome' => $ped_nome,
					'ped_sobrenome' => $ped_sobrenome,
					'ped_cep' => $ped_cep,
					'ped_endereco' => $ped_endereco,
					'ped_bairro' => $ped_bairro,
					'ped_cidade' => $ped_cidade,
					'ped_estado' => $ped_estado,
					'ped_observacoes' => $ped_observacoes,
					'ped_envio_tipo' => session()->get('tipo_envio'),
					'ped_pagto_tipo' => $checkout_payment_method,
					'ped_dte_cadastro' => date("Y-m-d H:i:s"),
					'ped_dte_alteracao' => date("Y-m-d H:i:s"),
					'ped_ativo' => '1',
				];
				$this->pedMD->set($data_db);
				$ped_id = $this->pedMD->insert();

				foreach ($query_cart->getResult() as $row) {
					$prod_id = (int)$row->prod_id;
					$cart_produto = $row->cart_produto;
					$cart_valor = $row->cart_valor;
					$cart_quant = (int)$row->cart_quant;

					$data_db_itens = [
						'cad_id' => (int)session()->get('cad_id'),
						'prod_id' => (int)$prod_id,
						'ped_id' => (int)$ped_id,
						'item_hashkey' => md5(date("Y-m-d H:i:s") ."-". random_string('alnum', 16)),
						'item_produto' => $cart_produto,
						'item_valor' => $cart_valor,
						'item_quant' => (int)$cart_quant,
						'item_dte_cadastro' => date("Y-m-d H:i:s"),
						'item_dte_alteracao' => date("Y-m-d H:i:s"),
						'item_ativo' => '1',
					];
					$this->pedItemMD->set($data_db_itens);
					$this->pedItemMD->insert();
				}

				$query = $this->cartMD->where('cad_id', (int)session()->get('cad_id'))->delete();
			}

			return $this->response->redirect( site_url('carrinho/finalizado') );	
		}

		$query = $this->cartMD->from('tbl_carrinhos As CART', true)
			->select('CART.*')
			->select('PROD.*')
			->join('tbl_produtos PROD', 'PROD.prod_id = CART.prod_id', 'INNER')
			->where('CART.cad_id', (int)session()->get('cad_id'))
			->get();
		if( $query && $query->resultID->num_rows >= 1 ){
			
			$this->data['rs_carrinho'] = $query;

		}
		return view('carrinho-checkout', $this->data);
	}


	public function finalizado()
	{
		return view('carrinho-finalizado', $this->data);
	}

}
