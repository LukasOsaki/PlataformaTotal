<?php
namespace App\Controllers;
use App\Controllers\PainelController;

class Permissoes extends PainelController
{

	protected $permMD = null;
	protected $prpagMD = null;
	protected $cfgAPP = null;

    public function __construct()
    {
        $this->permMD = new \App\Models\PermissoesModel();
		$this->prpagMD = new \App\Models\PermissoesAcoesModel();
		$this->cfgAPP = new \Config\AppSettings();

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


		$this->permMD->orderBy('perm_id', 'DESC')
			->limit(1000);
		$query = $this->permMD->get();

		//$this->data['lastQuery'] = $this->permMD->getLastQuery();
			//->getCompiledSelect();

		if( $query && $query->resultID->num_rows >=1 )
		{
			$this->data['rs_list'] = $query;
		}

		return view($this->directory .'/permissoes', $this->data);
	}


	public function form( $perm_id = 0 )
	{

		$this->data['list_sistema_areas'] = $this->cfgAPP->getSistemaAreas();
		$this->data['list_sistema_acoes'] = $this->cfgAPP->getSistemaAcoes();

		if ($this->request->getPost())
		{
			$validation =  \Config\Services::validation();
			$rules = [
				"perm_titulo" => [
					"label" => "perm_titulo", 
					"rules" => "required",
					'errors' => [
						'required' => 'Preencha corretamente',
					],
				],
			];

			if ($this->validate($rules)) {
				$perm_titulo = $this->request->getPost('perm_titulo');
				$perm_ativo = (int)$this->request->getPost('perm_ativo');

				$data_db = [
					'perm_hashkey' =>md5(date("Y-m-d H:i:s") ."-". random_string('alnum', 16)),
					'perm_urlpage' => url_title( convert_accented_characters($perm_titulo), '-', TRUE ),
					'perm_titulo' => $perm_titulo,
					'perm_dte_cadastro' => date("Y-m-d H:i:s"),
					'perm_dte_alteracao' => date("Y-m-d H:i:s"),
					'perm_ativo' => (int)$perm_ativo,
				];

				$queryEdit = $this->permMD->where('perm_id', $perm_id)->get();
				if( $queryEdit && $queryEdit->resultID->num_rows >=1 )
				{
					unset( $data_db['perm_hashkey'] );
					unset( $data_db['perm_dte_cadastro'] );
					$qryExecute = $this->permMD->update($perm_id, $data_db);
				}else{
					$perm_id = $this->permMD->insert($data_db);
				}


				/*
				 * -------------------------------------------------------------
				 * permissoes ações
				 * -------------------------------------------------------------
				**/
					$permissaoAcao = $this->request->getPost('permissaoAcao');
					print '<pre>';
					print_r( $permissaoAcao );
					print '</pre>';


					foreach ($permissaoAcao as $keyAcao => $valAcao) {
						if( is_array($valAcao) ){
							
							$pract_visualizar = 0;
							$pract_editar = 0;
							$pract_excluir = 0;
							$pract_cadastrar = 0;

							foreach ($valAcao as $keyItem => $valItem) {
								$pract_visualizar = (($keyItem == 'visualizar') ? 1 : $pract_visualizar);
								$pract_editar = (($keyItem == 'editar') ? 1 : $pract_editar);
								$pract_excluir = (($keyItem == 'excluir') ? 1 : $pract_excluir);
								$pract_cadastrar = (($keyItem == 'cadastrar') ? 1 : $pract_cadastrar);
							}
							$data_acao_db = [
								'perm_id' => (int)$perm_id,
								//'perm_hashkey' =>md5(date("Y-m-d H:i:s") ."-". random_string('alnum', 16)),
								//'perm_urlpage' => url_title( convert_accented_characters($perm_titulo), '-', TRUE ),
								'pract_titulo' => $keyAcao,
								'pract_visualizar' => $pract_visualizar,
								'pract_editar' => $pract_editar,
								'pract_excluir' => $pract_excluir,
								'pract_cadastrar' => $pract_cadastrar,
								'pract_dte_cadastro' => date("Y-m-d H:i:s"),
								'pract_dte_alteracao' => date("Y-m-d H:i:s"),
								//'pract_ativo' => (int)$perm_ativo,
							];
							$pract_id = $this->prpagMD->insert($data_acao_db);

							//$queryEdit = $this->permMD->where('perm_id', $perm_id)->get();
							//if( $queryEdit && $queryEdit->resultID->num_rows >=1 )
							//{
							//	unset( $data_db['perm_hashkey'] );
							//	unset( $data_db['perm_dte_cadastro'] );
							//	$qryExecute = $this->permMD->update($perm_id, $data_db);
							//}else{
							//	
							//}
								
						}
					}

					exit();




				return $this->response->redirect( site_url('permissoes') );
				exit();

			} else {
				$this->data['validation'] = $validation->getErrors();
			}
		}

		$query = $this->permMD->where('perm_id', $perm_id)->get();
		if( $query && $query->resultID->num_rows >=1 )
		{
			$rs_dados = $query->getRow();
			$this->data['rs_dados'] = $rs_dados;
		}

		return view($this->directory .'/permissoes-form', $this->data);
	}

}
