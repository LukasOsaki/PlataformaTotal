<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Dashboard');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
//$routes->get('/', 'Home::index');

$routes->get('/', 'Dashboard::index', ["filter" => "loginAdmin"]);




//$routes->group('login', ['namespace' => 'App\Controllers'], function ($routes) {
//	$routes->get('/', 'Login::index');
//});
//$routes->group('logout', ['namespace' => 'App\Controllers'], function ($routes) {
//	$routes->get('/', 'Login::logout');
//});

//$routes->group('dashboard', ['namespace' => 'App\Controllers'/*, "filter" => "loginAdmin"*/], function ($routes) {
//	$routes->get('/', 'Dashboard::index', ["filter" => "loginAdmin"]);
//});

//$routes->group('produtos', ['namespace' => 'App\Controllers'], function ($routes) {
//	$routes->get('/', 'Produtos::index');
//	$routes->match(['get', 'post'], 'categ/(.+)', 'Produtos::categ/$1');
//	//$routes->match(['get', 'post'], 'form/(:num)', 'Usuarios::form/$1', ["filter" => "loginAdmin"]);
//	//$routes->match(['get', 'post'], 'arquivados', 'Usuarios::arquivados', ["filter" => "loginAdmin"]);
//	//$routes->match(['post', 'add'], 'ajaxform/(.+)', 'Usuarios::ajaxform/$1', ["filter" => "loginAdmin"]);
//});

//$routes->group('produto', ['namespace' => 'App\Controllers'], function ($routes) {
//	$routes->get('(:num)/(.+)', 'Produtos::detalhe/$1/$2');
//});

//$routes->group('perfil', ['namespace' => 'App\Controllers'], function ($routes) {
//	$routes->get('/', 'Perfil::index');
//	$routes->match(['get', 'post'], 'criar-conta', 'Perfil::criar_conta');
//	$routes->match(['get', 'post'], 'login', 'Perfil::login');
//	$routes->match(['get', 'post'], 'logout', 'Perfil::logout');
//});

