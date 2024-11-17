<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['funcoes', 'cookie', 'text', 'form'];

	protected $data = [];

	protected $nivel_acesso = null;

	protected $folder_upload = null;

	protected $arr_tipo_evet = [];
	protected $arr_tipo_doc = [];

	protected $arr_produtos = [];

	protected $session_id = null;
	protected $session_user_id = null;
	protected $session_user_nome = null;
	protected $session_user_acesso = null;
	protected $session_user_avatar = null;
	protected $session_user_acesso_label = null;

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();

		date_default_timezone_set('America/Sao_Paulo');






		$this->folder_upload = 'files-upload/';
		$this->data['folder_upload'] = $this->folder_upload;



		// Vamos verificar os Cookies para tentar segurar o login
		$config = new \Config\AppSettings();
		$CFG_COOKIE_NAME = $config->CFG_COOKIE_NAME;
		$cookieName = $CFG_COOKIE_NAME;

		$value = get_cookie($cookieName);
		if( !empty($value) ){
			$arrSessionCoockie = json_decode($value); 
			$isLoggedInFrontEnd = $arrSessionCoockie->isLoggedIn;
			if( is_bool($isLoggedInFrontEnd) !== true ){
				//return redirect()->to( site_url('login') );	
			}else{
				$session = session();

				$ses_data = [
					'hash_id' => md5(date("Y-m-d H:i:s") ."-". random_string('alnum', 16)),
					'cad_id' => $arrSessionCoockie->cad_id,
					'cad_nome' => $arrSessionCoockie->cad_nome,
					'cad_email' => $arrSessionCoockie->cad_email,
					'isLoggedIn' => TRUE,
					'session_type' => 'cookie',
				];
				$session->set($ses_data);
			}
		}

		$this->session_id = session()->get('hash_id');
		$this->session_user_id = (int)session()->get('cad_id');
		$this->session_user_nome = session()->get('cad_nome');
		$this->session_user_email = session()->get('cad_email');

		$this->data['session_id'] = $this->session_id;
		$this->data['session_user_id'] = $this->session_user_id;
		$this->data['session_user_nome'] = $this->session_user_nome;
		$this->data['session_user_email'] = $this->session_user_email;





		/*
		 * -------------------------------------------------------------
		 * 
		 * -------------------------------------------------------------
		**/
			$this->data['rs_count_cart'] = 0;

			$cartMD = new \App\Models\CarrinhosModel();
			$query_count_cart = $cartMD->selectCount('cart_id')->where('cad_id', (int)session()->get('cad_id'))->get();
			if( $query_count_cart && $query_count_cart->resultID->num_rows >=1 )
			{
				$rs_count_cart = $query_count_cart->getRow();
				$this->data['rs_count_cart'] = (int)$rs_count_cart->cart_id;
			}


			$categMD = new \App\Models\CategoriasModel();
			$query_categ = $categMD->where('categ_ativo', 1)->get();
			if( $query_categ && $query_categ->resultID->num_rows >=1 )
			{
				$this->data['rs_categ'] = $query_categ;
			}



		$arr_produtos = [
			[
				'category' => 'Feminino',
				'title' => 'Moleton Numero 01',
				'price' => 128.50,
				'resume' => '',
				'photo' => 'assets/media/produtos/01.jpg'
			],
			[
				'category' => 'Masculino',
				'title' => 'Agasalho Numero 02',
				'price' => 162.90,
				'resume' => '',
				'photo' => 'assets/media/produtos/02.jpg'
			],
			[
				'category' => 'Masculino',
				'title' => 'Agasalho Numero 03',
				'price' => 162.90,
				'resume' => '',
				'photo' => 'assets/media/produtos/03.jpg'
			],
			[
				'category' => 'Masculino',
				'title' => 'Agasalho Numero 04',
				'price' => 162.90,
				'resume' => '',
				'photo' => 'assets/media/produtos/04.jpg'
			],
			[
				'category' => 'Masculino',
				'title' => 'Agasalho Numero 05',
				'price' => 162.90,
				'resume' => '',
				'photo' => 'assets/media/produtos/05.jpg'
			],
			[
				'category' => 'Masculino',
				'title' => 'Agasalho Numero 06',
				'price' => 162.90,
				'resume' => '',
				'photo' => 'assets/media/produtos/06.jpg'
			],
			[
				'category' => 'Masculino',
				'title' => 'Agasalho Numero 07',
				'price' => 162.90,
				'resume' => '',
				'photo' => 'assets/media/produtos/07.jpg'
			],
			[
				'category' => 'Masculino',
				'title' => 'Agasalho Numero 08',
				'price' => 162.90,
				'resume' => '',
				'photo' => 'assets/media/produtos/08.jpg'
			],
		];

		$this->arr_produtos = $arr_produtos;
		$this->data['arr_produtos'] = $this->arr_produtos;

    }
}
