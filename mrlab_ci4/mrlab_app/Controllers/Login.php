<?php
namespace App\Controllers;
use App\Controllers\PainelController;

class Login extends PainelController
{

	protected $userMD = null;
	protected $clieMD = null;

    public function __construct()
    {
        $this->userMD = new \App\Models\UsuariosModel();
		$this->clieMD = new \App\Models\ClientesModel();

		helper('form');
		helper('text');
    }

	public function index()
	{
		if ($this->request->getPost())
		{
			self::loginAuth();
		}

		return view($this->directory .'/login', $this->data);
	}

	public function logout()
	{
		$session = session();
		$session->destroy();

		return $this->response->redirect( site_url('login') );
	}

    public function loginAuth()
    {
        $session = session();
		$user_email = $this->request->getPost('user_email');
		$user_senha = $this->request->getPost('user_senha');

		// ba87bbe0a5488eb2874816003d8b2d348e994e3396a5288f574127510c96655f55b205f036b947c91164375aabc113619fe762f46b9680a1a02e19fca7348b22
		
		// 112233
		// 6dee7f60332b50b309acecb04812b7d29045cb589250fa71f65edc04256d35fc1968d918f8381024cc308ed45d53aefa74235ebdac5a78b1d4d6b207d161de3f

		// adm-developer
		// 37f40751f08f733bcb4f612b7a033be41ea2c86a0db617388b582db1843ba345e50770cadcc0599de3e4367e848a10f7488ed679e756e853e9df9f12cddce0d2


		$query_user = $this->userMD->select('*')
			->groupStart()
				->orGroupStart()
					->where('user_email', $user_email)
					//->orWhere('user_login', $email)
				->groupEnd()
			->groupEnd()
			->where('user_senha', fct_password_hash($user_senha))
			->where('user_ativo', '1')
			//->getCompiledSelect();
			->get();


		/*
			SELECT USR.*, PERM.perm_titulo 
			FROM tbl_usuarios USR
				INNER JOIN tbl_permissoes PERM ON PERM.perm_id = USR.perm_id;
		*/

		if( $query_user && $query_user->resultID->num_rows >=1 )
		{
			$rs_user = $query_user->getRow();

			$ses_data = [
				'admin_hash_id' => md5(date("Y-m-d H:i:s") ."-". random_string('alnum', 16)),
				'admin_id' => $rs_user->user_id,
				'admin_nome' => $rs_user->user_nome,
				'admin_email' => $rs_user->user_email,
				'admin_cnpj' => '',
				'admin_nivel' => 'administrador',
				'isLoggedInAdmin' => TRUE
			];
			$session->set($ses_data);

			// colocar aqui login por cookie também
			return $this->response->redirect( site_url('dashboard/') );

		}else{


			// Elimina possivel mascara
			$user_email = preg_replace("/[^0-9]/", "", $user_email);
			$user_email = str_pad($user_email, 14, '0', STR_PAD_LEFT); // CNPJ
			$user_email = fct_mask($user_email, '##.###.###/####-##');

			//print $user_email;
			//print '<BR> '.  fct_password_hash($user_senha);
			//exit();

			$query_cliente = $this->clieMD->select('*')
				->groupStart()
					->orGroupStart()
						->where('clie_cnpj', $user_email)
						//->orWhere('user_login', $email)
					->groupEnd()
				->groupEnd()
				->where('clie_senha', fct_password_hash($user_senha))
				->where('clie_ativo', '1')
				//->getCompiledSelect();
				->get();
			if( $query_cliente && $query_cliente->resultID->num_rows >=1 )
			{
				$rs_cliente = $query_cliente->getRow();

				$ses_data = [
					'admin_hash_id' => md5(date("Y-m-d H:i:s") ."-". random_string('alnum', 16)),
					'admin_id' => $rs_cliente->clie_id,
					'admin_nome' => $rs_cliente->clie_nome_razao,
					'admin_email' => $rs_cliente->clie_email,
					'admin_cnpj' => $rs_cliente->clie_cnpj,
					'admin_nivel' => 'cliente',
					'isLoggedInAdmin' => TRUE
				];
				$session->set($ses_data);

				return $this->response->redirect( site_url('servicos/') );

			}else{
		
				return $this->response->redirect( site_url('login/?error') );

			}
		
		}
    }

}
