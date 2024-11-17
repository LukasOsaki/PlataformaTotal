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
abstract class PainelController extends Controller
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
    protected $helpers = ['funcoes'];

	protected $data = [];

	protected $folder_upload = null;

	protected $sessionAdmin_id = null;
	protected $sessionAdmin_user_id = null;
	protected $sessionAdmin_user_nome = null;
	protected $sessionAdmin_user_email = null;

	protected $directory = '';

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



		$this->sessionAdmin_id = session()->get('hash_id');
		$this->sessionAdmin_user_id = (int)session()->get('admin_id');
		$this->sessionAdmin_user_nome = session()->get('admin_nome');
		$this->sessionAdmin_user_email = session()->get('admin_email');
		//$this->session_user_permissao = (int)session()->get('user_permissao');
		//$this->session_user_label_permissao = (isset($this->nivel_acesso[$this->session_user_permissao]) ? $this->nivel_acesso[$this->session_user_permissao] : '');

		$this->data['sessionAdmin_id'] = $this->sessionAdmin_id;
		$this->data['sessionAdmin_user_id'] = $this->sessionAdmin_user_id;
		$this->data['sessionAdmin_user_nome'] = $this->sessionAdmin_user_nome;
		$this->data['sessionAdmin_user_email'] = $this->sessionAdmin_user_email;
		//$this->data['session_user_permissao'] = $this->session_user_permissao;
		//$this->data['session_user_label_permissao'] = $this->session_user_label_permissao;


		$validation =  \Config\Services::validation();
		$this->data['validation'] = null;
    }
}
