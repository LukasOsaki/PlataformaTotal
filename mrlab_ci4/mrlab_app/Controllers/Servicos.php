<?php
namespace App\Controllers;
use App\Controllers\PainelController;

class Servicos extends PainelController
{
	protected $pendMD = null;
	protected $clieMD = null;
	protected $eqtoMD = null;
	protected $categMD = null;

    public function __construct()
    {
        $this->pendMD = new \App\Models\PendenciasModel();
		$this->pendTagMD = new \App\Models\PendenciasTagsModel();
		$this->clieMD = new \App\Models\ClientesModel();
		$this->eqtoMD = new \App\Models\EquipamentosModel();
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
		$template = 'servicos';
		$sessionAdmin_user_nivel = session()->get('admin_nivel'); 
		if( $sessionAdmin_user_nivel == 'cliente'){
			$template = 'servicos-cliente';
		}




		$filtro_pdf = '';
		// filtrar/user:marcio/cliente:123/dini:/dteend:/status:pago

		$uri = service('uri'); // Obter a instância do objeto URI
		$segments = $uri->getSegments();
		$index = array_search('filtrar', $segments); // Encontrar o índice do segmento "filtrar"

		$filteredSegments = array_slice($segments, $index + 1); // Retornar os elementos a partir de $index + 1 até o final

		$this->pendMD->from('tbl_pendencias As PEND', true)
			->select('PEND.*')
			->select('TAG.pendtag_tag, TAG.pendtag_tipo_serv, TAG.pendtag_status, TAG.pendtag_dte_registro, TAG.pendtag_dte_instalacao, TAG.pendtag_descricao')
			->select('CLIE.clie_nome_razao, CLIE.clie_nome_fantasia')
			->select('CATEG.categ_titulo, CATEG.categ_color')
			->join('tbl_pendencias_tags TAG', 'TAG.pend_id = PEND.pend_id', 'LEFT')
			->join('tbl_categorias CATEG', 'CATEG.categ_id = TAG.pendtag_status', 'LEFT')
			->join('tbl_clientes CLIE', 'CLIE.clie_id = PEND.clie_id', 'LEFT');

			if( $sessionAdmin_user_nivel == 'cliente'){
				$clie_id = (int)session()->get('admin_id');
				$this->pendMD->where('PEND.clie_id', $clie_id);
			}

		$query = $this->pendMD->orderBy('PEND.pend_id', 'ASC')
			// ->limit(1000)
			->get();

		//$this->pendMD->orderBy('pend_id', 'DESC')
		//	->limit(1000);
		//$query = $this->pendMD->get();

		$this->data['lastQuery'] = $this->pendMD->getLastQuery();
			//->getCompiledSelect();

		if( $query && $query->resultID->num_rows >=1 )
		{
			$this->data['rs_list'] = $query;
		}

		return view($this->directory .'/'. $template , $this->data);
	}


