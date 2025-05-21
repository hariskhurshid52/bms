<?php

namespace App\Controllers;

use App\Libraries\Validation;
use App\Models\AggregatorModel;
use App\Models\AssignedNotificationModel;
use App\Models\CountryCspsModel;
use App\Models\MediaTypesModel;
use App\Models\ServiceInitiationsModel;
use App\Models\ServiceTypesModel;
use App\Models\ShortCodeOrdersModel;
use App\Models\ShortCodesModel;
use App\Models\TariffZoneMappingsModel;
use App\Models\BillboardModel;
use App\Models\OrderModel;
use App\Models\CustomerModel;
use App\Models\ExpenseModel;
use App\Models\OrderStatusModel;

class Home extends BaseController
{
    protected $user;
    protected $billboardModel;
    protected $orderModel;
    protected $customerModel;
    protected $expenseModel;
    protected $orderStatusModel;

    public function __construct()
    {
        parent::__construct();

        $this->user = session()->get('loggedIn');
        $this->billboardModel = new BillboardModel();
        $this->orderModel = new OrderModel();
        $this->customerModel = new CustomerModel();
        $this->expenseModel = new ExpenseModel();
        $this->orderStatusModel = new OrderStatusModel();
    }

    public function index()
    {
        $data = $this->getDashboardData();
        return view("home/dashboard", $data);
    }

    public function home()
    {
        $data = $this->getDashboardData();
        return view("home/dashboard", $data);
    }