//$routes->group('carrinho', ['namespace' => 'App\Controllers'], function ($routes) {
//	$routes->match(['get', 'post'], '/', 'Carrinhos::index');
//	$routes->match(['get', 'post'], 'add/(:num)/(.+)', 'Carrinhos::add/$1/$2');
//	$routes->match(['get', 'post'], 'delete/(.+)', 'Carrinhos::delete/$1');
//	$routes->match(['get', 'post'], 'checkout', 'Carrinhos::checkout');
//	$routes->match(['get', 'post'], 'finalizado', 'Carrinhos::finalizado');
//});





	

	$routes->group('login', ['namespace' => 'App\Controllers'], function ($routes) {
		$routes->get('/', 'Login::index');
	});

	$routes->group('logout', ['namespace' => 'App\Controllers'], function ($routes) {
		$routes->get('/', 'Login::logout');
	});

	$routes->group('dashboard', ['namespace' => 'App\Controllers', "filter" => "loginAdmin"], function ($routes) {
		$routes->get('/', 'Dashboard::index', ["filter" => "loginAdmin"]);
	});



	$routes->group('servicos', ['namespace' => 'App\Controllers', "filter" => "loginAdmin"], function ($routes) {
		$routes->get('/', 'Servicos::index', ["filter" => "loginAdmin"]);
		$routes->match(['get', 'post'], '/', 'Servicos::index', ["filter" => "loginAdmin"]);
		$routes->match(['get', 'post'], 'form', 'Servicos::form', ["filter" => "loginAdmin"]);
		$routes->match(['get', 'post'], 'form/(:num)', 'Servicos::form/$1', ["filter" => "loginAdmin"]);
		$routes->match(['post', 'add'], 'ajaxform/(.+)', 'Servicos::ajaxform/$1', ["filter" => "loginAdmin"]);
		$routes->match(['get', 'post'], 'exportar', 'Servicos::exportar', ["filter" => "loginAdmin"]);
		$routes->match(['get', 'post'], 'impressao/(:num)', 'Servicos::impressao/$1', ["filter" => "loginAdmin"]);
	});

	$routes->group('api', ['namespace' => 'App\Controllers'], function ($routes) {
		$routes->get('servicos', 'Servicos::filtrarApi');
		$routes->get('clientes', 'Clientes::filtrarApi');
	});
	// $routes->get('api/financeiro/filtrar', 'Financeiro::filtrarApi');
















	$routes->group('categorias', ['namespace' => 'App\Controllers', "filter" => "loginAdmin"], function ($routes) {
		$routes->get('/', 'Categorias::index', ["filter" => "loginAdmin"]);
		$routes->match(['get', 'post'], 'form', 'Categorias::form', ["filter" => "loginAdmin"]);
		$routes->match(['get', 'post'], 'form/(:num)', 'Categorias::form/$1', ["filter" => "loginAdmin"]);
		$routes->match(['post', 'add'], 'ajaxform/(.+)', 'Categorias::ajaxform/$1', ["filter" => "loginAdmin"]);
	});

	$routes->group('produtos', ['namespace' => 'App\Controllers', "filter" => "loginAdmin"], function ($routes) {
		$routes->get('/', 'Produtos::index', ["filter" => "loginAdmin"]);
		$routes->match(['get', 'post'], 'form', 'Produtos::form', ["filter" => "loginAdmin"]);
		$routes->match(['get', 'post'], 'form/(:num)', 'Produtos::form/$1', ["filter" => "loginAdmin"]);
		$routes->match(['post', 'add'], 'ajaxform/(.+)', 'Produtos::ajaxform/$1', ["filter" => "loginAdmin"]);
	});

	$routes->group('usuarios', ['namespace' => 'App\Controllers'], function ($routes) {
		$routes->get('/', 'Usuarios::index');
		$routes->match(['get', 'post'], 'form', 'Usuarios::form', ["filter" => "loginAdmin"]);
		$routes->match(['get', 'post'], 'form/(:num)', 'Usuarios::form/$1', ["filter" => "loginAdmin"]);
		$routes->match(['post', 'add'], 'ajaxform/(.+)', 'Usuarios::ajaxform/$1', ["filter" => "loginAdmin"]);
		$routes->match(['get'], 'historico/(:num)', 'Usuarios::historico/$1', ["filter" => "loginAdmin"]);
	});

	$routes->group('clientes', ['namespace' => 'App\Controllers', "filter" => "loginAdmin"], function ($routes) {
		$routes->get('/', 'Clientes::index', ["filter" => "loginAdmin"]);
		$routes->match(['get', 'post'], 'form', 'Clientes::form', ["filter" => "loginAdmin"]);
		$routes->match(['get', 'post'], 'form/(:num)', 'Clientes::form/$1', ["filter" => "loginAdmin"]);

		$routes->match(['get', 'post'], 'visualizar', 'Clientes::visualizar', ["filter" => "loginAdmin"]);
		$routes->match(['get', 'post'], 'visualizar/(:num)', 'Clientes::visualizar/$1', ["filter" => "loginAdmin"]);

		$routes->match(['post', 'add'], 'ajaxform/(.+)', 'Clientes::ajaxform/$1', ["filter" => "loginAdmin"]);
	});

	$routes->group('carrinho', ['namespace' => 'App\Controllers', "filter" => "loginAdmin"], function ($routes) {
		$routes->get('/', 'Carrinho::index', ["filter" => "loginAdmin"]);
		$routes->match(['get', 'post'], 'form', 'Carrinho::form', ["filter" => "loginAdmin"]);
		$routes->match(['get', 'post'], 'form/(:num)', 'Carrinho::form/$1', ["filter" => "loginAdmin"]);
		$routes->match(['post', 'add'], 'ajaxform/(.+)', 'Carrinho::ajaxform/$1', ["filter" => "loginAdmin"]);
		$routes->post('ajaxform/(.+)', 'Carrinho::ajaxform/$1', ["filter" => "loginAdmin"]);
		$routes->add('ajaxform/(.+)', 'Carrinho::ajaxform/$1', ["filter" => "loginAdmin"]);
	});

	$routes->group('pedidos', ['namespace' => 'App\Controllers', "filter" => "loginAdmin"], function ($routes) {
		$routes->get('/', 'Pedidos::index', ["filter" => "loginAdmin"]);
		$routes->get('detalhes/(:num)', 'Pedidos::detalhes/$1', ["filter" => "loginAdmin"]);
		$routes->match(['get', 'post'], 'form', 'Pedidos::form', ["filter" => "loginAdmin"]);
		$routes->match(['get', 'post'], 'form/(:num)', 'Pedidos::form/$1', ["filter" => "loginAdmin"]);
		$routes->match(['post', 'add'], 'ajaxform/(.+)', 'Pedidos::ajaxform/$1', ["filter" => "loginAdmin"]);
	});







/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