	public function form( $pend_id = 0 )
	{
		if ($this->request->getPost())
		{
			$validation =  \Config\Services::validation();
			$rules = [
				"clie_id" => [
					"label" => "Cliente", 
					"rules" => "required",
					'errors' => [
						'required' => 'Preencha corretamente',
					],
				],
			];

			if ($this->validate($rules)) {
				$clie_id = (int)$this->request->getPost('clie_id');
				//$pend_dte_registro = $this->request->getPost('pend_dte_registro');
				$pend_tipo_serv = $this->request->getPost('pend_tipo_serv');
				$pend_status = $this->request->getPost('pend_status');
				$pend_num_os = $this->request->getPost('pend_num_os');
				//$pend_descricao = $this->request->getPost('pend_descricao');
				$pend_tag = $this->request->getPost('pend_tag');
				//$pend_dte_compra = $this->request->getPost('pend_dte_compra');
				//$pend_dte_instalacao = $this->request->getPost('pend_dte_instalacao');
				$pend_coment_interno = $this->request->getPost('pend_coment_interno');
				$pend_observacoes = $this->request->getPost('pend_observacoes');
				$pend_ativo = $this->request->getPost('pend_ativo');

				$data_db = [
					'clie_id' => $clie_id,
					'pend_hashkey' => md5(date("Y-m-d H:i:s") ."-". random_string('alnum', 16)),
					//'eqto_urlpage' => url_title( convert_accented_characters($eqto_titulo), '-', TRUE ),
					//'pend_dte_registro' => fct_date2bd($pend_dte_registro),
					//'pend_tipo_serv' => $pend_tipo_serv,
					//'pend_status' => $pend_status,
					'pend_num_os' => $pend_num_os,
					//'pend_descricao' => $pend_descricao,
					'pend_tag' => $pend_tag,
					//'pend_dte_compra' => fct_date2bd($pend_dte_compra),
					//'pend_dte_instalacao' => fct_date2bd($pend_dte_instalacao),
					'pend_coment_interno' => $pend_coment_interno,
					'pend_observacoes' => $pend_observacoes,
					'pend_dte_cadastro' => date("Y-m-d H:i:s"),
					'pend_dte_alteracao' => date("Y-m-d H:i:s"),
					'pend_ativo' => (int)$pend_ativo,
				];

				$queryEdit = $this->pendMD->where('pend_id', $pend_id)->get();
				if( $queryEdit && $queryEdit->resultID->num_rows >=1 )
				{
					unset( $data_db['pend_hashkey'] );
					unset( $data_db['pend_dte_cadastro'] );
					$qryExecute = $this->pendMD->update($pend_id, $data_db);
				}else{
					$pend_id = $this->pendMD->insert($data_db);
				}


				// ------------------------------------------------------------
				// Valores
				// ------------------------------------------------------------
				$arr_pendtag_tag = $this->request->getPost('pendtag_tag');
				$arr_pendtag_eqto_id = $this->request->getPost('pendtag_eqto_id');
				$arr_pendtag_equipamento = $this->request->getPost('pendtag_equipamento');

				$arr_pendtag_dte_registro = $this->request->getPost('pendtag_dte_registro');
				$arr_pendtag_dte_instalacao = $this->request->getPost('pendtag_dte_instalacao');
				$arr_pendtag_tipo_serv = $this->request->getPost('pendtag_tipo_serv');
				$arr_pendtag_status = $this->request->getPost('pendtag_status');

				$arr_pendtag_descricao = $this->request->getPost('pendtag_descricao');
				$arr_pendtag_observacoes = $this->request->getPost('pendtag_observacoes');
				$arr_pendtag_id = $this->request->getPost('pendtag_id');
				//$arr_pendtag_anexos = $this->request->getPost('pendtag_anexos');
				//$arr_tvlr_valor = $this->request->getPost('tvlr_valor');
				//$arr_tvlr_id = $this->request->getPost('tvlr_id');
				//var_dump( $arr_tvlr_titulo );
				//exit();
				if( is_array($arr_pendtag_eqto_id)){
					foreach ($arr_pendtag_eqto_id as $key => $val) {
						//echo('<hr>');
						$pendtag_eqto_id = (int)$val;
						$pendtag_tag = $arr_pendtag_tag[$key];
						$pendtag_equipamento = $arr_pendtag_equipamento[$key];
						$pendtag_dte_registro = $arr_pendtag_dte_registro[$key];
						$pendtag_dte_instalacao = $arr_pendtag_dte_instalacao[$key];
						$pendtag_tipo_serv = $arr_pendtag_tipo_serv[$key];
						$pendtag_status = $arr_pendtag_status[$key];
						$pendtag_descricao = $arr_pendtag_descricao[$key];
						$pendtag_observacoes = $arr_pendtag_observacoes[$key];
						$pendtag_id = (int)$arr_pendtag_id[$key];

						if( $pendtag_eqto_id > 0 )
						{
							$acaoTAGS = 'INSERT';
							if( $pendtag_id > 0 ){
								$query_tag = $this->pendTagMD
									->where('pendtag_id', $pendtag_id)
									->where('pend_id', $pend_id)
									->orderBy('pendtag_id', 'DESC')
									->limit(1)
									->get();
								if( $query_tag && $query_tag->resultID->num_rows >=1 )
								{
									$acaoTAGS = 'UPDATE';
								}
							}
							$data_tag_db = [
								'pend_id' => $pend_id, 
								'eqto_id' => $pendtag_eqto_id, 
								'pendtag_hashkey' => md5(date("Y-m-d H:i:s") ."-". random_string('alnum', 16)),
								'pendtag_dte_registro' => fct_date2bd($pendtag_dte_registro),
								'pendtag_dte_instalacao' => fct_date2bd($pendtag_dte_instalacao),
								'pendtag_tipo_serv' => $pendtag_tipo_serv,
								'pendtag_status' => $pendtag_status,
								'pendtag_tag' => $pendtag_tag ." | ". $pendtag_equipamento,
								'pendtag_descricao' => $pendtag_descricao,
								'pendtag_observacoes' => $pendtag_observacoes,
								'pendtag_dte_cadastro' => date("Y-m-d H:i:s"),
								'pendtag_dte_alteracao' => date("Y-m-d H:i:s"),
								'pendtag_ativo' => 1
							];
							if( $acaoTAGS == "INSERT" ){
								$pendtag_id = $this->pendTagMD->insert($data_tag_db);	
							}
							if( $acaoTAGS == "UPDATE" ){	
								unset( $data_tag_db['pendtag_hashkey'] );
								unset( $data_tag_db['pendtag_dte_cadastro'] );
								$qryExecuteTAGS = $this->pendTagMD->update($pendtag_id, $data_tag_db);
							}
						}
					}
				}

				return $this->response->redirect( site_url('servicos') );
				exit();

			} else {
				$this->data['validation'] = $validation->getErrors();
			}
		}


		$this->pendMD->where('pend_id', $pend_id);

		$template = 'servicos-form';
		$sessionAdmin_user_nivel = session()->get('admin_nivel'); 
		
		if( $sessionAdmin_user_nivel == 'cliente'){
			$template = 'servicos-cliente-form';

			$clie_id = (int)session()->get('admin_id');
			$this->pendMD->where('clie_id', $clie_id);
		}

		$query = $this->pendMD->get();

		if( $query && $query->resultID->num_rows >=1 )
		{
			$rs_dados = $query->getRow();
			$this->data['rs_dados'] = $rs_dados;








			$this->pendTagMD->from('tbl_pendencias_tags As TAG', true)
				->select('TAG.*')
				->select('EQTO.eqto_tag, EQTO.eqto_titulo')
				->join('tbl_equipamentos EQTO', 'EQTO.eqto_id = TAG.eqto_id', 'LEFT');
			$this->pendTagMD->where('TAG.pend_id', $pend_id);
			$this->pendTagMD->orderBy('TAG.pend_id', 'ASC');
			$query_tags = $this->pendTagMD->get();
			//$query_tags = $this->pendTagMD->where('pend_id', $pend_id)->get();
			if( $query_tags && $query_tags->resultID->num_rows >=1 )
			{
				$this->data['rs_tags'] = $query_tags;
			}


		}

		//$query_cliente = $this->clieMD->where('clie_ativo', 1)->get();
		//if( $query_cliente && $query_cliente->resultID->num_rows >=1 )
		//{
		//	$this->data['rs_clientes'] = $query_cliente;
		//}

		//$query_equipamentos = $this->eqtoMD->where('clie_ativo', 1)->get();
		//if( $query_equipamentos && $query_equipamentos->resultID->num_rows >=1 )
		//{
		//	$this->data['rs_equipamento'] = $query_equipamentos;
		//}

		$query_status = $this->categMD->where('categ_area', 'pendencias-status')->get();
		if( $query_status && $query_status->resultID->num_rows >=1 )
		{
			$this->data['rs_status'] = $query_status;
		}

		$query_tipo_serv = $this->categMD->where('categ_area', 'pendencias-tipo-serv')->get();
		if( $query_tipo_serv && $query_tipo_serv->resultID->num_rows >=1 )
		{
			$this->data['rs_tipo_serv'] = $query_tipo_serv;
		}

		$query_clientes = $this->clieMD->where('clie_ativo', '1')->get();
		if( $query_clientes && $query_clientes->resultID->num_rows >=1 )
		{
			$this->data['rs_clientes'] = $query_clientes;
		}

		return view($this->directory .'/'. $template, $this->data);
	}


