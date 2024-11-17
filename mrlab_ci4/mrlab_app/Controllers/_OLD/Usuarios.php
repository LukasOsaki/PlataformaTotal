<?php
namespace App\Controllers;
use App\Controllers\BaseController;

class Usuarios extends BaseController
{
	protected $userMD = null;
	protected $link_list = null;
	protected $link_form = null;
	protected $folder_upload = null;

    public function __construct()
    {
        $this->userMD = new \App\Models\UsuariosModel();

		$this->link_list = site_url('usuarios');
		$this->link_form = site_url('usuarios/form');

		$this->data['link_list'] = $this->link_list;
		$this->data['link_form'] = $this->link_form;

		helper('form');
		helper('text');
    }


	public function index()
	{
		// Acesso somente de Administradores
		// -------------------------------------------
		if( $this->session_user_acesso != "admin" ){
			return $this->response->redirect( site_url('mensagens/acesso_restrito') );	
		}
		// -------------------------------------------

		$query_user = $this->userMD
			->where('user_arquivado', '0')
			->orderBy('user_nome', 'ASC')
			->get();
		if( $query_user && $query_user->resultID->num_rows >= 1 )
		{
			$this->data['rs_user'] = $query_user;
		}

		return view('usuarios', $this->data);
	}


	public function form( $user_id = "" )
	{
		// Acesso somente de Administradores
		// -------------------------------------------
		if( $this->session_user_acesso != "admin" ){
			return $this->response->redirect( site_url('mensagens/acesso_restrito') );	
		}
		// -------------------------------------------

		$user_id = (int)$user_id;

		$fields_post = [];
		$error_infos = [];
		if ($this->request->getPost())
		{
			$user_nome = $this->request->getPost('user_nome');
			$user_email = $this->request->getPost('user_email');
			$user_senha = $this->request->getPost('user_senha');
			$user_avatar = $this->request->getPost('user_avatar');

			$fileAVATAR = $this->request->getFile('user_avatar_file');

			$newFileUpload = $user_avatar;
			if( $fileAVATAR ){
				if ($fileAVATAR->isValid() && ! $fileAVATAR->hasMoved()){
					$originalName = $fileAVATAR->getClientName();

					$arq_original = $originalName; 
					$extension = $fileAVATAR->getClientExtension();
					$extension = empty($extension) ? '' : '.' . $extension;
					$originalName = str_replace($extension, "", $originalName);
					
					$originalName = url_title( convert_accented_characters($originalName), '-', TRUE );
					$newFileUpload = $originalName .'__avatar__'. time() .'_'. random_string('alnum', 4) . $extension;
					
					//$newFileUpload = $originalName .'___'. $fileAVATAR->getRandomName();
					$fileAVATAR->move( $this->folder_upload .'avatar/', $newFileUpload);
				}
			}

			$data_db = [
				'user_hashkey' => md5(date("Y-m-d H:i:s") ."-". random_string('alnum', 16)),
				'user_urlpage' => url_title( convert_accented_characters($user_nome), '-', TRUE ),
				'user_nome' => ($user_nome),
				'user_email' => ($user_email),
				'user_senha' => fct_password_hash($user_senha),
				'user_avatar' => $newFileUpload,
				'user_dte_cadastro' => date("Y-m-d H:i:s"),
				'user_dte_alteracao' => date("Y-m-d H:i:s"),
				'user_ativo' => 1,
			];
			$query = $this->userMD
				->where('user_id', $user_id)
				->limit(1)
				->get();	
			if( $query && $query->resultID->num_rows >= 1 ){
				if( empty($user_senha) ){
					unset($data_db['user_senha']);
					unset($data_db['user_hashkey']);
					unset($data_db['user_dte_alteracao']);
				}
				$this->userMD->set($data_db);
				$this->userMD->where('user_id', $user_id);
				$this->userMD->update();
			}else{
				$this->userMD->set($data_db);
				$user_id = $this->userMD->insert();
			}

			return $this->response->redirect( $this->link_list );
			exit();
		}

		$query = $this->userMD
			->where('user_id', $user_id)
			->limit(1)
			->get();	
		if( $query && $query->resultID->num_rows >= 1 ){
			$rs_edit = $query->getRow();
			$this->data['rs_edit'] = $rs_edit;
		}

		return view('usuarios-form', $this->data);
	}


	public function ajaxform( $action = "")
	{
		$error_num = "1";
		$error_msg = "Erro inesperado";
		$redirect = '';

		switch ($action) {
		case "ARQUIVAR-USUARIO" :

			$user_hashkey = $this->request->getPost('hashkey');

			$query = $this->userMD
				->where('user_hashkey', $user_hashkey)
				->limit(1)
				->get();	
			if( $query && $query->resultID->num_rows >= 1 ){
				//$rs_edit = $query->getRow();
				//$this->data['rs_edit'] = $rs_edit;

				$this->userMD->set('user_arquivado', 1);
				$this->userMD->where('user_hashkey', $user_hashkey);
				$this->userMD->update();

				$error_num = "0";
				$error_msg = "Ação executada com sucesso!";
				$redirect = "";
			}else{
				$error_num = "1";
				$error_msg = "Registro inexistente!";
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
