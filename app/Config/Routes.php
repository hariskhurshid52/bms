<?php

use App\Controllers\Users;
use App\Controllers\Home;
use App\Controllers\Billboards;
use App\Controllers\Orders;
use App\Controllers\Expense;
use App\Controllers\ReportController;

use CodeIgniter\Router\RouteCollection;

;

/**
 * @var RouteCollection $routes
 */


$routes->group( '/',['filter' => ['auth', 'auth']], function ($routes) {


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

    $routes->get('board/create', [Billboards::class, 'create'], ['as' => 'admin.billboard.create']);
    $routes->post('board/save', [Billboards::class, 'save'], ['as' => 'admin.billboard.store']);
    $routes->get('boards/list-all', [Billboards::class, 'listAll'], ['as' => 'admin.billboard.list']);
    $routes->post('boards/listing', [Billboards::class, 'dtBillboardList'], ['as' => 'admin.billboard.dtList']);
    $routes->get('board/edit/(:num)', [Billboards::class, 'editBillboard'], ['as' => 'admin.billboard.edit']);
    $routes->get('board/view/(:num)', [Billboards::class, 'detailBillboard'], ['as' => 'admin.billboard.detail']);
    $routes->post('board/update', [Billboards::class, 'updateBillboardInfo'], ['as' => 'admin.billboard.update']);
    $routes->post('board/get-data', [Billboards::class, 'getHoardingDataAjax'], ['as' => 'admin.billboard.get.ajax']);
    $routes->post('board/upload-image', [Billboards::class, 'uploadImage'], ['as' => 'admin.billboard.uploadImage']);
    $routes->post('board/delete-image', [Billboards::class, 'deleteImage'], ['as' => 'admin.billboard.deleteImage']);

    $routes->get('order/create', [Orders::class, 'create'], ['as' => 'admin.order.create']);
    $routes->post('order/save', [Orders::class, 'save'], ['as' => 'admin.order.store']);
    $routes->post('order/update', [Orders::class, 'update'], ['as' => 'admin.order.update']);
    $routes->get('order/list', [Orders::class, 'listAll'], ['as' => 'admin.orders.list']);
    $routes->post('order/listing', [Orders::class, 'dtList'], ['as' => 'admin.orders.dtList']);
    $routes->get('order/edit/(:num)', [Orders::class, 'edit'], ['as' => 'admin.order.edit']);
    $routes->get('order/view/(:num)',  [Orders::class, 'view'], ['as' => 'admin.order.view']);
    $routes->post('orders/add-payment',[Orders::class, 'addPayment'], ['as' => 'admin.orders.addPayment']);
    $routes->get('admin/orders/getPayments/(:num)', 'Orders::getPayments/$1');
    $routes->post('admin/orders/addBookingPayment', 'Orders::addBookingPayment');

    $routes->get('expense/create', [Expense::class, 'create'], ['as' => 'admin.expense.create']);
    $routes->post('expense/save', [Expense::class, 'save'], ['as' => 'admin.expense.store']);
    $routes->post('expense/update', [Expense::class, 'update'], ['as' => 'admin.expense.update']);
    $routes->get('expense/list', [Expense::class, 'listAll'], ['as' => 'admin.expense.list']);
    $routes->post('expense/listing', [Expense::class, 'dtList'], ['as' => 'admin.expense.dtList']);
    $routes->get('expense/edit/(:num)', [Expense::class, 'edit'], ['as' => 'admin.expense.edit']);

});


$routes->get('/login', 'Login::index');
$routes->get('/logout', 'Login::logout');
$routes->post('/verify', 'Login::verify', ["as" => "login.verify"]);


$routes->get('/', [Home::class, 'index'], ['filter' => 'auth', 'as' => 'dashboard']);
$routes->get('marketing-dashboard', 'Home::marketingDashboard', ['as' => 'marketing-dashboard']);

$routes->get('report/hoarding-wise-revenue', 'ReportController::hoardingWiseRevenue', ['as' => 'admin.report.hoardingWiseRevenue']);
$routes->get('report/hoarding-wise-expense', 'ReportController::hoardingWiseExpense', ['as' => 'admin.report.hoardingWiseExpense']);
$routes->get('report/client-wise', 'ReportController::clientWiseReport', ['as' => 'admin.report.clientWise']);

