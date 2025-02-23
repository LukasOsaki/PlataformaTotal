<?php
namespace App\Controllers;
use App\Controllers\PainelController;

class FinanceiroClassificacoes extends PainelController
{
	protected $fincClassMD = null;
	protected $cfg = null;

    public function __construct()
    {
        $this->fincClassMD = new \App\Models\FinanceiroClassificacoesModel();

		$this->cfg = new \Config\AppSettings();
		

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


		$this->fincClassMD
			->orderBy('finc_class_id', 'DESC')
			->limit(1000);
		$query = $this->fincClassMD->get();

		$this->data['lastQuery'] = $this->fincClassMD->getLastQuery();
			//->getCompiledSelect();

		if( $query && $query->resultID->num_rows >=1 )
		{
			$this->data['rs_list'] = $query;
		}

		return view($this->directory .'/financeiroClassificacoes', $this->data);
	}



	public function form( $finc_class_id = 0 )
	{
		
		if ($this->request->getPost())
		{
			$validation =  \Config\Services::validation();
			$rules = [
				"finc_class_nome" => [
					"label" => "Nome", 
					"rules" => "required",
					'errors' => [
						'required' => 'Preencha corretamente',
					],
				],
			];

			if ($this->validate($rules)) {
				$finc_class_nome = $this->request->getPost('finc_class_nome');
				$finc_class_func = $this->request->getPost('finc_class_func');
				$finc_class_cliente = $this->request->getPost('finc_class_cliente');
				$finc_class_modalidade = $this->request->getPost('finc_class_modalidade');

				$data_db = [
					'finc_class_hashkey' =>md5(date("Y-m-d H:i:s") ."-". random_string('alnum', 16)),
					'finc_class_nome' => $finc_class_nome,
					'finc_class_func' => $finc_class_func,
					'finc_class_cliente' => $finc_class_cliente,
					'finc_class_modalidade' => $finc_class_modalidade,
					'finc_class_dte_cadastro' => date("Y-m-d H:i:s"),
					'finc_class_dte_alteracao' => date("Y-m-d H:i:s"),
					'finc_class_ativo' => 1,
				];

				$queryEdit = $this->fincClassMD->where('finc_class_id', $finc_class_id)->get();
				if( $queryEdit && $queryEdit->resultID->num_rows >=1 )
				{
					unset( $data_db['finc_class_hashkey'] );
					unset( $data_db['finc_class_dte_cadastro'] );
					$qryExecute = $this->fincClassMD->update($finc_class_id, $data_db);
				}else{
					$finc_class_id = $this->fincClassMD->insert($data_db);
				}
				
				return $this->response->redirect( site_url('financeiroClassificacoes') );
				exit();

			} else {
				$this->data['validation'] = $validation->getErrors();
			}
		}


		$query = $this->fincClassMD->where('finc_class_id', $finc_class_id)->get();
		if( $query && $query->resultID->num_rows >=1 )
		{
			$rs_dados = $query->getRow();
			$this->data['rs_dados'] = $rs_dados;
		}

		return view($this->directory .'/financeiroClassificacoes-form', $this->data);
	}


	public function ajaxform( $action = "" )
	{
		$error_num = "1";
		$error_msg = "Erro inesperado";
		$redirect = "";

		switch ($action) {
		case "EXCLUIR-REGISTRO" :

			$finc_class_hashkey = $this->request->getPost('finc_class_hashkey');
			$query = $this->fincClassMD->where('finc_class_hashkey', $finc_class_hashkey)->get();
			if( $query && $query->resultID->num_rows >=1 )
			{
				$rs_registro = $query->getRow();
				$finc_class_id = (int)$rs_registro->finc_class_id;			

				// excluir registro
				$this->fincClassMD->where('finc_class_hashkey', $finc_class_hashkey)->delete();

				
				$error_num = "0";
				$error_msg = "Registro excluído com sucesso!";
				$redirect = "";
			}

			$arr_return = array(
				"error_num" => $error_num,
				"error_msg" => $error_msg,
				"redirect" => $redirect 
			);

			echo( json_encode($arr_return) );
			exit();
		break;
		}
	}

}
