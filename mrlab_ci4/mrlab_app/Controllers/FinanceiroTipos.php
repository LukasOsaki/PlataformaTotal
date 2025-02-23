<?php
namespace App\Controllers;
use App\Controllers\PainelController;

class FinanceiroTipos extends PainelController
{
	protected $fincTipoMD = null;
	protected $cfg = null;

    public function __construct()
    {
        $this->fincTipoMD = new \App\Models\FinanceiroTiposModel();

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


		$this->fincTipoMD
			->orderBy('finc_tipo_id', 'DESC')
			->limit(1000);
		$query = $this->fincTipoMD->get();

		$this->data['lastQuery'] = $this->fincTipoMD->getLastQuery();
			//->getCompiledSelect();

		if( $query && $query->resultID->num_rows >=1 )
		{
			$this->data['rs_list'] = $query;
		}

		return view($this->directory .'/financeiroTipos', $this->data);
	}



	public function form( $finc_tipo_id = 0 )
	{
		
		if ($this->request->getPost())
		{
			$validation =  \Config\Services::validation();
			$rules = [
				"finc_tipo_nome" => [
					"label" => "Nome", 
					"rules" => "required",
					'errors' => [
						'required' => 'Preencha corretamente',
					],
				],
			];

			if ($this->validate($rules)) {
				$finc_tipo_nome = $this->request->getPost('finc_tipo_nome');

				$data_db = [
					'finc_tipo_hashkey' =>md5(date("Y-m-d H:i:s") ."-". random_string('alnum', 16)),
					'finc_tipo_nome' => $finc_tipo_nome,
					'finc_tipo_dte_cadastro' => date("Y-m-d H:i:s"),
					'finc_tipo_dte_alteracao' => date("Y-m-d H:i:s"),
					'finc_tipo_ativo' => 1,
				];

				$queryEdit = $this->fincTipoMD->where('finc_tipo_id', $finc_tipo_id)->get();
				if( $queryEdit && $queryEdit->resultID->num_rows >=1 )
				{
					unset( $data_db['finc_tipo_hashkey'] );
					unset( $data_db['finc_tipo_dte_cadastro'] );
					$qryExecute = $this->fincTipoMD->update($finc_tipo_id, $data_db);
				}else{
					$finc_tipo_id = $this->fincTipoMD->insert($data_db);
				}
				
				return $this->response->redirect( site_url('financeiroTipos') );
				exit();

			} else {
				$this->data['validation'] = $validation->getErrors();
			}
		}


		$query = $this->fincTipoMD->where('finc_tipo_id', $finc_tipo_id)->get();
		if( $query && $query->resultID->num_rows >=1 )
		{
			$rs_dados = $query->getRow();
			$this->data['rs_dados'] = $rs_dados;
		}

		return view($this->directory .'/financeiroTipos-form', $this->data);
	}


	public function ajaxform( $action = "" )
	{
		$error_num = "1";
		$error_msg = "Erro inesperado";
		$redirect = "";

		switch ($action) {
		case "EXCLUIR-REGISTRO" :

			$finc_tipo_hashkey = $this->request->getPost('finc_tipo_hashkey');
			$query = $this->fincTipoMD->where('finc_tipo_hashkey', $finc_tipo_hashkey)->get();
			if( $query && $query->resultID->num_rows >=1 )
			{
				$rs_registro = $query->getRow();
				$finc_tipo_id = (int)$rs_registro->finc_tipo_id;			

				// excluir registro
				$this->fincTipoMD->where('finc_tipo_hashkey', $finc_tipo_hashkey)->delete();

				
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
