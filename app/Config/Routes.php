<?php

use App\Controllers\Users;
use App\Controllers\Home;
use App\Controllers\Billboards;
use App\Controllers\Orders;

use CodeIgniter\Router\RouteCollection;

;

/**
 * @var RouteCollection $routes
 */


$routes->group('admin', ['filter' => ['auth', 'adminAuth']], function ($routes) {


});


$routes->get('/login', 'Login::index');
$routes->get('/logout', 'Login::logout');

$routes->post('/verify', 'Login::verify', ["as" => "login.verify"]);

$routes->get('/', [Home::class, 'index'], ['filter' => 'auth', 'as' => 'dashboard'], );
$routes->get('/', [Home::class, 'index'], ['filter' => 'auth', 'as' => 'home'], );

$routes->get('users/create', [Users::class, 'index'], ['as' => 'admin.users.create']);
$routes->get('users/list-all', [Users::class, 'listAll'], ['as' => 'admin.users.listAll']);
$routes->get('users/edit/(:num)', [Users::class, 'edit'], ['as' => 'admin.users.edit']);
$routes->post('user/save', [Users::class, 'saveUser'], ['as' => 'admin.users.save']);
$routes->post('user/listing', [Users::class, 'usersDataTableList'], ['as' => 'admin.users.dtList']);
$routes->post('user/update', [Users::class, 'update'], ['as' => 'admin.users.update']);


$routes->get('customer/create', [Users::class, 'createCustoemr'], ['as' => 'admin.customer.create']);
$routes->post('customer/save', [Users::class, 'saveCustomerInfo'], ['as' => 'admin.customer.store']);
$routes->get('customers/list-all', [Users::class, 'customersList'], ['as' => 'admin.customers.list']);
$routes->post('customers/listing', [Users::class, 'dtCustomersList'], ['as' => 'admin.customers.dtList']);
$routes->get('customer/edit/(:num)', [Users::class, 'editCustomer'], ['as' => 'admin.customers.edit']);
$routes->post('customer/update', [Users::class, 'updateCustomerInfo'], ['as' => 'admin.customer.update']);

$routes->get('hording/create', [Billboards::class, 'create'], ['as' => 'admin.billboard.create']);
$routes->post('hording/save', [Billboards::class, 'save'], ['as' => 'admin.billboard.store']);
$routes->get('hording/list-all', [Billboards::class, 'listAll'], ['as' => 'admin.billboard.list']);
$routes->post('hording/listing', [Billboards::class, 'dtBillboardList'], ['as' => 'admin.billboard.dtList']);
$routes->get('hording/edit/(:num)', [Billboards::class, 'editBillboard'], ['as' => 'admin.billboard.edit']);
$routes->post('hording/update', [Billboards::class, 'updateBillboardInfo'], ['as' => 'admin.billboard.update']);
$routes->post('hording/get-data', [Billboards::class, 'getHordingDataAjax'], ['as' => 'admin.billboard.get.ajax']);



$routes->get('order/create', [Orders::class, 'create'], ['as' => 'admin.order.create']);
$routes->post('order/save', [Orders::class, 'save'], ['as' => 'admin.order.store']);
$routes->post('order/update', [Orders::class, 'update'], ['as' => 'admin.order.update']);
$routes->get('order/list', [Orders::class, 'listAll'], ['as' => 'admin.orders.list']);
$routes->post('order/listing', [Orders::class, 'dtList'], ['as' => 'admin.orders.dtList']);
$routes->get('order/edit/(:num)', [Orders::class, 'edit'], ['as' => 'admin.order.edit']);

$routes->get('admin/dashboard', 'Dashboard::index');


