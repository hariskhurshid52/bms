<?php

namespace App\Controllers;

use App\Models\OrderModel;
use App\Models\BillboardModel;
use App\Models\PaymentModel;
use App\Models\CityModel;
use App\Models\BillboardTypeModel;
use App\Models\CustomerModel;
use App\Models\ExpenseModel;
use CodeIgniter\Controller;

class ReportController extends Controller
{
    public function hoardingWiseRevenue()
    {
        $billboardModel = new BillboardModel();
        $orderModel = new OrderModel();
        $paymentModel = new PaymentModel();
        $cityModel = new CityModel();
        $typeModel = new BillboardTypeModel();
        $customerModel = new CustomerModel();

        // Get filter values
        $city = $this->request->getGet('city');
        $area = $this->request->getGet('area');
        $type = $this->request->getGet('type');
        $status = $this->request->getGet('status');
        $date_from = $this->request->getGet('date_from');
        $date_to = $this->request->getGet('date_to');
        $client = $this->request->getGet('client');
        $hoarding = $this->request->getGet('hoarding');

        // Build order query with filters (city, area, type, status, date range, client, hoarding)
        $orderQuery = $orderModel;
        if ($city) {
            $orderQuery = $orderQuery->join('billboards', 'orders.billboard_id = billboards.id')->where('billboards.city_id', $city);
        }
        if ($area) {
            $orderQuery = $orderQuery->join('billboards b2', 'orders.billboard_id = b2.id')->like('b2.area', $area);
        }
        if ($type) {
            $orderQuery = $orderQuery->join('billboards b3', 'orders.billboard_id = b3.id')->where('b3.billboard_type_id', $type);
        }
        if ($status) {
            $orderQuery = $orderQuery->join('billboards b4', 'orders.billboard_id = b4.id')->where('b4.status', $status);
        }
        if ($date_from) {
            $orderQuery = $orderQuery->where('orders.start_date >=', $date_from);
        }
        if ($date_to) {
            $orderQuery = $orderQuery->where('orders.end_date <=', $date_to);
        }
        if ($client) {
            $orderQuery = $orderQuery->where('orders.customer_id', $client);
        }
        if ($hoarding) {
            $orderQuery = $orderQuery->where('orders.billboard_id', $hoarding);
        }
        $orders = $orderQuery->findAll();

        // Get all customers and billboards for mapping and dropdowns
        $customers = $customerModel->findAll();
        $billboards = $billboardModel->findAll();

        $reportData = [];
        $totalCostSum = 0;
        $receivedSum = 0;
        $balanceSum = 0;
        foreach ($orders as $order) {
            $clientName = '-';
            foreach ($customers as $c) {
                if ($c['id'] == $order['customer_id']) {
                    $clientName = $c['company_name'] ?: ($c['first_name'] . ' ' . $c['last_name']);
                    break;
                }
            }
            $display = '-';
            foreach ($billboards as $b) {
                if ($b['id'] == $order['billboard_id']) {
                    $display = $b['name'];
                    break;
                }
            }
            $totalCost = $order['amount'];
            $payments = $paymentModel->where('order_id', $order['id'])->findAll();
            $received = 0;
            foreach ($payments as $payment) {
                $received += $payment['amount'];
            }
            $balance = $totalCost - $received;
            $totalCostSum += $totalCost;
            $receivedSum += $received;
            $balanceSum += $balance;
            $reportData[] = [
                'client' => $clientName,
                'display' => $display,
                'start_date' => $order['start_date'],
                'end_date' => $order['end_date'],
                'total_cost' => $totalCost,
                'received' => $received,
                'balance' => $balance,
            ];
        }
        // For dropdowns
        $cities = $cityModel->findAll();
        $types = $typeModel->findAll();
        return view('admin/reports/hoarding_wise_revenue', [
            'reportData' => $reportData,
            'cities' => $cities,
            'types' => $types,
            'customers' => $customers,
            'billboards' => $billboards,
            'filters' => [
                'city' => $city,
                'area' => $area,
                'type' => $type,
                'status' => $status,
                'date_from' => $date_from,
                'date_to' => $date_to,
                'client' => $client,
                'hoarding' => $hoarding,
            ],
            'totals' => [
                'total_cost' => $totalCostSum,
                'received' => $receivedSum,
                'balance' => $balanceSum,
            ]
        ]);
    }

