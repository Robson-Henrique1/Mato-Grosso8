<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes(true);

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Login_Controller');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);


/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
/** @var RouteCollectionInterface $routes */
$routes->group('', ['filters' => 'auth'], function ($routes) {
	$routes->get('login/sucesso', 'Grid_Controller::index');
	$routes->get('login/logout', 'Login_Controller::logout');
	$routes->post('grid/atualizar_status', 'Grid_Controller::atualizarStatus');
	$routes->get('grid/download_pasta/(:segment)', 'Grid_Controller::download_pasta/$1');
	$routes->get('grid/download_todas_pastas', 'Grid_Controller::download_todas_pastas');

});
//$routes->get('login/delete/(:num)', 'Grid_Controller::delete/$1');
$routes->post('login/verificar', 'Login_Controller::verificarCredenciais');
$routes->get('/', 'Login_Controller::index');
$routes->get('form', 'Form_Controller::index');
$routes->post('baixardocumento', 'Form_Controller::baixardocumento',['as' => 'baixardocumento']);
$routes->post('verificar', 'Form_Controller::verificar',['as' => 'verificar']);
$routes->post('salvardocumento', 'Form_Controller::salvardocumento',['as' => 'salvardocumento']);
$routes->post('salvarimagem', 'Form_Controller::salvarimagem',['as' => 'salvarimagem']);


/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need to it be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
