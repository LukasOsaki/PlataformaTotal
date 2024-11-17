<?php
namespace App\Controllers;
use App\Controllers\PainelController;

class Dashboard extends PainelController
{
	
	protected $userMD = null;
	protected $prodMD = null;
	protected $vendMD = null;

    public function __construct()
    {
		$this->data['menu_active'] = 'dashboard';
    }

	public function index()
	{
		return view($this->directory .'/dashboard', $this->data);
	}

}