	public function impressao( $pend_id = 0 )
	{
		if ($this->request->getPost())
		{
			$validation =  \Config\Services::validation();
			$rules = [
				"clie_id" => [
					"label" => "Cliente", 
					"rules" => "required",
					'errors' => [
						'required' => 'Preencha corretamente',
					],
				],
			];

			if ($this->validate($rules)) {
				$clie_id = (int)$this->request->getPost('clie_id');
				//$pend_dte_registro = $this->request->getPost('pend_dte_registro');
				$pend_tipo_serv = $this->request->getPost('pend_tipo_serv');
				$pend_status = $this->request->getPost('pend_status');
				$pend_num_os = $this->request->getPost('pend_num_os');
				//$pend_descricao = $this->request->getPost('pend_descricao');
				$pend_tag = $this->request->getPost('pend_tag');
				//$pend_dte_compra = $this->request->getPost('pend_dte_compra');
				//$pend_dte_instalacao = $this->request->getPost('pend_dte_instalacao');
				$pend_coment_interno = $this->request->getPost('pend_coment_interno');
				$pend_observacoes = $this->request->getPost('pend_observacoes');
				$pend_ativo = $this->request->getPost('pend_ativo');

				$data_db = [
					'clie_id' => $clie_id,
					'pend_hashkey' => md5(date("Y-m-d H:i:s") ."-". random_string('alnum', 16)),
					//'eqto_urlpage' => url_title( convert_accented_characters($eqto_titulo), '-', TRUE ),
					//'pend_dte_registro' => fct_date2bd($pend_dte_registro),
					//'pend_tipo_serv' => $pend_tipo_serv,
					//'pend_status' => $pend_status,
					'pend_num_os' => $pend_num_os,
					//'pend_descricao' => $pend_descricao,
					'pend_tag' => $pend_tag,
					//'pend_dte_compra' => fct_date2bd($pend_dte_compra),
					//'pend_dte_instalacao' => fct_date2bd($pend_dte_instalacao),
					'pend_coment_interno' => $pend_coment_interno,
					'pend_observacoes' => $pend_observacoes,
					'pend_dte_cadastro' => date("Y-m-d H:i:s"),
					'pend_dte_alteracao' => date("Y-m-d H:i:s"),
					'pend_ativo' => (int)$pend_ativo,
				];

				$queryEdit = $this->pendMD->where('pend_id', $pend_id)->get();
				if( $queryEdit && $queryEdit->resultID->num_rows >=1 )
				{
					unset( $data_db['pend_hashkey'] );
					unset( $data_db['pend_dte_cadastro'] );
					$qryExecute = $this->pendMD->update($pend_id, $data_db);
				}else{
					$pend_id = $this->pendMD->insert($data_db);
				}


				// ------------------------------------------------------------
				// Valores
				// ------------------------------------------------------------
				$arr_pendtag_tag = $this->request->getPost('pendtag_tag');
				$arr_pendtag_eqto_id = $this->request->getPost('pendtag_eqto_id');
				$arr_pendtag_equipamento = $this->request->getPost('pendtag_equipamento');

				$arr_pendtag_dte_registro = $this->request->getPost('pendtag_dte_registro');
				$arr_pendtag_dte_instalacao = $this->request->getPost('pendtag_dte_instalacao');
				$arr_pendtag_tipo_serv = $this->request->getPost('pendtag_tipo_serv');
				$arr_pendtag_status = $this->request->getPost('pendtag_status');

				$arr_pendtag_descricao = $this->request->getPost('pendtag_descricao');
				$arr_pendtag_observacoes = $this->request->getPost('pendtag_observacoes');
				$arr_pendtag_id = $this->request->getPost('pendtag_id');
				//$arr_pendtag_anexos = $this->request->getPost('pendtag_anexos');
				//$arr_tvlr_valor = $this->request->getPost('tvlr_valor');
				//$arr_tvlr_id = $this->request->getPost('tvlr_id');
				//var_dump( $arr_tvlr_titulo );
				//exit();
				if( is_array($arr_pendtag_eqto_id)){
					foreach ($arr_pendtag_eqto_id as $key => $val) {
						//echo('<hr>');
						$pendtag_eqto_id = (int)$val;
						$pendtag_tag = $arr_pendtag_tag[$key];
						$pendtag_equipamento = $arr_pendtag_equipamento[$key];
						$pendtag_dte_registro = $arr_pendtag_dte_registro[$key];
						$pendtag_dte_instalacao = $arr_pendtag_dte_instalacao[$key];
						$pendtag_tipo_serv = $arr_pendtag_tipo_serv[$key];
						$pendtag_status = $arr_pendtag_status[$key];
						$pendtag_descricao = $arr_pendtag_descricao[$key];
						$pendtag_observacoes = $arr_pendtag_observacoes[$key];
						$pendtag_id = (int)$arr_pendtag_id[$key];

						if( $pendtag_eqto_id > 0 )
						{
							$acaoTAGS = 'INSERT';
							if( $pendtag_id > 0 ){
								$query_tag = $this->pendTagMD
									->where('pendtag_id', $pendtag_id)
									->where('pend_id', $pend_id)
									->orderBy('pendtag_id', 'DESC')
									->limit(1)
									->get();
								if( $query_tag && $query_tag->resultID->num_rows >=1 )
								{
									$acaoTAGS = 'UPDATE';
								}
							}
							$data_tag_db = [
								'pend_id' => $pend_id, 
								'eqto_id' => $pendtag_eqto_id, 
								'pendtag_hashkey' => md5(date("Y-m-d H:i:s") ."-". random_string('alnum', 16)),
								'pendtag_dte_registro' => fct_date2bd($pendtag_dte_registro),
								'pendtag_dte_instalacao' => fct_date2bd($pendtag_dte_instalacao),
								'pendtag_tipo_serv' => $pendtag_tipo_serv,
								'pendtag_status' => $pendtag_status,
								'pendtag_tag' => $pendtag_tag ." | ". $pendtag_equipamento,
								'pendtag_descricao' => $pendtag_descricao,
								'pendtag_observacoes' => $pendtag_observacoes,
								'pendtag_dte_cadastro' => date("Y-m-d H:i:s"),
								'pendtag_dte_alteracao' => date("Y-m-d H:i:s"),
								'pendtag_ativo' => 1
							];
							if( $acaoTAGS == "INSERT" ){
								$pendtag_id = $this->pendTagMD->insert($data_tag_db);	
							}
							if( $acaoTAGS == "UPDATE" ){	
								unset( $data_tag_db['pendtag_hashkey'] );
								unset( $data_tag_db['pendtag_dte_cadastro'] );
								$qryExecuteTAGS = $this->pendTagMD->update($pendtag_id, $data_tag_db);
							}
						}
					}
				}

				return $this->response->redirect( site_url('servicos') );
				exit();

			} else {
				$this->data['validation'] = $validation->getErrors();
			}
		}


		$this->pendMD->where('pend_id', $pend_id);

		$template = 'servicos-impressao';
		$sessionAdmin_user_nivel = session()->get('admin_nivel'); 
		
		if( $sessionAdmin_user_nivel == 'cliente'){
			$template = 'servicos-cliente-form';

			$clie_id = (int)session()->get('admin_id');
			$this->pendMD->where('clie_id', $clie_id);
		}

		$query = $this->pendMD->get();

		if( $query && $query->resultID->num_rows >=1 )
		{
			$rs_dados = $query->getRow();
			$this->data['rs_dados'] = $rs_dados;








			$this->pendTagMD->from('tbl_pendencias_tags As TAG', true)
				->select('TAG.*')
				->select('EQTO.eqto_tag, EQTO.eqto_titulo')
				->join('tbl_equipamentos EQTO', 'EQTO.eqto_id = TAG.eqto_id', 'LEFT');
			$this->pendTagMD->where('TAG.pend_id', $pend_id);
			$this->pendTagMD->orderBy('TAG.pend_id', 'ASC');
			$query_tags = $this->pendTagMD->get();
			//$query_tags = $this->pendTagMD->where('pend_id', $pend_id)->get();
			if( $query_tags && $query_tags->resultID->num_rows >=1 )
			{
				$this->data['rs_tags'] = $query_tags;
			}


		}

		//$query_cliente = $this->clieMD->where('clie_ativo', 1)->get();
		//if( $query_cliente && $query_cliente->resultID->num_rows >=1 )
		//{
		//	$this->data['rs_clientes'] = $query_cliente;
		//}

		//$query_equipamentos = $this->eqtoMD->where('clie_ativo', 1)->get();
		//if( $query_equipamentos && $query_equipamentos->resultID->num_rows >=1 )
		//{
		//	$this->data['rs_equipamento'] = $query_equipamentos;
		//}

		$query_status = $this->categMD->where('categ_area', 'pendencias-status')->get();
		if( $query_status && $query_status->resultID->num_rows >=1 )
		{
			$this->data['rs_status'] = $query_status;
		}

		$query_tipo_serv = $this->categMD->where('categ_area', 'pendencias-tipo-serv')->get();
		if( $query_tipo_serv && $query_tipo_serv->resultID->num_rows >=1 )
		{
			$this->data['rs_tipo_serv'] = $query_tipo_serv;
		}

		$query_clientes = $this->clieMD->where('clie_ativo', '1')->get();
		if( $query_clientes && $query_clientes->resultID->num_rows >=1 )
		{
			$this->data['rs_clientes'] = $query_clientes;
		}

		return view($this->directory .'/servicos-impressao', $this->data);
	}


