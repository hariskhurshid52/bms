<?php

namespace App\Controllers;

use App\Models\BillboardModel;
use App\Models\OrderModel;
use App\Models\PaymentModel;
use App\Models\CustomerModel;
use App\Models\BillboardTypeModel;

class Dashboard extends BaseController
{
    protected $billboardModel;
    protected $orderModel;
    protected $paymentModel;
    protected $customerModel;
    protected $billboardTypeModel;

    public function __construct()
    {
        $this->billboardModel = new BillboardModel();
        $this->orderModel = new OrderModel();
        $this->paymentModel = new PaymentModel();
        $this->customerModel = new CustomerModel();
        $this->billboardTypeModel = new BillboardTypeModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Dashboard',
            'totalBillboards' => $this->getTotalBillboards(),
            'activeBillboards' => $this->getActiveBillboards(),
            'totalRevenue' => $this->getTotalRevenue(),
            'monthlyRevenue' => $this->getMonthlyRevenue(),
            'billboardStatus' => $this->getBillboardStatus(),
            'recentOrders' => $this->getRecentOrders(),
            'topPerformingBillboards' => $this->getTopPerformingBillboards(),
            'revenueByType' => $this->getRevenueByBillboardType(),
            'monthlyBookings' => $this->getMonthlyBookings(),
            'billboardDetails' => $this->getBillboardDetails()
        ];

        return view('admin/dashboard/index', $data);
    }

    private function getTotalBillboards()
    {
        return $this->billboardModel->countAll();
    }

    private function getActiveBillboards()
    {
        return $this->billboardModel->where('status', 'active')->countAllResults();
    }

    private function getTotalRevenue()
    {
        return $this->orderModel->selectSum('amount')->first()['amount'] ?? 0;
    }

    private function getMonthlyRevenue()
    {
        $currentMonth = date('Y-m');
        return $this->orderModel
            ->where('DATE_FORMAT(created_at, "%Y-%m")', $currentMonth)
            ->selectSum('amount')
            ->first()['amount'] ?? 0;
    }

    private function getBillboardStatus()
    {
        return $this->billboardModel
            ->select('status, COUNT(*) as count')
            ->groupBy('status')
            ->findAll();
    }

    private function getRecentOrders()
    {
        return $this->orderModel
            ->select('orders.*, billboards.name as billboard_name, customers.name as customer_name, order_status.status_name')
            ->join('billboards', 'billboards.id = orders.billboard_id')
            ->join('customers', 'customers.id = orders.customer_id')
            ->join('order_status', 'order_status.id = orders.status_id')
            ->orderBy('orders.created_at', 'DESC')
            ->limit(5)
            ->findAll();
    }

    private function getTopPerformingBillboards()
    {
        return $this->orderModel
            ->select('billboards.name, billboards.booking_price, COUNT(orders.id) as total_orders, SUM(orders.amount) as total_revenue')
            ->join('billboards', 'billboards.id = orders.billboard_id')
            ->groupBy('billboards.id')
            ->orderBy('total_revenue', 'DESC')
            ->limit(5)
            ->findAll();
    }

    private function getRevenueByBillboardType()
    {
        return $this->orderModel
            ->select('billboard_types.type_name, SUM(orders.amount) as total_revenue')
            ->join('billboards', 'billboards.id = orders.billboard_id')
            ->join('billboard_types', 'billboard_types.id = billboards.billboard_type_id')
            ->groupBy('billboard_types.id')
            ->findAll();
    }

    private function getMonthlyBookings()
    {
        $months = [];
        $bookings = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $month = date('Y-m', strtotime("-$i months"));
            $months[] = date('M Y', strtotime($month));
            
            $count = $this->orderModel
                ->where('DATE_FORMAT(created_at, "%Y-%m")', $month)
                ->countAllResults();
            
            $bookings[] = $count;
        }

        return [
            'months' => $months,
            'bookings' => $bookings
        ];
    }

    private function getBillboardDetails()
    {
        return $this->billboardModel
            ->select('billboards.*, billboard_types.type_name, cities.name as city_name')
            ->join('billboard_types', 'billboard_types.id = billboards.billboard_type_id')
            ->join('cities', 'cities.id = billboards.city_id')
            ->where('billboards.status', 'active')
            ->findAll();
    }
} 