    public function hoardingWiseExpense()
    {
        $billboardModel = new BillboardModel();
        $expenseModel = new ExpenseModel();
        $cityModel = new CityModel();
        $typeModel = new BillboardTypeModel();
        $customerModel = new CustomerModel();

        // Get filter values
        $city = $this->request->getGet('city');
        $area = $this->request->getGet('area');
        $type = $this->request->getGet('type');
        $status = $this->request->getGet('status');
        $date_from = $this->request->getGet('date_from');
        $date_to = $this->request->getGet('date_to');
        $client = $this->request->getGet('client');
        $hoarding = $this->request->getGet('hoarding');

        // Build expense query with filters
        $expenseQuery = $expenseModel;
        if ($city) {
            $expenseQuery = $expenseQuery->join('billboards', 'expenses.billboard_id = billboards.id')->where('billboards.city_id', $city);
        }
        if ($area) {
            $expenseQuery = $expenseQuery->join('billboards b2', 'expenses.billboard_id = b2.id')->like('b2.area', $area);
        }
        if ($type) {
            $expenseQuery = $expenseQuery->join('billboards b3', 'expenses.billboard_id = b3.id')->where('b3.billboard_type_id', $type);
        }
        if ($status) {
            $expenseQuery = $expenseQuery->join('billboards b4', 'expenses.billboard_id = b4.id')->where('b4.status', $status);
        }
        if ($date_from) {
            $expenseQuery = $expenseQuery->where('expenses.expense_date >=', $date_from);
        }
        if ($date_to) {
            $expenseQuery = $expenseQuery->where('expenses.expense_date <=', $date_to);
        }
        if ($hoarding) {
            $expenseQuery = $expenseQuery->where('expenses.billboard_id', $hoarding);
        }
        // Client filter: join with orders to find expenses related to a client's bookings
        if ($client) {
            $expenseQuery = $expenseQuery->join('orders', 'orders.billboard_id = expenses.billboard_id', 'left')->where('orders.customer_id', $client);
        }
        $expenses = $expenseQuery->findAll();

        $billboards = $billboardModel->findAll();
        $customers = $customerModel->findAll();

        $reportData = [];
        $totalAmount = 0;
        foreach ($expenses as $expense) {
            $totalAmount += $expense['amount'];
            $hoardingName = '-';
            foreach ($billboards as $b) {
                if ($b['id'] == $expense['billboard_id']) {
                    $hoardingName = $b['name'];
                    break;
                }
            }
            $reportData[] = [
                'date' => $expense['expense_date'],
                'detail' => $expense['addtional_info'],
                'amount' => $expense['amount'],
                'hoarding' => $hoardingName,
            ];
        }
        $cities = $cityModel->findAll();
        $types = $typeModel->findAll();
        return view('admin/reports/hoarding_wise_expense', [
            'reportData' => $reportData,
            'cities' => $cities,
            'types' => $types,
            'customers' => $customers,
            'billboards' => $billboards,
            'filters' => [
                'city' => $city,
                'area' => $area,
                'type' => $type,
                'status' => $status,
                'date_from' => $date_from,
                'date_to' => $date_to,
                'client' => $client,
                'hoarding' => $hoarding,
            ],
            'totalAmount' => $totalAmount,
        ]);
    }

    public function clientWiseReport()
    {
        $orderModel = new OrderModel();
        $billboardModel = new BillboardModel();
        $paymentModel = new PaymentModel();
        $customerModel = new CustomerModel();

        // Filters
        $client = $this->request->getGet('client');
        $date_from = $this->request->getGet('date_from');
        $date_to = $this->request->getGet('date_to');

        $customers = $customerModel->findAll();
        $billboards = $billboardModel->findAll();

        $orders = [];
        if ($client) {
            $orderQuery = $orderModel->where('customer_id', $client);
            if ($date_from) $orderQuery = $orderQuery->where('start_date >=', $date_from);
            if ($date_to) $orderQuery = $orderQuery->where('end_date <=', $date_to);
            $orders = $orderQuery->findAll();
        } else {
            $orderQuery = $orderModel;
            if ($date_from) $orderQuery = $orderQuery->where('start_date >=', $date_from);
            if ($date_to) $orderQuery = $orderQuery->where('end_date <=', $date_to);
            $orders = $orderQuery->findAll();
        }

        $reportData = [];
        $totalCost = 0;
        $totalReceived = 0;
        $totalBalance = 0;
        foreach ($orders as $order) {
            $display = $order['display'] ?? '-';
            $hoarding = '-';
            foreach ($billboards as $b) {
                if ($b['id'] == $order['billboard_id']) {
                    $hoarding = ($b['height'] ?? '-') . 'x' . ($b['width'] ?? '-');
                    break;
                }
            }
            // Find client name for this order
            $clientNameRow = '-';
            foreach ($customers as $c) {
                if ($c['id'] == $order['customer_id']) {
                    $clientNameRow = $c['company_name'] ?: ($c['first_name'] . ' ' . $c['last_name']);
                    break;
                }
            }
            $cost = $order['amount'];
            $received = 0;
            $payments = $paymentModel->where('order_id', $order['id'])->findAll();
            foreach ($payments as $payment) {
                $received += $payment['amount'];
            }
            $balance = $cost - $received;
            $totalCost += $cost;
            $totalReceived += $received;
            $totalBalance += $balance;
            $reportData[] = [
                'client' => $clientNameRow,
                'display' => $display,
                'hoarding' => $hoarding,
                'start_date' => $order['start_date'],
                'end_date' => $order['end_date'],
                'cost' => $cost,
                'received' => $received,
                'balance' => $balance,
            ];
        }
        // Get client name
        $clientName = '';
        foreach ($customers as $c) {
            if ($c['id'] == $client) {
                $clientName = $c['company_name'] ?: ($c['first_name'] . ' ' . $c['last_name']);
                break;
            }
        }
        return view('admin/reports/client_wise_report', [
            'reportData' => $reportData,
            'customers' => $customers,
            'filters' => [
                'client' => $client,
                'date_from' => $date_from,
                'date_to' => $date_to,
            ],
            'clientName' => $clientName,
            'totals' => [
                'cost' => $totalCost,
                'received' => $totalReceived,
                'balance' => $totalBalance,
            ]
        ]);
    }
} 