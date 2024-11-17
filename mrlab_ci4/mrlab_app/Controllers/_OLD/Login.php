<?php
namespace App\Controllers;
use App\Controllers\BaseController;

class Login extends BaseController
{
	protected $userMD = null;
	protected $colabMD = null;

    public function __construct()
    {
        $this->userMD = new \App\Models\UsuariosModel();
		$this->colabMD = new \App\Models\ColaboradoresModel();

		helper('form');
		helper('text');
    }


	public function index()
	{
		if ($this->request->getPost())
		{
			self::loginAuth();
		}

		return view('login', $this->data);
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
		$email = $this->request->getPost('EMAIL');
		$senha = $this->request->getPost('SENHA');

		// ba87bbe0a5488eb2874816003d8b2d348e994e3396a5288f574127510c96655f55b205f036b947c91164375aabc113619fe762f46b9680a1a02e19fca7348b22
		
		// 112233
		// 6dee7f60332b50b309acecb04812b7d29045cb589250fa71f65edc04256d35fc1968d918f8381024cc308ed45d53aefa74235ebdac5a78b1d4d6b207d161de3f

		// adm-developer
		// 37f40751f08f733bcb4f612b7a033be41ea2c86a0db617388b582db1843ba345e50770cadcc0599de3e4367e848a10f7488ed679e756e853e9df9f12cddce0d2


		$query_user = $this->userMD->select('*')
			->groupStart()
				->orGroupStart()
					->where('user_email', $email)
					//->orWhere('user_login', $email)
				->groupEnd()
			->groupEnd()
			->where('user_senha', fct_password_hash($senha))
			->get();

		if( $query_user && $query_user->resultID->num_rows >=1 )
		{
			$rs_user = $query_user->getRow();

			$ses_data = [
				'hash_id' => md5(date("Y-m-d H:i:s") ."-". random_string('alnum', 16)),
				'user_id' => $rs_user->user_id,
				'user_nome' => $rs_user->user_nome,
				'user_email' => $rs_user->user_email,
				'user_avatar' => $rs_user->user_avatar,
				'user_acesso' => 'admin',
				'isLoggedIn' => TRUE
			];
			$session->set($ses_data);

			return $this->response->redirect( site_url('dashboard/?') );

		}else{
		
			// ------------------------------------------------------
			$query_colab = $this->colabMD->select('*')
				->groupStart()
					->orGroupStart()
						->where('colab_email', $email)
						//->orWhere('user_login', $email)
					->groupEnd()
				->groupEnd()
				->where('colab_senha', fct_password_hash($senha))
				->get();

			if( $query_colab && $query_colab->resultID->num_rows >=1 )
			{
				$rs_colab = $query_colab->getRow();

				$ses_data = [
					'hash_id' => md5(date("Y-m-d H:i:s") ."-". random_string('alnum', 16)),
					'user_id' => $rs_colab->colab_id,
					'user_nome' => $rs_colab->colab_nome_completo,
					'user_email' => $rs_colab->colab_email,
					'user_acesso' => 'colab',
					'user_avatar' => $rs_colab->colab_avatar,
					'isLoggedIn' => TRUE
				];
				$session->set($ses_data);

				return $this->response->redirect( site_url('dashboard/?') );

			}else{
			
				return $this->response->redirect( site_url('login') );
			
			}
			// ------------------------------------------------------		
		}
    }

}
