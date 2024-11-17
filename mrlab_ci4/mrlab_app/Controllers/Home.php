<?php

namespace App\Controllers;

class Home extends PainelController
{
    public function index()
    {
		return $this->response->redirect( site_url('login') );
        //return view('welcome_message');
    }
}