	public function ajaxform( $action = "" )
	{
		$error_num = "1";
		$error_msg = "Erro inesperado";
		$redirect = "";

		switch ($action) {
		case "EXCLUIR-PENDENCIA-TAG" :

			$pendtag_hashkey = $this->request->getPost('hashkey');
			$queryDeleteTag = $this->pendTagMD->where('pendtag_hashkey', $pendtag_hashkey)->get();
			if( $queryDeleteTag && $queryDeleteTag->resultID->num_rows >=1 )
			{
				$rs_registro = $queryDeleteTag->getRow();
				$pendtag_id = (int)$rs_registro->pendtag_id;

				// excluir inscricao
				$this->pendTagMD->where('pendtag_hashkey', $pendtag_hashkey)->delete();

				$error_num = "0";
				$error_msg = "Registro excluído com sucesso!";
				$redirect = "";
			}

			$arr_return = array(
				"error_num" => $error_num,
				"error_msg" => $error_msg,
			);

			echo( json_encode($arr_return) );
			exit();
		break;
		case "ENVIAR-EMAIL-CADASTRO" :

			$cad_hashkey = $this->request->getPost('cad_hashkey');
			$query = $this->cadMD->where('cad_hashkey', $cad_hashkey)->get();			

			if( $query && $query->resultID->num_rows >=1 )
			{
				$rs = $query->getRow();
				$cad_id = (int)$rs->cad_id;
				$cad_email = $rs->cad_email;

				/*
				* -------------------------------------------------------------
				* enviando email após confirmação de pagamento
				* -------------------------------------------------------------
				**/	
				self::enviarEmailCadastro($cad_id);				

				$error_num = "0";
				$error_msg = "E-mail enviado com sucesso!";
				$redirect = "";				

				$arr_return = array(
					"error_num" => $error_num,
					"error_msg" => $error_msg,
				);
			}

			echo( json_encode($arr_return) );
			exit();
		break;
		case "GERAR-NOVO-PDF" :

			$cad_hashkey = $this->request->getPost('cad_hashkey');
			$query = $this->cadMD->where('cad_hashkey', $cad_hashkey)->get();			

			if( $query && $query->resultID->num_rows >=1 )
			{
				$rs = $query->getRow();
				$cad_id = (int)$rs->cad_id;
				$cad_hashkey = $rs->cad_hashkey;
				$cad_email = $rs->cad_email;
				$cad_cpf = $rs->cad_cpf;
				$cad_nome_completo = $rs->cad_nome_completo;
				$cad_qrcode = $rs->cad_qrcode;

				// caso o Numero do QRCode não exista, geramos um novo
				if( empty($cad_qrcode) ){
					helper('text');
					$num_random = random_string('alnum', 3);
					$num_random = strtoupper($num_random);

					$rand_id = str_pad($cad_id , 4 , '0' , STR_PAD_LEFT);
					$cad_qrcode = strtoupper('LCSU'. $rand_id . $num_random);

					$this->cadMD->set('cad_qrsalt', $num_random);
					$this->cadMD->set('cad_qrcode', $cad_qrcode);
					$this->cadMD->where('cad_hashkey', $cad_hashkey);
					$this->cadMD->update();
				}

				/*
				* -------------------------------------------------------------
				* Gerar o QRCode e PDF
				* -------------------------------------------------------------
				**/	
					$libQRCode = new QRCodeLib();
					$libQRCode->GerarQRCode($cad_qrcode);
					$libQRCode->GerarPDF($cad_qrcode, $cad_nome_completo);

				/*
				* -------------------------------------------------------------
				* log
				* -------------------------------------------------------------
				**/	
					$fields_log = [];
					$fields_log['log_ip'] = $_SERVER['REMOTE_ADDR'];
					$fields_log['log_tipo'] = "admin-gerar-pdf";
					$fields_log['cad_id'] = $cad_id;
					$fields_log['cad_qrcode'] = $cad_qrcode;
					$fields_log['cad_cpf'] = $cad_cpf;
					$fields_log['cad_email'] = $cad_email;
					$this->logMD->save_log($fields_log);

				$error_num = "0";
				$error_msg = "Ingresso gerado com sucesso!";
				$redirect = "";				

				$arr_return = array(
					"error_num" => $error_num,
					"error_msg" => $error_msg,
				);
			}

			echo( json_encode($arr_return) );
			exit();
		break;		
		}
	}

}
