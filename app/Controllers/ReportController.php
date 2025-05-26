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
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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

        // Set default date range to current month if not provided
        if (empty($date_from)) {
            $date_from = date('Y-m-01');
        }
        if (empty($date_to)) {
            $date_to = date('Y-m-d');
        }

        // Build order query with filters
        $orderQuery = $orderModel->join('billboards', 'orders.billboard_id = billboards.id');
        
        // Apply filters
        if ($city) {
            $orderQuery->where('billboards.city_id', $city);
        }
        if ($area) {
            $orderQuery->like('billboards.area', $area);
        }
        if ($type) {
            $orderQuery->where('billboards.billboard_type_id', $type);
        }
        if ($status) {
            $orderQuery->where('billboards.status', $status);
        }
        if ($date_from) {
            $orderQuery->where('orders.start_date >=', $date_from);
        }
        if ($date_to) {
            $orderQuery->where('orders.end_date <=', $date_to);
        }
        if ($client) {
            $orderQuery->where('orders.customer_id', $client);
        }
        if ($hoarding) {
            $orderQuery->where('orders.billboard_id', $hoarding);
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

        if ($this->request->getGet('export') === 'excel') {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Header
            $sheet->fromArray(['Client', 'Display', 'Start Date', 'End Date', 'Total Cost', 'Received', 'Balance'], null, 'A1');
            $sheet->getStyle('A1:G1')->getFont()->setBold(true); // Make header bold

            // Data
            $rowNum = 2;
            foreach ($reportData as $row) {
                $sheet->fromArray([
                    $row['client'],
                    $row['display'],
                    date('d-M-y', strtotime($row['start_date'])),
                    date('d-M-y', strtotime($row['end_date'])),
                    $row['total_cost'],
                    $row['received'],
                    $row['balance'] > 0 ? $row['balance'] : '-'
                ], null, 'A' . $rowNum++);
            }

            // Totals row
            $sheet->setCellValue('D' . $rowNum, 'Total:-');
            $sheet->setCellValue('E' . $rowNum, $totalCostSum);
            $sheet->setCellValue('F' . $rowNum, $receivedSum);
            $sheet->setCellValue('G' . $rowNum, $balanceSum);

            // Format as currency (optional)
            foreach (['E', 'F', 'G'] as $col) {
                $sheet->getStyle($col . '2:' . $col . $rowNum)->getNumberFormat()->setFormatCode('#,##0');
            }

            // Add borders to all cells
            $sheet->getStyle('A1:G' . $rowNum)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            // Output
            $filename = 'Revenue_Report_' . date('Ymd_His') . '.xlsx';
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header("Content-Disposition: attachment; filename=\"$filename\"");
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
            exit;
        }

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

        // Set default date range to current month if not provided
        if (empty($date_from)) {
            $date_from = date('Y-m-01');
        }
        if (empty($date_to)) {
            $date_to = date('Y-m-d');
        }

        // Build expense query with filters
        $expenseQuery = $expenseModel->join('billboards', 'expenses.billboard_id = billboards.id');
        
        // Apply filters
        if ($city) {
            $expenseQuery->where('billboards.city_id', $city);
        }
        if ($area) {
            $expenseQuery->like('billboards.area', $area);
        }
        if ($type) {
            $expenseQuery->where('billboards.billboard_type_id', $type);
        }
        if ($status) {
            $expenseQuery->where('billboards.status', $status);
        }
        if ($date_from) {
            $expenseQuery->where('expenses.expense_date >=', $date_from);
        }
        if ($date_to) {
            $expenseQuery->where('expenses.expense_date <=', $date_to);
        }
        if ($hoarding) {
            $expenseQuery->where('expenses.billboard_id', $hoarding);
        }
        // Client filter: join with orders to find expenses related to a client's bookings
        if ($client) {
            $expenseQuery->join('orders', 'orders.billboard_id = expenses.billboard_id AND orders.customer_id = ' . $client);
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
                'detail' => $expense['additional_info'] 
                    ?? $expense['addtional_info'] 
                    ?? '-',
                'amount' => $expense['amount'],
                'hoarding' => $hoardingName,
            ];
        }
        $cities = $cityModel->findAll();
        $types = $typeModel->findAll();

        if ($this->request->getGet('export') === 'excel') {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Header
            $sheet->fromArray(['Date', 'Expense Detail', 'Amount'], null, 'A1');
            $sheet->getStyle('A1:C1')->getFont()->setBold(true); // Make header bold

            // Data
            $rowNum = 2;
            foreach ($reportData as $row) {
                $sheet->fromArray([
                    date('d-M-y', strtotime($row['date'])),
                    $row['detail'],
                    $row['amount']
                ], null, 'A' . $rowNum++);
            }

            // Totals row
            $sheet->setCellValue('B' . $rowNum, 'Total');
            $sheet->setCellValue('C' . $rowNum, $totalAmount);

            // Format as currency (optional)
            $sheet->getStyle('C2:C' . $rowNum)->getNumberFormat()->setFormatCode('#,##0');

            // Add borders to all cells
            $sheet->getStyle('A1:C' . $rowNum)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            // Output
            $filename = 'Expense_Report_' . date('Ymd_His') . '.xlsx';
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header("Content-Disposition: attachment; filename=\"$filename\"");
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
            exit;
        }

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

        // Get filter values
        $client = $this->request->getGet('client');
        $date_from = $this->request->getGet('date_from');
        $date_to = $this->request->getGet('date_to');

        // Set default date range to current month if not provided
        if (empty($date_from)) {
            $date_from = date('Y-m-01');
        }
        if (empty($date_to)) {
            $date_to = date('Y-m-d');
        }

        // Validate dates
        if ($date_from && !strtotime($date_from)) {
            return redirect()->back()->with('error', 'Invalid start date format');
        }
        if ($date_to && !strtotime($date_to)) {
            return redirect()->back()->with('error', 'Invalid end date format');
        }
        if ($date_from && $date_to && strtotime($date_from) > strtotime($date_to)) {
            return redirect()->back()->with('error', 'Start date cannot be after end date');
        }

        // Get all customers for dropdown
        $customers = $customerModel->findAll();
        
        // If client is selected, validate it exists
        if ($client) {
            $clientExists = false;
            foreach ($customers as $c) {
                if ($c['id'] == $client) {
                    $clientExists = true;
                    $clientName = $c['company_name'] ?: ($c['first_name'] . ' ' . $c['last_name']);
                    break;
                }
            }
            if (!$clientExists) {
                return redirect()->back()->with('error', 'Invalid client selected');
            }
        }

        // Build query
        $orderQuery = $orderModel->join('billboards', 'orders.billboard_id = billboards.id');
        if ($client) {
            $orderQuery->where('orders.customer_id', $client);
        }
        if ($date_from) {
            $orderQuery->where('orders.start_date >=', $date_from);
        }
        if ($date_to) {
            $orderQuery->where('orders.end_date <=', $date_to);
        }
        $orders = $orderQuery->findAll();

        // Get all billboards for mapping
        $billboards = $billboardModel->findAll();
        $billboardMap = [];
        foreach ($billboards as $b) {
            $billboardMap[$b['id']] = $b;
        }

        $reportData = [];
        $totalCost = 0;
        $totalReceived = 0;
        $totalBalance = 0;
        foreach ($orders as $order) {
            $display = $order['display'] ?? '-';
            $hoarding = '-';
            if (isset($billboardMap[$order['billboard_id']])) {
                $b = $billboardMap[$order['billboard_id']];
                $hoarding = ($b['height'] ?? '-') . 'x' . ($b['width'] ?? '-');
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
                'client' => $clientName ?? '-',
                'display' => $display,
                'hoarding' => $hoarding,
                'start_date' => $order['start_date'],
                'end_date' => $order['end_date'],
                'cost' => $cost,
                'received' => $received,
                'balance' => $balance,
            ];
        }
        // Prepare filters for export (ensure $filters is always defined)
        $filters = [
            'client' => $client,
            'date_from' => $date_from,
            'date_to' => $date_to,
        ];
        if ($this->request->getGet('export') === 'excel') {
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Top info
            $sheet->setCellValue('A1', 'Client');
            $sheet->setCellValue('B1', $clientName ?? '-');
            $sheet->setCellValue('A2', 'Report');
            $sheet->setCellValue('B2', 'From ' . (($filters['date_from'] ?? '') ? date('d-m-Y', strtotime($filters['date_from'])) : '...') . ' to ' . (($filters['date_to'] ?? '') ? date('d-m-Y', strtotime($filters['date_to'])) : '...'));

            // Table header
            $sheet->fromArray(['Display', 'Hoarding', 'Start Date', 'End Date', 'Cost', 'Received', 'Balance'], null, 'A4');
            $sheet->getStyle('A4:G4')->getFont()->setBold(true);

            // Data
            $rowNum = 5;
            foreach ($reportData as $row) {
                $sheet->fromArray([
                    $row['display'],
                    $row['hoarding'],
                    date('d-M-y', strtotime($row['start_date'])),
                    date('d-M-y', strtotime($row['end_date'])),
                    $row['cost'],
                    $row['received'],
                    $row['balance'] > 0 ? $row['balance'] : '-'
                ], null, 'A' . $rowNum++);
            }

            // Totals row
            $sheet->setCellValue('D' . $rowNum, 'Total:-');
            $sheet->setCellValue('E' . $rowNum, $totals['cost'] ?? 0);
            $sheet->setCellValue('F' . $rowNum, $totals['received'] ?? 0);
            $sheet->setCellValue('G' . $rowNum, $totals['balance'] ?? 0);

            // Format as currency
            foreach (['E', 'F', 'G'] as $col) {
                $sheet->getStyle($col . '5:' . $col . $rowNum)->getNumberFormat()->setFormatCode('#,##0');
            }

            // Add borders to all table cells
            $sheet->getStyle('A4:G' . $rowNum)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            // Output
            $filename = 'Client_Wise_Report_' . date('Ymd_His') . '.xlsx';
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header("Content-Disposition: attachment; filename=\"$filename\"");
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $writer->save('php://output');
            exit;
        }
        return view('admin/reports/client_wise_report', [
            'reportData' => $reportData,
            'customers' => $customers,
            'filters' => [
                'client' => $client,
                'date_from' => $date_from,
                'date_to' => $date_to,
            ],
            'clientName' => $clientName ?? '',
            'totals' => [
                'cost' => $totalCost,
                'received' => $totalReceived,
                'balance' => $totalBalance,
            ]
        ]);
    }
} 