    protected function getDashboardData()
    {
        $userId = $this->user['userId'];
        $isAdmin = $this->user['roleId'] == 1;

        // Get total billboards and growth
        $billboardQuery = $this->billboardModel;
        if (!$isAdmin) {
            $billboardQuery->where('added_by', $userId);
        }
        $totalBillboards = $billboardQuery->countAll();
        $lastMonthBillboards = $billboardQuery->where('created_at <', date('Y-m-d H:i:s', strtotime('-1 month')))->countAllResults();
        $billboardGrowth = $lastMonthBillboards > 0 ? round((($totalBillboards - $lastMonthBillboards) / $lastMonthBillboards) * 100) : 0;

        // Get active bookings and growth (status_id 1 is active)
        $orderQuery = $this->orderModel;
        if (!$isAdmin) {
            $orderQuery->where('added_by', $userId);
        }
        $activeBookings = $orderQuery->where('status_id', 1)->countAllResults();
        $lastMonthBookings = $orderQuery->where('status_id', 1)
            ->where('created_at <', date('Y-m-d H:i:s', strtotime('-1 month')))
            ->countAllResults();
        $bookingGrowth = $lastMonthBookings > 0 ? round((($activeBookings - $lastMonthBookings) / $lastMonthBookings) * 100) : 0;

        // Get total revenue and growth (status_id 2 is completed)
        $revenueQuery = $this->orderModel;
        if (!$isAdmin) {
            $revenueQuery->where('added_by', $userId);
        }
        $totalRevenue = $revenueQuery->selectSum('amount')->where('status_id', 2)->first()['amount'] ?? 0;
        $lastMonthRevenue = $revenueQuery->selectSum('amount')
            ->where('status_id', 2)
            ->where('created_at <', date('Y-m-d H:i:s', strtotime('-1 month')))
            ->first()['amount'] ?? 0;
        $revenueGrowth = $lastMonthRevenue > 0 ? round((($totalRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100) : 0;

        // Get total clients and growth
        $clientQuery = $this->customerModel;
        if (!$isAdmin) {
            $clientQuery->where('added_by', $userId);
        }
        $totalClients = $clientQuery->countAll();
        $lastMonthClients = $clientQuery->where('created_at <', date('Y-m-d H:i:s', strtotime('-1 month')))->countAllResults();
        $clientGrowth = $lastMonthClients > 0 ? round((($totalClients - $lastMonthClients) / $lastMonthClients) * 100) : 0;

        // Get expense analytics
        $expenseData = $this->getExpenseAnalytics();
        $totalExpenses = $expenseData['totalExpenses'];
        $expenseGrowth = $expenseData['expenseGrowth'];
        $expenseCategories = $expenseData['categories'];

        // Calculate profitability metrics
        $netProfit = $totalRevenue - $totalExpenses;
        $profitMargin = $totalRevenue > 0 ? round(($netProfit / $totalRevenue) * 100, 1) : 0;
        $roi = $totalExpenses > 0 ? round(($netProfit / $totalExpenses) * 100, 1) : 0;

        // Get revenue vs expense trends
        $revenueExpenseTrends = $this->getRevenueExpenseTrends();

        // Get billboard performance analysis
        $billboardPerformance = $this->getBillboardPerformance();

        // Get booking analytics
        $bookingAnalytics = $this->getBookingAnalytics();

        // Get recent activities
        $recentActivities = $this->getRecentActivities();

        // Get top performing billboards
        $topBillboards = $this->getTopPerformingBillboards();

        // Get billboard status distribution
        $billboardStatus = $this->getBillboardStatusDistribution();

        // Get client distribution
        $clientDistribution = $this->getClientDistribution();

        // Get geographic data
        $mapData = $this->getGeographicData();

        // Get calendar events
        $calendarEvents = $this->getCalendarEvents();

        // Get client analytics
        $clientAnalytics = $this->getClientAnalytics();

        // Add financial analytics data
        $data['revenueTrends'] = $this->getRevenueTrends();
        $data['expenseCategories'] = $this->getExpenseCategories();
        $data['budgetAnalysis'] = $this->getBudgetAnalysis();
        $data['revenueByType'] = $this->getRevenueByType();
        $data['costCategories'] = $this->getCostCategories();
        $data['financialRatios'] = $this->getFinancialRatios();

        // Financial health indicators
        $data['profitMargin'] = $this->calculateProfitMargin();
        $data['roi'] = $this->calculateROI();
        $data['cashFlow'] = $this->calculateCashFlow();
        $data['currentRatio'] = $this->calculateCurrentRatio();
        $data['debtToEquity'] = $this->calculateDebtToEquity();
        $data['returnOnAssets'] = $this->calculateReturnOnAssets();

        return [
            'totalBillboards' => $totalBillboards,
            'billboardGrowth' => $billboardGrowth,
            'activeBookings' => $activeBookings,
            'bookingGrowth' => $bookingGrowth,
            'totalRevenue' => $totalRevenue,
            'revenueGrowth' => $revenueGrowth,
            'totalClients' => $totalClients,
            'clientGrowth' => $clientGrowth,
            'recentActivities' => $recentActivities,
            'topBillboards' => $topBillboards,
            'isAdmin' => $isAdmin,
            'bookingAnalytics' => $bookingAnalytics,
            'billboardStatus' => $billboardStatus,
            'clientDistribution' => $clientDistribution,
            'totalExpenses' => $totalExpenses,
            'expenseGrowth' => $expenseGrowth,
            'expenseCategories' => $expenseCategories,
            'netProfit' => $netProfit,
            'profitMargin' => $profitMargin,
            'roi' => $roi,
            'revenueExpenseTrends' => $revenueExpenseTrends,
            'billboardPerformance' => $billboardPerformance,
            'mapCenter' => $mapData['center'],
            'billboardLocations' => $mapData['locations'],
            'calendarEvents' => $calendarEvents,
            'topClients' => $clientAnalytics['top_clients'],
            'clientMetrics' => $clientAnalytics['metrics'],
            'revenueTrends' => $data['revenueTrends'],
            'expenseCategories' => $data['expenseCategories'],
            'budgetAnalysis' => $data['budgetAnalysis'],
            'revenueByType' => $data['revenueByType'],
            'costCategories' => $data['costCategories'],
            'financialRatios' => $data['financialRatios'],
            'profitMargin' => $data['profitMargin'],
            'roi' => $data['roi'],
            'cashFlow' => $data['cashFlow'],
            'currentRatio' => $data['currentRatio'],
            'debtToEquity' => $data['debtToEquity'],
            'returnOnAssets' => $data['returnOnAssets']
        ];
    }

    protected function getExpenseAnalytics()
    {
        $userId = $this->user['userId'];
        $isAdmin = $this->user['roleId'] == 1;

        $query = $this->expenseModel;
        if (!$isAdmin) {
            $query->where('added_by', $userId);
        }

        // Get total expenses
        $totalExpenses = $query->selectSum('amount')->first()['amount'] ?? 0;

        // Get last month's expenses for growth calculation
        $lastMonthExpenses = $query->selectSum('amount')
            ->where('created_at <', date('Y-m-d H:i:s', strtotime('-1 month')))
            ->first()['amount'] ?? 0;
        $expenseGrowth = $lastMonthExpenses > 0 ? round((($totalExpenses - $lastMonthExpenses) / $lastMonthExpenses) * 100) : 0;

        // Get expenses by type
        $types = [
            'maintenance' => ['name' => 'Maintenance', 'color' => '#0d6efd'],
            'utilities' => ['name' => 'Utilities', 'color' => '#198754'],
            'rent' => ['name' => 'Rent', 'color' => '#ffc107'],
            'staff' => ['name' => 'Staff', 'color' => '#dc3545'],
            'other' => ['name' => 'Other', 'color' => '#6c757d']
        ];

        $expenseCategories = [];
        foreach ($types as $key => $type) {
            $amount = $query->where('type', $key)->selectSum('amount')->first()['amount'] ?? 0;
            $lastMonthAmount = $query->where('type', $key)
                ->where('created_at <', date('Y-m-d H:i:s', strtotime('-1 month')))
                ->selectSum('amount')
                ->first()['amount'] ?? 0;
            
            $trend = $lastMonthAmount > 0 ? round((($amount - $lastMonthAmount) / $lastMonthAmount) * 100) : 0;
            $percentage = $totalExpenses > 0 ? round(($amount / $totalExpenses) * 100, 1) : 0;

            $expenseCategories[] = [
                'name' => $type['name'],
                'color' => $type['color'],
                'amount' => $amount,
                'percentage' => $percentage,
                'trend' => $trend
            ];
        }

        return [
            'totalExpenses' => $totalExpenses,
            'expenseGrowth' => $expenseGrowth,
            'categories' => $expenseCategories
        ];
    }

    protected function getRevenueExpenseTrends()
    {
        $userId = $this->user['userId'];
        $isAdmin = $this->user['roleId'] == 1;

        $labels = [];
        $revenue = [];
        $expenses = [];

        // Get data for last 6 months
        for ($i = 5; $i >= 0; $i--) {
            $startDate = date('Y-m-d H:i:s', strtotime("-$i months"));
            $endDate = date('Y-m-d H:i:s', strtotime("-" . ($i - 1) . " months"));
            
            $labels[] = date('M Y', strtotime($startDate));

            // Get revenue for the month
            $revenueQuery = $this->orderModel->where('status_id', 2)
                ->where('created_at >=', $startDate)
                ->where('created_at <', $endDate);
            if (!$isAdmin) {
                $revenueQuery->where('added_by', $userId);
            }
            $revenue[] = $revenueQuery->selectSum('amount')->first()['amount'] ?? 0;

            // Get expenses for the month
            $expenseQuery = $this->expenseModel
                ->where('created_at >=', $startDate)
                ->where('created_at <', $endDate);
            if (!$isAdmin) {
                $expenseQuery->where('added_by', $userId);
            }
            $expenses[] = $expenseQuery->selectSum('amount')->first()['amount'] ?? 0;
        }

        return [
            'labels' => $labels,
            'revenue' => $revenue,
            'expenses' => $expenses
        ];
    }

    protected function getBillboardPerformance()
    {
        $userId = $this->user['userId'];
        $isAdmin = $this->user['roleId'] == 1;

        $query = $this->billboardModel->select('billboards.*, 
            COALESCE(SUM(CASE WHEN orders.status_id = 2 THEN orders.amount ELSE 0 END), 0) as revenue,
            COALESCE(SUM(expenses.amount), 0) as expenses')
            ->join('orders', 'orders.billboard_id = billboards.id', 'left')
            ->join('expenses', 'expenses.billboard_id = billboards.id', 'left')
            ->groupBy('billboards.id');

        if (!$isAdmin) {
            $query->where('billboards.added_by', $userId);
        }

        $billboards = $query->find();
        $result = [];

        foreach ($billboards as $billboard) {
            $revenue = $billboard['revenue'] ?? 0;
            $expenses = $billboard['expenses'] ?? 0;
            $netProfit = $revenue - $expenses;
            $profitMargin = $revenue > 0 ? round(($netProfit / $revenue) * 100, 1) : 0;

            $result[] = [
                'name' => $billboard['name'],
                'revenue' => $revenue,
                'expenses' => $expenses,
                'net_profit' => $netProfit,
                'profit_margin' => $profitMargin,
                'status' => ucfirst($billboard['status']),
                'status_color' => $this->getStatusColor($billboard['status'])
            ];
        }

        // Sort by net profit
        usort($result, function($a, $b) {
            return $b['net_profit'] - $a['net_profit'];
        });

        return array_slice($result, 0, 5); // Return top 5 performing billboards
    }

    protected function getBookingAnalytics()
    {
        $userId = $this->user['userId'];
        $isAdmin = $this->user['roleId'] == 1;

        $query = $this->orderModel;
        if (!$isAdmin) {
            $query->where('added_by', $userId);
        }

        return [
            'active' => [
                'count' => $query->where('status_id', 1)->countAllResults(),
                'revenue' => $query->where('status_id', 1)->selectSum('amount')->first()['amount'] ?? 0
            ],
            'pending' => [
                'count' => $query->where('status_id', 4)->countAllResults(),
                'revenue' => $query->where('status_id', 4)->selectSum('amount')->first()['amount'] ?? 0
            ],
            'review' => [
                'count' => $query->where('status_id', 3)->countAllResults(),
                'revenue' => $query->where('status_id', 3)->selectSum('amount')->first()['amount'] ?? 0
            ]
        ];
    }

    protected function getBillboardStatusDistribution()
    {
        $userId = $this->user['userId'];
        $isAdmin = $this->user['roleId'] == 1;

        $query = $this->billboardModel;
        if (!$isAdmin) {
            $query->where('added_by', $userId);
        }

        return [
            'active' => $query->where('status', 'active')->countAllResults(),
            'booked' => $query->where('status', 'booked')->countAllResults(),
            'under_maintenance' => $query->where('status', 'under_maintenance')->countAllResults(),
            'inactive' => $query->where('status', 'inactive')->countAllResults()
        ];
    }

    protected function getClientDistribution()
    {
        $userId = $this->user['userId'];
        $isAdmin = $this->user['roleId'] == 1;

        $query = $this->customerModel;
        if (!$isAdmin) {
            $query->where('added_by', $userId);
        }

        $lastMonth = date('Y-m-d H:i:s', strtotime('-1 month'));
        $lastThreeMonths = date('Y-m-d H:i:s', strtotime('-3 months'));

        return [
            'new' => $query->where('created_at >', $lastMonth)->countAllResults(),
            'active' => $query->where('created_at <=', $lastMonth)
                ->where('created_at >', $lastThreeMonths)
                ->countAllResults(),
            'inactive' => $query->where('created_at <=', $lastThreeMonths)->countAllResults()
        ];
    }

    protected function getRecentActivities()
    {
        $activities = [];
        $userId = $this->user['userId'];
        $isAdmin = $this->user['roleId'] == 1;

        // Get recent orders
        $orderQuery = $this->orderModel->orderBy('created_at', 'DESC')->limit(5);
        if (!$isAdmin) {
            $orderQuery->where('added_by', $userId);
        }
        $recentOrders = $orderQuery->find();

        foreach ($recentOrders as $order) {
            $statusText = $this->getStatusText($order['status_id']);
            $activities[] = [
                'type' => 'success',
                'icon' => 'calendar-check-fill',
                'title' => 'New Booking',
                'description' => "Booking #{$order['id']} created with status: {$statusText}",
                'time' => date('M d, Y H:i', strtotime($order['created_at']))
            ];
        }

        // Get recent billboard updates
        $billboardQuery = $this->billboardModel->orderBy('updated_at', 'DESC')->limit(5);
        if (!$isAdmin) {
            $billboardQuery->where('added_by', $userId);
        }
        $recentBillboards = $billboardQuery->find();
        
        foreach ($recentBillboards as $billboard) {
            $activities[] = [
                'type' => 'primary',
                'icon' => 'signal-tower-fill',
                'title' => 'Billboard Updated',
                'description' => "Billboard {$billboard['name']} status changed to {$billboard['status']}",
                'time' => date('M d, Y H:i', strtotime($billboard['updated_at']))
            ];
        }

        // Sort activities by time
        usort($activities, function($a, $b) {
            return strtotime($b['time']) - strtotime($a['time']);
        });

        return array_slice($activities, 0, 5);
    }

    protected function getTopPerformingBillboards()
    {
        $userId = $this->user['userId'];
        $isAdmin = $this->user['roleId'] == 1;

        $query = $this->billboardModel->select('billboards.*, COUNT(orders.id) as bookings, SUM(orders.amount) as revenue')
            ->join('orders', 'orders.billboard_id = billboards.id', 'left')
            ->groupBy('billboards.id')
            ->orderBy('revenue', 'DESC')
            ->limit(5);

        if (!$isAdmin) {
            $query->where('billboards.added_by', $userId);
        }

        $billboards = $query->find();

        $result = [];
        foreach ($billboards as $billboard) {
            $result[] = [
                'location' => $billboard['area'],
                'bookings' => $billboard['bookings'],
                'revenue' => $billboard['revenue'] ?? 0,
                'status' => ucfirst($billboard['status']),
                'status_color' => $this->getStatusColor($billboard['status'])
            ];
        }

        return $result;
    }

    protected function getStatusText($statusId)
    {
        $statuses = [
            1 => 'Active',
            2 => 'Completed',
            3 => 'Cancelled',
            4 => 'Pending'
        ];
        return $statuses[$statusId] ?? 'Unknown';
    }

    protected function getStatusColor($status)
    {
        $colors = [
            'active' => 'success',
            'booked' => 'primary',
            'under_maintenance' => 'warning',
            'inactive' => 'danger'
        ];
        return $colors[$status] ?? 'secondary';
    }

    public function dtShortCodeOrdersList()
    {
        $input = $this->request->getPost();
        $model = new ShortCodeOrdersModel();
        $list = [];
        $total = 0;
        $mediaTypeId = false;
        if (isset($input['mediaType']) && !empty($input['mediaType'])) {
            $mediaTypeId = $input['mediaType'];
        }
        if ($this->user['roleId'] == 3) {

            $list = $model->shortCodeOrdersDtList($input, $this->user['partnerId'], $mediaTypeId);
            $total = $model->partnerOrdersCount($this->user['partnerId'], $mediaTypeId);

        } else {
            $list = $model->shortCodeOrdersDtList($input, false, $mediaTypeId);
            $total = $model->partnerOrdersCount(false, $mediaTypeId);
        }

        $rows = [];
        foreach ($list as $key => $value) {
            $rows[] = [
                $value['mediaType'],
                $value['partnerName'],
                $value['merchantName'],
                $value['serviceName'],
                $value['shortCode'],
                $value['merchantName'],
                $value['netopActionName'],
                $value['moPrice'],
                $value['mtPrice'],
                $value['bindName'],
                $value['serviceDescription'],
                $value['serviceTypeName'],
                $value['promotionType'],
                $value['orderStatusName'],

            ];
        }
        return response()->setJSON([
            "draw" => intval($input['draw']),
            "recordsTotal" => $total,
            "recordsFiltered" => count($rows),
            "data" => $rows,
        ]);
    }

    public function markNotificationRead()
    {
        $inputs = $this->request->getPost();
        $rules = [
            'notificationId' => 'required',
        ];

        $model = new AssignedNotificationModel();
        $model->update($inputs['notificationId'], ['status' => 'read']);
        return response()->setJSON([
            "status" => 'success',
            "message" => "Notification updated",

        ]);
    }

    public function importData()
    {
        $rangesModel = new \App\Models\ServiceRangeModel();
        $response = $rangesModel->orderBy('ABS(start - 700044040)', 'ASC')->first();
        $filename = FCPATH . '../primus_oms_shortcodes.csv';
        $rows = [];
        if (($handle = fopen($filename, 'r')) !== false) {
            $i = 0;
            while (($data = fgetcsv($handle, 10000, ',')) !== false) {
                if ($i > 0) {
                    $rows[] = [
                        'companyName' => $data[0],
                        'bindname' => $data[1],
                        'shortCode' => $data[2],
                        'cop' => $data[3],
                        'serviceId' => $data[4],
                    ];

                }
                $i++;

            }
            // Close the file
            fclose($handle);
        } else {
            echo "Error opening the file.";
        }

        $aggsModel = new AggregatorModel();
        $shortCodeModel = new ShortCodesModel();
        $mappingsModel = new TariffZoneMappingsModel();
        foreach ($rows as $row) {

            if (!empty($row['serviceId'])) {
                $rangeResponse = $rangesModel->orderBy("ABS(start - {$row['serviceId']})", 'ASC')->first();

                if (!empty($rangeResponse)) {
                    $aggResponse = $aggsModel->where('name like', "%{$row['companyName']}%")
                        ->join('countryaggregators', 'countryaggregators.aggregatorId = aggregators.id')
                        ->select('countryaggregators.id as countryAggregatorId,
                                         aggregators.name
                       ')->first();
                    if (!empty($aggResponse)) {
                        $shortCodeData = [
                            'emailText' => "Imported short code via file {$row['shortCode']}",
                            'shortCode' => $row['shortCode'],
                            'countryAggregatorId' => $aggResponse['countryAggregatorId'],
                            'countryCspId' => 1,
                            'accessControl' => strtolower($row['cop']) === "n" ? 'no' : 'yes',
                            'mtPrice' => $rangeResponse['price'],
                            'isCharity' => $rangeResponse['type'] === "psms" ? 'yes' : 'no',
                            'mtServiceRange' => $row['serviceId'],
                            'mediaTypeId' => 2
                        ];
                        $mappings = $mappingsModel->mtMappings($shortCodeData['mtPrice'], $shortCodeData['mediaTypeId'], ($shortCodeData['isCharity'] === "yes"));
                        dd($row, $rangeResponse, $shortCodeData, $mappings);
                    }
                    dd($response);
                }
            }
        }

        dd($response);
    }

    public function cspInfoContent()
    {
        $inputs = $this->request->getPost();
        $data = [];
        if (!empty($inputs['merchantId'])) {
            $model = new CountryCspsModel();
            $data['csp'] = $model->cspInfo($inputs['merchantId'], $this->session->get('loggedIn')['countryId']);
        }
        $html = view('partner/short-codes/partial/merchant-info', $data);
        return response()->setJSON(['status' => 'success', 'html' => $html]);
    }

    public function promotionTypeByMediaType()
    {
        $inputs = $this->request->getPost();
        $rules = [
            'mediaTypeId' => Validation::$REQUIRED,
        ];

        $validation = \Config\Services::validation();
        if (!$this->validate($rules)) {
            return response()->setJSON(["status" => "error", "message" => "Please provide valid media type",]);
        }

        $mediaTypeId = $inputs['mediaTypeId'];

        $model = new ServiceInitiationsModel();
        $initiations = $model->getByMediaType($mediaTypeId);

        $html = view('partner/short-codes/partial/dd-promotion-types', [
            'initiations' => $initiations
        ]);
        return response()->setJSON(["status" => "success", "html" => $html]);

    }

    public function serviceTypeByMediaType()
    {
        $inputs = $this->request->getPost();
        $rules = [
            'mediaTypeId' => Validation::$REQUIRED,
        ];

        $validation = \Config\Services::validation();
        if (!$this->validate($rules)) {
            return response()->setJSON(["status" => "error", "message" => "Please provide valid media type",]);
        }

        $mediaTypeId = $inputs['mediaTypeId'];

        $model = new ServiceTypesModel();
        $servicesTypes = $model->where('type', $mediaTypeId)->findAll();

        $html = view('partner/short-codes/partial/dd-service-types', [
            'servicesTypes' => $servicesTypes
        ]);
        return response()->setJSON(["status" => "success", "html" => $html]);

    }

    protected function getGeographicData()
    {
        $userId = $this->user['userId'];
        $isAdmin = $this->user['roleId'] == 1;

        $query = $this->billboardModel->select('billboards.*, 
            COALESCE(SUM(CASE WHEN orders.status_id = 2 THEN orders.amount ELSE 0 END), 0) as revenue,
            COUNT(DISTINCT orders.id) as bookings')
            ->join('orders', 'orders.billboard_id = billboards.id', 'left')
            ->groupBy('billboards.id');

        if (!$isAdmin) {
            $query->where('billboards.added_by', $userId);
        }

        $billboards = $query->find();
        $locations = [];
        $totalLat = 0;
        $totalLng = 0;
        $count = 0;

        foreach ($billboards as $billboard) {
            if (!empty($billboard['latitude']) && !empty($billboard['longitude'])) {
                $locations[] = [
                    'name' => $billboard['name'],
                    'lat' => $billboard['latitude'],
                    'lng' => $billboard['longitude'],
                    'revenue' => $billboard['revenue'] ?? 0,
                    'bookings' => $billboard['bookings'] ?? 0,
                    'status' => ucfirst($billboard['status'])
                ];
                $totalLat += $billboard['latitude'];
                $totalLng += $billboard['longitude'];
                $count++;
            }
        }

        // Calculate center point
        $center = [
            'lat' => $count > 0 ? $totalLat / $count : 0,
            'lng' => $count > 0 ? $totalLng / $count : 0
        ];

        return [
            'center' => $center,
            'locations' => $locations
        ];
    }

    protected function getCalendarEvents()
    {
        $userId = $this->user['userId'];
        $isAdmin = $this->user['roleId'] == 1;

        $query = $this->orderModel->select('orders.*, billboards.name as billboard_name')
            ->join('billboards', 'billboards.id = orders.billboard_id')
            ->where('orders.start_date >=', date('Y-m-d'))
            ->where('orders.end_date <=', date('Y-m-d', strtotime('+3 months')));

        if (!$isAdmin) {
            $query->where('orders.added_by', $userId);
        }

        $bookings = $query->find();
        $events = [];

        foreach ($bookings as $booking) {
            $events[] = [
                'title' => $booking['billboard_name'],
                'start' => $booking['start_date'],
                'end' => $booking['end_date'],
                'backgroundColor' => $this->getStatusColor($booking['status_id']),
                'borderColor' => $this->getStatusColor($booking['status_id']),
                'extendedProps' => [
                    'booking_id' => $booking['id'],
                    'status' => $this->getStatusText($booking['status_id'])
                ]
            ];
        }

        return $events;
    }

    protected function getClientAnalytics()
    {
        $userId = $this->user['userId'];
        $isAdmin = $this->user['roleId'] == 1;

        // Get top clients by revenue
        $query = $this->customerModel->select('customers.*, 
            COALESCE(SUM(orders.amount), 0) as revenue,
            COUNT(DISTINCT orders.id) as bookings')
            ->join('orders', 'orders.customer_id = customers.id', 'left')
            ->where('orders.status_id', 2) // Completed orders
            ->groupBy('customers.id')
            ->orderBy('revenue', 'DESC')
            ->limit(5);

        if (!$isAdmin) {
            $query->where('customers.added_by', $userId);
        }

        $topClients = $query->find();

        // Calculate client metrics
        $totalClients = $this->customerModel->countAll();
        $newClients = $this->customerModel->where('created_at >=', date('Y-m-d H:i:s', strtotime('-30 days')))->countAllResults();
        
        // Calculate active clients (those with bookings in last 3 months)
        $activeClients = $this->customerModel->select('DISTINCT customers.id')
            ->join('orders', 'orders.customer_id = customers.id')
            ->where('orders.created_at >=', date('Y-m-d H:i:s', strtotime('-3 months')))
            ->countAllResults();

        // Calculate retention rate
        $lastMonthClients = $this->customerModel->where('created_at <', date('Y-m-d H:i:s', strtotime('-30 days')))->countAllResults();
        $retainedClients = $this->customerModel->select('DISTINCT customers.id')
            ->join('orders', 'orders.customer_id = customers.id')
            ->where('orders.created_at >=', date('Y-m-d H:i:s', strtotime('-30 days')))
            ->where('customers.created_at <', date('Y-m-d H:i:s', strtotime('-30 days')))
            ->countAllResults();

        $retentionRate = $lastMonthClients > 0 ? round(($retainedClients / $lastMonthClients) * 100, 1) : 0;

        return [
            'top_clients' => $topClients,
            'metrics' => [
                'new_clients' => $newClients,
                'active_clients' => $activeClients,
                'inactive_clients' => $totalClients - $activeClients,
                'retention_rate' => $retentionRate
            ]
        ];
    }

    private function getRevenueTrends()
    {
        $userId = $this->user['userId'];
        $isAdmin = $this->user['roleId'] == 1;
        
        // Get last 12 months of data
        $months = [];
        $revenue = [];
        $expenses = [];
        
        for ($i = 11; $i >= 0; $i--) {
            $date = date('Y-m', strtotime("-$i months"));
            $months[] = date('M Y', strtotime("-$i months"));
            
            // Get revenue for the month
            $revenueQuery = $this->orderModel;
            if (!$isAdmin) {
                $revenueQuery->where('added_by', $userId);
            }
            $revenueQuery->selectSum('amount')
                ->where('status_id', 2) // Completed orders
                ->where('DATE_FORMAT(created_at, "%Y-%m")', $date);
            
            $revenue[] = $revenueQuery->first()['amount'] ?? 0;
            
            // Get expenses for the month
            $expenseQuery = $this->expenseModel;
            if (!$isAdmin) {
                $expenseQuery->where('added_by', $userId);
            }
            $expenseQuery->selectSum('amount')
                ->where('DATE_FORMAT(created_at, "%Y-%m")', $date);
            
            $expenses[] = $expenseQuery->first()['amount'] ?? 0;
        }
        
        return [
            'labels' => $months,
            'revenue' => $revenue,
            'expenses' => $expenses
        ];
    }

    private function getExpenseCategories()
    {
        $userId = $this->user['userId'];
        $isAdmin = $this->user['roleId'] == 1;

        $query = $this->expenseModel;
        if (!$isAdmin) {
            $query->where('added_by', $userId);
        }

        // Define expense types and their colors
        $types = [
            'maintenance' => ['name' => 'Maintenance', 'color' => '#0d6efd'],
            'utilities' => ['name' => 'Utilities', 'color' => '#198754'],
            'rent' => ['name' => 'Rent', 'color' => '#ffc107'],
            'staff' => ['name' => 'Staff', 'color' => '#dc3545'],
            'other' => ['name' => 'Other', 'color' => '#6c757d']
        ];

        $expenseCategories = [];
        $totalExpenses = 0;
        $labels = [];
        $data = [];
        $colors = [];

        // Get total expenses first
        $totalExpenses = $query->selectSum('amount')->first()['amount'] ?? 0;

        // Get expenses by type
        foreach ($types as $key => $type) {
            $amount = $query->where('type', $key)->selectSum('amount')->first()['amount'] ?? 0;
            $lastMonthAmount = $query->where('type', $key)
                ->where('created_at <', date('Y-m-d H:i:s', strtotime('-1 month')))
                ->selectSum('amount')
                ->first()['amount'] ?? 0;
            
            $trend = $lastMonthAmount > 0 ? round((($amount - $lastMonthAmount) / $lastMonthAmount) * 100) : 0;
            $percentage = $totalExpenses > 0 ? round(($amount / $totalExpenses) * 100, 1) : 0;

            // Add to table data
            $expenseCategories[] = [
                'name' => $type['name'],
                'color' => $type['color'],
                'amount' => $amount,
                'percentage' => $percentage,
                'trend' => $trend
            ];

            // Add to chart data
            $labels[] = $type['name'];
            $data[] = $amount;
            $colors[] = $type['color'];
        }

        return [
            'table' => $expenseCategories,
            'chart' => [
                'labels' => $labels,
                'data' => $data,
                'colors' => $colors
            ]
        ];
    }

    private function getBudgetAnalysis()
    {
        $userId = $this->user['userId'];
        $isAdmin = $this->user['roleId'] == 1;

        // Get revenue by category (billboard type)
        $revenueQuery = $this->orderModel->select('billboard_types.name as category, SUM(orders.amount) as actual_amount')
            ->join('billboards', 'billboards.id = orders.billboard_id')
            ->join('billboard_types', 'billboard_types.id = billboards.billboard_type_id')
            ->where('orders.status_id', 2) // Completed orders
            ->where('YEAR(orders.created_at)', date('Y'))
            ->groupBy('billboard_types.name');

        if (!$isAdmin) {
            $revenueQuery->where('orders.added_by', $userId);
        }

        $revenueData = $revenueQuery->find();

        // Get expenses by category
        $expenseQuery = $this->expenseModel->select('type as category, SUM(amount) as actual_amount')
            ->where('YEAR(created_at)', date('Y'))
            ->groupBy('type');

        if (!$isAdmin) {
            $expenseQuery->where('added_by', $userId);
        }

        $expenseData = $expenseQuery->find();

        // Combine revenue and expense data
        $categories = [];
        $actual = [];
        $budget = [];

        // Add revenue categories
        foreach ($revenueData as $item) {
            $categories[] = 'Revenue - ' . ucfirst($item['category']);
            $actual[] = $item['actual_amount'];
            // For budget, we'll use the average of last 3 months as a simple projection
            $budget[] = $item['actual_amount'] * 1.1; // 10% growth projection
        }

        // Add expense categories
        foreach ($expenseData as $item) {
            $categories[] = 'Expense - ' . ucfirst($item['category']);
            $actual[] = $item['actual_amount'];
            // For budget, we'll use the average of last 3 months as a simple projection
            $budget[] = $item['actual_amount'] * 1.05; // 5% growth projection
        }

        return [
            'labels' => $categories,
            'budget' => $budget,
            'actual' => $actual
        ];
    }

    private function getRevenueByType()
    {
        $userId = $this->user['userId'];
        $isAdmin = $this->user['roleId'] == 1;

        $query = $this->orderModel->select('billboard_types.name as type, SUM(orders.amount) as total')
            ->join('billboards', 'billboards.id = orders.billboard_id')
            ->join('billboard_types', 'billboard_types.id = billboards.billboard_type_id')
            ->where('orders.status_id', 2) // Completed orders
            ->where('YEAR(orders.created_at)', date('Y'))
            ->groupBy('billboard_types.name');

        if (!$isAdmin) {
            $query->where('orders.added_by', $userId);
        }

        $results = $query->find();
        
        $labels = [];
        $data = [];
        
        foreach ($results as $type) {
            $labels[] = ucfirst($type['type']);
            $data[] = $type['total'];
        }
        
        return [
            'labels' => $labels,
            'data' => $data
        ];
    }

    private function getCostCategories()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('expenses');
        
        $expenses = $builder->select('type, SUM(amount) as total')
            ->where('YEAR(expense_date)', date('Y'))
            ->groupBy('type')
            ->get()
            ->getResultArray();
        
        $total = array_sum(array_column($expenses, 'total'));
        
        $categories = [];
        foreach ($expenses as $expense) {
            $categories[] = [
                'name' => ucfirst($expense['type']),
                'amount' => $expense['total'],
                'percentage' => ($expense['total'] / $total) * 100
            ];
        }
        
        return $categories;
    }

    private function getFinancialRatios()
    {
        return [
            'currentRatio' => $this->calculateCurrentRatio(),
            'debtToEquity' => $this->calculateDebtToEquity(),
            'returnOnAssets' => $this->calculateReturnOnAssets()
        ];
    }

    private function calculateProfitMargin()
    {
        $userId = $this->user['userId'];
        $isAdmin = $this->user['roleId'] == 1;
        
        // Get total revenue
        $revenueQuery = $this->orderModel;
        if (!$isAdmin) {
            $revenueQuery->where('added_by', $userId);
        }
        $revenue = $revenueQuery->selectSum('amount')
            ->where('status_id', 2) // Completed orders
            ->where('YEAR(created_at)', date('Y'))
            ->first()['amount'] ?? 0;
        
        // Get total expenses
        $expenseQuery = $this->expenseModel;
        if (!$isAdmin) {
            $expenseQuery->where('added_by', $userId);
        }
        $expenses = $expenseQuery->selectSum('amount')
            ->where('YEAR(created_at)', date('Y'))
            ->first()['amount'] ?? 0;
        
        if ($revenue == 0) return 0;
        
        return (($revenue - $expenses) / $revenue) * 100;
    }

    private function calculateROI()
    {
        $userId = $this->user['userId'];
        $isAdmin = $this->user['roleId'] == 1;
        
        // Get net profit
        $revenueQuery = $this->orderModel;
        if (!$isAdmin) {
            $revenueQuery->where('added_by', $userId);
        }
        $revenue = $revenueQuery->selectSum('amount')
            ->where('status_id', 2) // Completed orders
            ->where('YEAR(created_at)', date('Y'))
            ->first()['amount'] ?? 0;
        
        $expenseQuery = $this->expenseModel;
        if (!$isAdmin) {
            $expenseQuery->where('added_by', $userId);
        }
        $expenses = $expenseQuery->selectSum('amount')
            ->where('YEAR(created_at)', date('Y'))
            ->first()['amount'] ?? 0;
        
        $netProfit = $revenue - $expenses;
        
        // Get total investment (sum of billboard booking prices)
        $billboardQuery = $this->billboardModel;
        if (!$isAdmin) {
            $billboardQuery->where('added_by', $userId);
        }
        $investment = $billboardQuery->selectSum('booking_price')
            ->first()['booking_price'] ?? 0;
        
        if ($investment == 0) return 0;
        
        return ($netProfit / $investment) * 100;
    }

    private function calculateCashFlow()
    {
        $userId = $this->user['userId'];
        $isAdmin = $this->user['roleId'] == 1;
        
        // Get total revenue
        $revenueQuery = $this->orderModel;
        if (!$isAdmin) {
            $revenueQuery->where('added_by', $userId);
        }
        $revenue = $revenueQuery->selectSum('amount')
            ->where('status_id', 2) // Completed orders
            ->where('YEAR(created_at)', date('Y'))
            ->first()['amount'] ?? 0;
        
        // Get total expenses
        $expenseQuery = $this->expenseModel;
        if (!$isAdmin) {
            $expenseQuery->where('added_by', $userId);
        }
        $expenses = $expenseQuery->selectSum('amount')
            ->where('YEAR(created_at)', date('Y'))
            ->first()['amount'] ?? 0;
        
        return $revenue - $expenses;
    }

    private function calculateCurrentRatio()
    {
        $userId = $this->user['userId'];
        $isAdmin = $this->user['roleId'] == 1;
        
        // Get current assets (cash + accounts receivable)
        $revenueQuery = $this->orderModel;
        if (!$isAdmin) {
            $revenueQuery->where('added_by', $userId);
        }
        $currentAssets = $revenueQuery->selectSum('amount')
            ->where('status_id', 2) // Completed orders
            ->where('YEAR(created_at)', date('Y'))
            ->first()['amount'] ?? 0;
        
        // Get current liabilities (accounts payable + short-term debt)
        $expenseQuery = $this->expenseModel;
        if (!$isAdmin) {
            $expenseQuery->where('added_by', $userId);
        }
        $currentLiabilities = $expenseQuery->selectSum('amount')
            ->where('YEAR(created_at)', date('Y'))
            ->first()['amount'] ?? 0;
        
        if ($currentLiabilities == 0) return 0;
        
        return $currentAssets / $currentLiabilities;
    }

    private function calculateDebtToEquity()
    {
        $userId = $this->user['userId'];
        $isAdmin = $this->user['roleId'] == 1;
        
        // Get total debt
        $expenseQuery = $this->expenseModel;
        if (!$isAdmin) {
            $expenseQuery->where('added_by', $userId);
        }
        $totalDebt = $expenseQuery->selectSum('amount')
            ->where('type', 'loan')
            ->where('YEAR(created_at)', date('Y'))
            ->first()['amount'] ?? 0;
        
        // Get total equity (total assets - total liabilities)
        $billboardQuery = $this->billboardModel;
        if (!$isAdmin) {
            $billboardQuery->where('added_by', $userId);
        }
        $totalAssets = $billboardQuery->selectSum('booking_price')
            ->first()['booking_price'] ?? 0;
        
        $expenseQuery = $this->expenseModel;
        if (!$isAdmin) {
            $expenseQuery->where('added_by', $userId);
        }
        $totalLiabilities = $expenseQuery->selectSum('amount')
            ->where('YEAR(created_at)', date('Y'))
            ->first()['amount'] ?? 0;
        
        $totalEquity = $totalAssets - $totalLiabilities;
        
        if ($totalEquity == 0) return 0;
        
        return $totalDebt / $totalEquity;
    }

    private function calculateReturnOnAssets()
    {
        $userId = $this->user['userId'];
        $isAdmin = $this->user['roleId'] == 1;
        
        // Get net income
        $revenueQuery = $this->orderModel;
        if (!$isAdmin) {
            $revenueQuery->where('added_by', $userId);
        }
        $revenue = $revenueQuery->selectSum('amount')
            ->where('status_id', 2) // Completed orders
            ->where('YEAR(created_at)', date('Y'))
            ->first()['amount'] ?? 0;
        
        $expenseQuery = $this->expenseModel;
        if (!$isAdmin) {
            $expenseQuery->where('added_by', $userId);
        }
        $expenses = $expenseQuery->selectSum('amount')
            ->where('YEAR(created_at)', date('Y'))
            ->first()['amount'] ?? 0;
        
        $netIncome = $revenue - $expenses;
        
        // Get total assets
        $billboardQuery = $this->billboardModel;
        if (!$isAdmin) {
            $billboardQuery->where('added_by', $userId);
        }
        $totalAssets = $billboardQuery->selectSum('booking_price')
            ->first()['booking_price'] ?? 0;
        
        if ($totalAssets == 0) return 0;
        
        return ($netIncome / $totalAssets) * 100;
    }

}
