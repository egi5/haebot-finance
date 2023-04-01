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
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
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

$routes->get('/', 'AuthController::login');

$routes->group('', ['filter' => 'isLoggedIn'], function ($routes) {

    $routes->get('/dashboard', 'Dashboard::index', ['filter' => 'permission:Dashboard']);
    $routes->get('akun', 'Menu::Akun');
    $routes->get('laporan', 'Menu::Laporan');
    $routes->get('kategori', 'KategoriAkun::index');
    $routes->get('listakun', 'Akun::index');
    $routes->get('jurnalumum', 'Jurnal::index');
    $routes->get('neraca', 'Neraca::index');
    $routes->get('labarugi', 'LabaRugi::index');

    // GetData
    $routes->get('/wilayah/kota_by_provinsi', 'GetWilayah::KotaByProvinsi');
    $routes->get('/wilayah/kecamatan_by_kota', 'GetWilayah::KecamatanByKota');
    $routes->get('/wilayah/kelurahan_by_kecamatan', 'GetWilayah::KelurahanByKecamatan');

    // Karyawan
    $routes->get('karyawan/redirect/(:any)', 'Karyawan::redirect/$1', ['filter' => 'permission:SDM']);
    $routes->resource('karyawan', ['filter' => 'permission:SDM']);


    // Divisi
    $routes->get('divisi/redirect/(:any)', 'Divisi::redirect/$1', ['filter' => 'permission:SDM']);
    $routes->resource('divisi', ['filter' => 'permission:SDM']);


    //Kategori Akun
    $routes->get('getdatakategori', 'KategoriAkun::getDataKategori');
    $routes->resource('kategoriakun');


    //Akun
    $routes->get('getdataakun', 'Akun::getDataAkun');
    $routes->get('akun/buku/(:num)', 'Akun::buku/$1');
    $routes->get('listBuku', 'Akun::getListBukuBesar');
    $routes->resource('akun');


    //Jurnal Umum
    $routes->get('getdatajurnal', 'Jurnal::getDataJurnal');
    $routes->resource('jurnal');
    $routes->get('/Jurnal/akun', 'Jurnal::akun');


    //Neraca
    $routes->get('listNeraca', 'Neraca::getListNeraca');


    
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
