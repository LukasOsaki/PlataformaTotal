<?php
namespace App\Controllers;
use App\Controllers\PainelController;

class Usuarios extends PainelController
{
	protected $userMD = null;
	protected $permMD = null;

    public function __construct()
    {
        $this->userMD = new \App\Models\UsuariosModel();
		$this->permMD = new \App\Models\PermissoesModel();

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

		$uri = service('uri'); // Obter a inst�ncia do objeto URI
		$segments = $uri->getSegments();
		$index = array_search('filtrar', $segments); // Encontrar o �ndice do segmento "filtrar"

		$filteredSegments = array_slice($segments, $index + 1); // Retornar os elementos a partir de $index + 1 at� o final

		$this->userMD
		->from('tbl_usuarios as USER', true)
		->select('USER.*')
		->select('PERM.perm_titulo')
		->join('tbl_permissoes PERM', 'PERM.perm_id = USER.perm_id', 'left')
		->orderBy('USER.user_id', 'DESC')
			->limit(1000);
		$query = $this->userMD->get();

		$this->data['lastQuery'] = $this->userMD->getLastQuery();
			//->getCompiledSelect();

		if( $query && $query->resultID->num_rows >=1 )
		{
			$this->data['rs_list'] = $query;
		}

		return view($this->directory .'/usuarios', $this->data);
	}


	public function form( $user_id = 0 )
	{
		if ($this->request->getPost())
		{
			$validation =  \Config\Services::validation();
			$rules = [
				"user_nome" => [
					"label" => "user_nome", 
					"rules" => "required",
					'errors' => [
						'required' => 'Preencha corretamente',
					],
				],
			];

			if ($this->validate($rules)) {
				$perm_id = (int)$this->request->getPost('perm_id');
				$user_nome = $this->request->getPost('user_nome');
				$user_email = $this->request->getPost('user_email');
				$user_senha = $this->request->getPost('user_senha');
				$user_ativo = (int)$this->request->getPost('user_ativo');

				$data_db = [
					'perm_id' => $perm_id,
					'user_hashkey' =>md5(date("Y-m-d H:i:s") ."-". random_string('alnum', 16)),
					'user_urlpage' => url_title( convert_accented_characters($user_nome), '-', TRUE ),
					'user_nome' => $user_nome,
					'user_email' => $user_email,
					'user_senha' => fct_password_hash($user_senha),
					'user_dte_cadastro' => date("Y-m-d H:i:s"),
					'user_dte_alteracao' => date("Y-m-d H:i:s"),
					'user_ativo' => (int)$user_ativo,
				];

				$queryEdit = $this->userMD->where('user_id', $user_id)->get();
				if( $queryEdit && $queryEdit->resultID->num_rows >=1 )
				{
					if( empty($user_senha) ){ unset( $data_db['user_senha'] ); }
					unset( $data_db['user_hashkey'] );
					unset( $data_db['user_dte_cadastro'] );
					$qryExecute = $this->userMD->update($user_id, $data_db);
				}else{
					if( empty($user_senha) ){
						unset( $data_db['user_senha'] );	
					}
					$user_id = $this->userMD->insert($data_db);
				}

				return $this->response->redirect( site_url('usuarios') );
				exit();

			} else {
				$this->data['validation'] = $validation->getErrors();
			}
		}


		$query = $this->userMD->where('user_id', $user_id)->get();
		if( $query && $query->resultID->num_rows >=1 )
		{
			$rs_dados = $query->getRow();
			$this->data['rs_dados'] = $rs_dados;
		}


		$this->permMD->orderBy('perm_titulo', 'ASC')
		->where('perm_ativo', 1)
			->limit(1000);
		$query_permissoes = $this->permMD->get();
		if( $query_permissoes && $query_permissoes->resultID->num_rows >=1 )
		{
			$this->data['rs_list_permissoes'] = $query_permissoes;
		}


		return view($this->directory .'/usuarios-form', $this->data);
	}

}
