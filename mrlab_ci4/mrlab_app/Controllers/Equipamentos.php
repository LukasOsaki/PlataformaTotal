<?php
namespace App\Controllers;
use App\Controllers\PainelController;

class Equipamentos extends PainelController
{
	protected $eqtoMD = null;
	protected $clieMD = null;

    public function __construct()
    {
        $this->eqtoMD = new \App\Models\EquipamentosModel();
		$this->clieMD = new \App\Models\ClientesModel();

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

		//$this->eqtoMD->orderBy('eqto_id', 'DESC')
		//	->limit(1000);
		//$query = $this->eqtoMD->get();

		$this->eqtoMD->from('tbl_equipamentos AS EQTO', true);
		$this->eqtoMD->select('EQTO.*');
		$this->eqtoMD->select('CLIE.clie_nome_razao');
		$this->eqtoMD->join('tbl_clientes CLIE', 'CLIE.clie_id = EQTO.clie_id', 'LEFT');
		$this->eqtoMD->orderBy('EQTO.eqto_id', 'ASC');
		$this->eqtoMD->limit(1000);
		$query = $this->eqtoMD->get();

		$this->data['lastQuery'] = $this->eqtoMD->getLastQuery();
			//->getCompiledSelect();

		if( $query && $query->resultID->num_rows >=1 )
		{
			$this->data['rs_list'] = $query;
		}

		return view($this->directory .'/equipamentos', $this->data);
	}


	public function form( $eqto_id = 0 )
	{
		$prosseguir = true;

		if ($this->request->getPost())
		{
			$validation =  \Config\Services::validation();
			$rules = [
				"eqto_titulo" => [
					"label" => "Título", 
					"rules" => "required",
					'errors' => [
						'required' => 'Preencha corretamente',
					],
				],
			];

			if ($this->validate($rules)) {
				$clie_id = (int)$this->request->getPost('clie_id');
				$eqto_titulo = $this->request->getPost('eqto_titulo');
				$eqto_tag = $this->request->getPost('eqto_tag');
				$eqto_setor = $this->request->getPost('eqto_setor');
				$eqto_local = $this->request->getPost('eqto_local');
				$eqto_capacidade = $this->request->getPost('eqto_capacidade');
				$eqto_fluido_ref = $this->request->getPost('eqto_fluido_ref');
				$eqto_fabricante = $this->request->getPost('eqto_fabricante');
				$eqto_modelo_cond = $this->request->getPost('eqto_modelo_cond');
				$eqto_modelo_evap = $this->request->getPost('eqto_modelo_evap');
				$eqto_observacoes = $this->request->getPost('eqto_observacoes');
				$eqto_ativo = $this->request->getPost('eqto_ativo');

				/*
				 * -------------------------------------------------------------
				 * Verificamos se a tag já existe
				 * -------------------------------------------------------------
				**/
					if( $prosseguir == true ){
						$query_check_tag = $this->eqtoMD
							->where('eqto_tag', $eqto_tag)
							->where('clie_id', $clie_id)
							->where('eqto_id !=', $eqto_id)
							->limit(1)
							->get();
						if( $query_check_tag && $query_check_tag->resultID->num_rows >= 1 )
						{
							$error_num = 1;
							$prosseguir = false;
						}
					}

				if( $prosseguir == true ){
					$data_db = [
						'clie_id' => $clie_id,
						'eqto_hashkey' => md5(date("Y-m-d H:i:s") ."-". random_string('alnum', 16)),
						'eqto_urlpage' => url_title( convert_accented_characters($eqto_titulo), '-', TRUE ),
						'eqto_titulo' => $eqto_titulo,
						'eqto_tag' => $eqto_tag,
						'eqto_setor' => $eqto_setor,
						'eqto_local' => $eqto_local,
						'eqto_capacidade' => $eqto_capacidade,
						'eqto_fluido_ref' => $eqto_fluido_ref,
						'eqto_fabricante' => $eqto_fabricante,
						'eqto_modelo_cond' => $eqto_modelo_cond,
						'eqto_modelo_evap' => $eqto_modelo_evap,
						'eqto_observacoes' => $eqto_observacoes,
						'eqto_dte_cadastro' => date("Y-m-d H:i:s"),
						'eqto_dte_alteracao' => date("Y-m-d H:i:s"),
						'eqto_ativo' => (int)$eqto_ativo,
					];

					$queryEdit = $this->eqtoMD->where('eqto_id', $eqto_id)->get();
					if( $queryEdit && $queryEdit->resultID->num_rows >=1 )
					{
						unset( $data_db['eqto_hashkey'] );
						unset( $data_db['eqto_dte_cadastro'] );
						$qryExecute = $this->eqtoMD->update($eqto_id, $data_db);
					}else{
						$eqto_id = $this->eqtoMD->insert($data_db);
					}

				}

				return $this->response->redirect( site_url('equipamentos') );
				exit();

			} else {
				$this->data['validation'] = $validation->getErrors();
			}
		}


		$query = $this->eqtoMD->where('eqto_id', $eqto_id)->get();
		if( $query && $query->resultID->num_rows >=1 )
		{
			$rs_dados = $query->getRow();
			$this->data['rs_dados'] = $rs_dados;
		}

		$query_clientes = $this->clieMD
			->where('clie_ativo', '1')
			->orderBy('clie_nome_razao', 'ASC')
			->get();
		if( $query_clientes && $query_clientes->resultID->num_rows >=1 )
		{
			$this->data['rs_clientes'] = $query_clientes;
		}

		return view($this->directory .'/equipamentos-form', $this->data);
	}


