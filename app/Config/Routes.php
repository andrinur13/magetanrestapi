<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

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
$routes->setDefaultController('Home');
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
$routes->get('/', 'Home::index');


// data siswa
$routes->get('/siswaid', 'Data_Siswa_Controller::siswaid');
$routes->get('/siswa', 'Data_Siswa_Controller::index');
$routes->post('/siswa', 'Data_Siswa_Controller::create');
$routes->put('/siswa', 'Data_Siswa_Controller::editsiswa');
$routes->delete('/siswa', 'Data_Siswa_Controller::deleteSiswa');


// prestasi
$routes->get('/prestasi', 'Prestasi_Controller::index');
$routes->get('/prestasiid', 'Prestasi_Controller::prestasiid');
$routes->post('/prestasi', 'Prestasi_Controller::create');
$routes->put('/prestasi', 'Prestasi_Controller::editPrestasi');
$routes->delete('/prestasi', 'Prestasi_Controller::deletePrestasi');


// pelanggaran
$routes->get('/pelanggaran', 'Pelanggaran_Controller::index');
$routes->get('/pelanggaranid', 'Pelanggaran_Controller::pelanggaranid');
$routes->post('/pelanggaran', 'Pelanggaran_Controller::createPelanggaran');
$routes->put('/pelanggaran', 'Pelanggaran_Controller::editPelanggaran');
$routes->delete('/pelanggaran', 'Pelanggaran_Controller::deletePelanggaran');


// ijazah
$routes->get('/ijazah', 'Ijazah_Controller::index');
$routes->get('/ijazahid', 'Ijazah_Controller::ijazahid');
$routes->post('/ijazah', 'Ijazah_Controller::createIjazah');
$routes->put('/ijazah', 'Ijazah_Controller::editIjazah');
$routes->delete('/ijazah', 'Ijazah_Controller::deleteIjazah');


// user
$routes->get('/user', 'User_Controller::index');
$routes->get('/userid', 'User_Controller::userid');
$routes->post('/username', 'User_Controller::username');
$routes->post('/user', 'User_Controller::createUser');
$routes->put('/user', 'User_Controller::editUser');
$routes->delete('/user', 'User_Controller::deleteUser');
$routes->post('/login', 'User_Controller::login');

$routes->get('/testing', 'Testing_Controller::index');

/**
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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
