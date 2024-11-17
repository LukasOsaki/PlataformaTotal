<?php
namespace App\Controllers;
use App\Controllers\PainelController;

class Categorias extends PainelController
{
	protected $categMD = null;
	protected $cfg = null;

    public function __construct()
    {
        $this->categMD = new \App\Models\CategoriasModel();

		$this->cfg = new \Config\AppSettings();
		$this->data['cfgCategAreas'] = $this->cfg->getCategoriasAreas();

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


		$this->categMD
			->orderBy('categ_id', 'DESC')
			->limit(1000);
		$query = $this->categMD->get();

		$this->data['lastQuery'] = $this->categMD->getLastQuery();
			//->getCompiledSelect();

		if( $query && $query->resultID->num_rows >=1 )
		{
			$this->data['rs_list'] = $query;
		}

		return view($this->directory .'/categorias', $this->data);
	}


	public function form( $categ_id = 0 )
	{
		if ($this->request->getPost())
		{
			$validation =  \Config\Services::validation();
			$rules = [
				"categ_titulo" => [
					"label" => "Nome", 
					"rules" => "required",
					'errors' => [
						'required' => 'Preencha corretamente',
					],
				],
			];

			if ($this->validate($rules)) {
				$categ_titulo = $this->request->getPost('categ_titulo');
				$categ_area = $this->request->getPost('categ_area');
				$categ_color = $this->request->getPost('categ_color');

				$data_db = [
					'categ_hashkey' =>md5(date("Y-m-d H:i:s") ."-". random_string('alnum', 16)),
					'categ_urlpage' => url_title( convert_accented_characters($categ_titulo), '-', TRUE ),
					'categ_titulo' => $categ_titulo,
					'categ_area' => $categ_area,
					'categ_color' => $categ_color,
					'categ_dte_cadastro' => date("Y-m-d H:i:s"),
					'categ_dte_alteracao' => date("Y-m-d H:i:s"),
					'categ_ativo' => 1,
				];

				$queryEdit = $this->categMD->where('categ_id', $categ_id)->get();
				if( $queryEdit && $queryEdit->resultID->num_rows >=1 )
				{
					unset( $data_db['categ_hashkey'] );
					unset( $data_db['categ_dte_cadastro'] );
					$qryExecute = $this->categMD->update($categ_id, $data_db);
				}else{
					$categ_id = $this->categMD->insert($data_db);
				}

				return $this->response->redirect( site_url('categorias') );
				exit();

			} else {
				$this->data['validation'] = $validation->getErrors();
			}
		}


		$query = $this->categMD->where('categ_id', $categ_id)->get();
		if( $query && $query->resultID->num_rows >=1 )
		{
			$rs_dados = $query->getRow();
			$this->data['rs_dados'] = $rs_dados;
		}


		return view($this->directory .'/categorias-form', $this->data);
	}


	public function ajaxform( $action = "" )
	{
		$error_num = "1";
		$error_msg = "Erro inesperado";
		$redirect = "";

		switch ($action) {
		case "EXCLUIR-REGISTRO" :

			$categ_hashkey = $this->request->getPost('categ_hashkey');
			$query = $this->categMD->where('categ_hashkey', $categ_hashkey)->get();
			if( $query && $query->resultID->num_rows >=1 )
			{
				$rs_registro = $query->getRow();
				$categ_id = (int)$rs_registro->categ_id;			

				// excluir registro
				$this->categMD->where('categ_hashkey', $categ_hashkey)->delete();

				//$this->categMD->set('solt_excluido', 1);
				//$this->categMD->where('categ_hashkey', $categ_hashkey);
				//$this->categMD->where('categ_id', $categ_id);
				//$this->categMD->update();

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