	public function ajaxform( $action = "" )
	{
		$error_num = "1";
		$error_msg = "Erro inesperado";
		$redirect = "";

		switch ($action) {
		case "BUSCA-NOME-EQUIPAMENTO" :
			$clie_id = (int)$this->request->getPost('clie_id');
			$eqto_tag = $this->request->getPost('eqto_tag');

			$eqto_id = 0;
			$eqto_titulo = '';
			if( !empty($eqto_tag) ){

				$query = $this->eqtoMD
					->where('clie_id', $clie_id)
					->where('eqto_tag', $eqto_tag)
					->get();
					if( $query && $query->resultID->num_rows >=1 )
					{
						$rs_dados = $query->getRow();
						$eqto_id = $rs_dados->eqto_id;
						$eqto_titulo = $rs_dados->eqto_titulo;

						$error_num = "0";
						$error_msg = "Tag encontrada";
					}else{
						$error_num = "1";
						$error_msg = "não encontrado";			
					}
			}
		
			$arr_return = array(
				"error_num" => $error_num,
				"error_msg" => $error_msg,
				"eqto_id" => $eqto_id,
				"eqto_titulo" => $eqto_titulo,
			);

			echo( json_encode($arr_return) );
			exit();
		break;	
		case "CHECK-EQUIPAMENTO" :
			$eqto_id = (int)$this->request->getPost('eqto_id');
			$clie_id = (int)$this->request->getPost('clie_id');
			$eqto_tag = $this->request->getPost('eqto_tag');

			$eqto_titulo = '';
			if( !empty($eqto_tag) ){
				$query = $this->eqtoMD
					->where('clie_id', $clie_id)
					->where('eqto_tag', $eqto_tag)
					->where('eqto_id !=', $eqto_id)
					->get();


				if( $query && $query->resultID->num_rows >=1 )
				{
					$rs_dados = $query->getRow();
					$eqto_id = $rs_dados->eqto_id;
					$eqto_titulo = $rs_dados->eqto_titulo;

					$error_num = "1";
					$error_msg = "Existe uma tag com mesmo número<br>para o cliente selecionado.";
				}else{
					$error_num = "0";
					$error_msg = "não encontrado";
				}
			}
		
			$arr_return = array(
				"error_num" => $error_num,
				"error_msg" => $error_msg,
				"eqto_id" => $eqto_id,
				"eqto_titulo" => $eqto_titulo,
			);

			echo( json_encode($arr_return) );
			exit();
		break;	
		case "EXCLUIR-EQUIPAMENTO" :
			$eqto_hashkey = $this->request->getPost('eqto_hashkey');
			if( !empty($eqto_hashkey) ){
				$query = $this->eqtoMD
					->where('eqto_hashkey', $eqto_hashkey)
					->limit(1)
					->get();
				if( $query && $query->resultID->num_rows >=1 )
				{
					$rs_dados = $query->getRow();
					$this->eqtoMD->where('eqto_hashkey', $eqto_hashkey)->delete();

					$error_num = "0";
					$error_msg = "Equipamento excluído com sucesso!";
				}else{
					$error_num = "1";
					$error_msg = "Não localizamos o equipamento na base de dados!";
				}
			}
		
			$arr_return = array(
				"error_num" => $error_num,
				"error_msg" => $error_msg,
			);

			echo( json_encode($arr_return) );
			exit();
		break;	
		}
	}

}
