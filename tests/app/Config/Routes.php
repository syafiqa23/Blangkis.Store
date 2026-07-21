<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index', ['filter' => 'auth']);

$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::login');
$routes->get('register', 'AuthController::register');
$routes->post('register', 'AuthController::register');
$routes->get('home', 'Home::index');
//$routes->get('profile', 'Home::profile');

$routes->get('logout', 'AuthController::logout');

$routes->group('produk', ['filter' => 'auth'], function ($routes) {
    $routes->get('', 'ProdukController::index');
    $routes->post('', 'ProdukController::create');
    $routes->post('edit/(:any)', 'ProdukController::edit/$1');
    $routes->get('delete/(:any)', 'ProdukController::delete/$1');
    $routes->get('download', 'ProdukController::download');
});

$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function ($routes) {
    $routes->get('produk', 'ProdukController::index');
    $routes->post('produk', 'ProdukController::create');
    $routes->post('produk/edit/(:num)', 'ProdukController::edit/$1');
    $routes->get('produk/delete/(:num)', 'ProdukController::delete/$1');
    $routes->get('produk/download', 'ProdukController::download');
});

$routes->group('keranjang', ['filter' => 'auth'], function ($routes) {
    $routes->get('', 'TransaksiController::index');
    $routes->post('', 'TransaksiController::cart_add');
    $routes->post('edit', 'TransaksiController::cart_edit');
    $routes->get('delete/(:any)', 'TransaksiController::cart_delete/$1');
    $routes->get('clear', 'TransaksiController::cart_clear');
});

$routes->get('checkout', 'TransaksiController::checkout', ['filter' => 'auth']);
$routes->post('buy', 'TransaksiController::buy', ['filter' => 'auth']);
$routes->post('konfirmasi-diterima/(:num)', 'ProfileController::konfirmasiDiterima/$1', ['filter' => 'auth']);

$routes->get('get-location', 'TransaksiController::getLocation', ['filter' => 'auth']);
$routes->get('get-cost', 'TransaksiController::getCost', ['filter' => 'auth']);

$routes->get('keranjang', 'TransaksiController::index', ['filter' => 'auth']);

//$routes->get('profile', 'Home::profile', ['filter' => 'auth']);

$routes->get('faq', 'Home::faq', ['filter' => 'auth']);
$routes->get('profile', 'ProfileController::index', ['filter' => 'auth']);
$routes->get('contact', 'ContactController::index', ['filter' => 'auth']);

$routes->resource('api', ['controller' => 'apiController']);

$routes->get('invoice', 'TransaksiController::invoiceRedirect');
$routes->get('invoice/(:num)', 'TransaksiController::invoice/$1');


$routes->group('admin', ['namespace' => 'App\Controllers\Admin', 'filter' => 'auth'], function ($routes) {
    $routes->get('kategori', 'KategoriController::index');
    $routes->post('kategori', 'KategoriController::create');
    $routes->post('kategori/edit/(:num)', 'KategoriController::edit/$1');
    $routes->get('kategori/delete/(:num)', 'KategoriController::delete/$1');
});



// Dashboard
$routes->get('admin', 'DashboardController::index', ['namespace' => 'App\Controllers\Admin', 'filter' => 'auth']);

// Konsumen
$routes->get('admin/konsumen', 'KonsumenController::index', ['namespace' => 'App\Controllers\Admin', 'filter' => 'auth']);

// Order
$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function ($routes) {
    $routes->get('order', 'OrderController::index');
    $routes->get('order/konfirmasi-bayar/(:num)', 'OrderController::konfirmasiBayar/$1');
    $routes->get('order/konfirmasi-kirim/(:num)', 'OrderController::konfirmasiKirim/$1');
});

$routes->group('admin', ['namespace' => 'App\Controllers\Admin', 'filter' => 'auth'], function ($routes) {
    // Laporan Global
    $routes->get('laporan/global', 'LaporanController::laporanGlobal');
    $routes->get('laporan/export-global/pdf', 'LaporanController::exportGlobalPdf');
    $routes->get('laporan/export-global/excel', 'LaporanController::exportGlobalExcel');
});

$routes->post('/search', 'SearchController::index');

$routes->post('search', 'Home::search');

$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function ($routes) {
    // Laporan Periodik
    $routes->get('laporan/periodik', 'LaporanPeriodikController::index');
    $routes->post('laporan/periodik', 'LaporanPeriodikController::filter');
    $routes->get('laporan/periodik/pdf', 'LaporanPeriodikController::export_pdf');
    $routes->get('laporan/periodik/excel', 'LaporanPeriodikController::export_excel');
});
// Laporan Pendapatan
$routes->group('admin', ['namespace' => 'App\Controllers\Admin', 'filter' => 'auth'], function ($routes) {
    $routes->get('laporan/pendapatan', 'LaporanPendapatanController::index');
    $routes->post('laporan/pendapatan/filter', 'LaporanPendapatanController::filter');
    $routes->get('laporan/pendapatan/pdf', 'LaporanPendapatanPdfController::pendapatanPdf');
    $routes->get('laporan/pendapatan/excel', 'LaporanPendapatanPdfController::pendapatanExcel');
});

$routes->get('auth/google', 'AuthController::googleLogin');
$routes->get('auth/google/callback', 'AuthController::googleCallback');


$routes->get('admin/laporan', 'LaporanController::laporanGlobal', ['namespace' => 'App\Controllers\Admin', 'filter' => 'auth']);

$routes->post('buy', 'CheckoutController::buy');
$routes->get('checkout/success', 'CheckoutController::success');
$routes->post('upload-bukti/(:num)', 'TransaksiController::uploadBuktiPembayaran/$1');
