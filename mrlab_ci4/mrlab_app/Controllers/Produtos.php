<?php
namespace App\Controllers;
use App\Controllers\PainelController;

class Produtos extends PainelController
{
	
	protected $prodMD = null;
	protected $categMD = null;

    public function __construct()
    {
        $this->prodMD = new \App\Models\ProdutosModel();
		$this->categMD = new \App\Models\CategoriasModel();

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


		$query = $this->prodMD->from('tbl_produtos As PROD', true)
			->select('PROD.*')
			->select('CATEG.categ_titulo')
			->join('tbl_categorias CATEG', 'CATEG.categ_id = PROD.categ_id', 'LEFT')
			->orderBy('PROD.prod_id', 'ASC')
			->limit(1000)
			->get();

		$this->data['lastQuery'] = $this->prodMD->getLastQuery();
			//->getCompiledSelect();

		if( $query && $query->resultID->num_rows >=1 )
		{
			$this->data['rs_list'] = $query;
		}

		return view($this->directory .'/produtos', $this->data);
	}


	public function form( $prod_id = 0 )
	{
		if ($this->request->getPost())
		{
			$validation =  \Config\Services::validation();
			$rules = [
				"prod_titulo" => [
					"label" => "Nome", 
					"rules" => "required",
					'errors' => [
						'required' => 'Preencha corretamente',
					],
				],
			];

			if ($this->validate($rules)) {
				$categ_id = (int)$this->request->getPost('categ_id');
				$prod_titulo = $this->request->getPost('prod_titulo');
				$prod_resumo = $this->request->getPost('prod_resumo');
				$prod_descricao = $this->request->getPost('prod_descricao');
				$prod_info_adicional = $this->request->getPost('prod_info_adicional');
				$prod_valor = $this->request->getPost('prod_valor');
				$prod_arquivo = $this->request->getPost('prod_arquivo');
				$prod_ativo = (int)$this->request->getPost('prod_ativo');


				$newFileUpload = "";
				$fileIMAGEM = $this->request->getFile('file_arquivo');
				if( $fileIMAGEM ){
					if ($fileIMAGEM->isValid() && ! $fileIMAGEM->hasMoved()){
						$originalName = $fileIMAGEM->getClientName();

						$arq_original = $originalName; 
						$extension = $fileIMAGEM->getClientExtension();
						$extension = empty($extension) ? '' : '.' . $extension;
						$originalName = str_replace($extension, "", $originalName);
						
						$originalName = url_title( convert_accented_characters($originalName), '-', TRUE );
						$newFileUpload = $originalName .'___'. time() .'_'. random_string('alnum', 4) . $extension;
						
						//$newFileUpload = $originalName .'___'. $fileIMAGEM->getRandomName();
						$fileIMAGEM->move( $this->folder_upload .'produtos', $newFileUpload);

						$prod_arquivo = $newFileUpload; 
					}
				}


				$data_db = [
					'categ_id' => $categ_id,
					'prod_hashkey' =>md5(date("Y-m-d H:i:s") ."-". random_string('alnum', 16)),
					'prod_urlpage' => url_title( convert_accented_characters($prod_titulo), '-', TRUE ),
					'prod_titulo' => $prod_titulo,
					'prod_resumo' => $prod_resumo,
					'prod_descricao' => $prod_descricao,
					'prod_info_adicional' => $prod_info_adicional,
					'prod_valor' => $prod_valor,
					'prod_arquivo' => $prod_arquivo,
					'prod_dte_cadastro' => date("Y-m-d H:i:s"),
					'prod_dte_alteracao' => date("Y-m-d H:i:s"),
					'prod_ativo' => (int)$prod_ativo,
				];

				$queryEdit = $this->prodMD->where('prod_id', $prod_id)->get();
				if( $queryEdit && $queryEdit->resultID->num_rows >=1 )
				{
					unset( $data_db['prod_hashkey'] );
					unset( $data_db['prod_dte_cadastro'] );
					$qryExecute = $this->prodMD->update($prod_id, $data_db);
				}else{
					$prod_id = $this->prodMD->insert($data_db);
				}

				return $this->response->redirect( site_url('produtos') );
				exit();

			} else {
				$this->data['validation'] = $validation->getErrors();
			}
		}


		$query = $this->prodMD->where('prod_id', $prod_id)->get();
		if( $query && $query->resultID->num_rows >=1 )
		{
			$rs_dados = $query->getRow();
			$this->data['rs_dados'] = $rs_dados;
		}


		$query_categ = $this->categMD->where('categ_ativo', 1)->get();
		if( $query_categ && $query_categ->resultID->num_rows >=1 )
		{
			$this->data['rs_categ'] = $query_categ;
		}

		return view($this->directory .'/produtos-form', $this->data);
	}

}
