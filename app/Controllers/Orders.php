<?php

namespace App\Controllers;

use App\Models\BillboardModel;
use App\Models\CustomerModel;
use App\Models\OrderModel;
use App\Models\PaymentModel;

class Orders extends BaseController
{
    protected $userId;

    public function __construct()
    {
        parent::__construct();
        $this->userId = $this->session->get('loggedIn')['userId'];
    }

    public function create($param1 = null, $param2 = null)
    {
        $data = [];

        $mdBillboards = new BillboardModel();
        $list = $mdBillboards
            ->join('billboard_types', 'billboard_types.id = billboards.billboard_type_id')
            ->where('status', 'active')
            ->select('billboards.id as id,billboards.name, billboard_types.name as typeName,billboards.area')
            ->findAll();

        $billboards = [];
        foreach ($list as $key => $value) {
            $billboards[$value['typeName']][] = $value;
        }
        $data['billboards'] = $billboards;

        $mdCustomer = new CustomerModel();
        $data['customers'] = $mdCustomer->findAll();

        return view("admin/orders/create", $data);
    }

    public function save()
    {
        $inputs = $this->request->getPost();
        $rules = [
            'billboard' => 'required',
            'customer' => 'required',
            'reservationStart' => 'required|date',
            'reservationEnd' => 'required|date',
            'totalCost' => 'required|numeric',
            'paymentMethod' => 'required',
            'paymentDueDate' => 'required',
        ];
        $validation = \Config\Services::validation();
        if (!$this->validate($rules)) {
            $error = ucfirst(strtolower(array_values($validation->getErrors())[0]));
            return redirect()->back()->withInput()->with('postBack', ['status' => 'error', 'message' => $error]);
        }
        $mdBillboard = new BillboardModel();
        $billboard = $mdBillboard->find($inputs['billboard']);
        if (empty($billboard)) {
            return redirect()->back()->withInput()->with('postBack', ['status' => 'error', 'message' => 'Billboard not found']);
        }
        if ($inputs['totalCost'] < $billboard['booking_price']) {
            return redirect()->back()->withInput()->with('postBack', ['status' => 'error', 'message' => 'Total cost cannot be less than minimum billing price']);
        }

        $totalCost = $inputs['totalCost'];
        $taxAmount = $totalCost * 0.16;
        $totalPriceInclTax = $totalCost + $taxAmount;

        $mdOrder = new OrderModel();
        $insData = [
            'billboard_id' => $inputs['billboard'],
            'display' => $inputs['display'] ?? null,
            'customer_id' => $inputs['customer'],
            'start_date' => $inputs['reservationStart'],
            'end_date' => $inputs['reservationEnd'],
            'addtional_info' => $inputs['addtionalInformatoin'],
            'amount' => $totalCost,
            'tax_amount' => $taxAmount,
            'total_price' => $totalPriceInclTax,
            'payment_method' => $inputs['paymentMethod'],

            'payment_due_date' => $inputs['paymentDueDate'] ?? null,
            'status_id' => 1,
            'added_by' => $this->userId,
            'tax_percent' => 16,

        ];

        $saved = $mdOrder->insert($insData);
        if (!$saved) {
            return redirect()->back()->withInput()->with('postBack', ['status' => 'error', 'message' => 'Unable to create order']);
        }
        if (!empty($inputs['advPayment'])) {
            $insData = [
                'order_id' => $mdOrder->getInsertID(),
                'amount' => $inputs['advPayment'],
                'addtional_info' => 'Advance Payment',
                'added_by' => $this->userId,
                'status_id' => 1
            ];
            $mdPayments = new PaymentModel();
            $saved = $mdPayments->insert($insData);

        }

        return redirect()->route('admin.orders.list')->with('postBack', ['status' => 'success', 'message' => 'Order created successfully']);
    }

    public function listAll()
    {
        $data = [];
        return view("admin/orders/list", $data);
    }

    public function dtList()
    {
        $inputs = $this->request->getPost();
        $model = new OrderModel();

        $builder = $model->builder()
            ->join('billboards', 'billboards.id = orders.billboard_id', 'left')
            ->join('customers', 'customers.id = orders.customer_id', 'left')
            ->join('order_status', 'order_status.id = orders.status_id', 'left')
            ->join('payments', 'payments.order_id = orders.id', 'left')
            ->join('users', 'users.id = orders.added_by', 'left');

        if (!empty($inputs['search']['value'])) {
            $searchValue = $inputs['search']['value'];
            $builder->groupStart()
                ->like('billboards.name', $searchValue)
                ->like('billboards.area', $searchValue)
                ->like('users.name', $searchValue)
                ->like('users.email', $searchValue)
                ->like('customers.first_name', $searchValue)
                ->like('customers.last_name', $searchValue)
                ->like('customers.address_line_1', $searchValue)
                ->like('customers.address_line_2', $searchValue)
                ->like('customers.address_line_2', $searchValue)
                ->like('customers.company_name', $searchValue)
                ->groupEnd();
        }
        $totalRecords = $builder->countAllResults(false);
        $builder->limit($inputs['length'], $inputs['start'])->groupBy('orders.id')
            ->orderBy('orders.id', 'DESC');

        $list = $builder->select('
                orders.id as id,
                orders.created_at,
                orders.display,
                billboards.name as billboardName,
                billboards.area as billboardArea,
                customers.first_name as firstName,
                customers.last_name as lastName,
                order_status.name as statusName,
                orders.start_date as startDate,
                orders.end_date as endDate,
                orders.amount,
                orders.total_price,
                orders.payment_due_date,
                SUM(payments.amount) as paidAmount
               
            ')->get()->getResultArray();
        $rows = [];
        foreach ($list as $key => $value) {
            $rows[] = [
                $value['firstName'] . " " . $value['lastName'],
                $value['display'],
                $value['billboardName'],
                $value['billboardArea'],

                $value['statusName'],
                date('d-m-Y', strtotime($value['startDate'])),
                date('d-m-Y', strtotime($value['endDate'])),
                $value['amount'] . ' PKR',
                $value['total_price'] . ' PKR',
                empty($value['paidAmount']) ? '0 PKR' : $value['paidAmount'] . ' PKR',
                is_null($value['payment_due_date']) ? 'N/A' : date('d-m-Y', strtotime($value['payment_due_date'])),
                date('d-m-Y', strtotime($value['created_at'])),
                '<a href="' . route_to('admin.order.view', $value['id']) . '" class="btn btn-sm btn-info me-1"><i class="fa fa-eye"></i></a>' .
                '<a href="' . route_to('admin.order.edit', $value['id']) . '" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>',

            ];
        }
        return response()->setJSON([
            "draw" => intval($inputs['draw']),
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => count($rows),
            "data" => $rows,
        ]);
    }

    public function edit($id)
    {
        if (!$id) {
            return redirect()->back()->with('postBack', ['status' => 'danger', 'message' => 'Order not found']);
        }
        helper(['form']);
        $data = [];

        $data['order'] = (new OrderModel())
            ->join('payments', "payments.order_id = orders.id AND payments.addtional_info = 'Advance Payment'", 'left')
            ->join('billboards', 'billboards.id = orders.billboard_id', 'left')
            ->select('orders.*,payments.amount as advPayment,billboards.booking_price')
            ->where('orders.id', $id)
            ->first();
        if (empty($data['order'])) {
            return redirect()->back()->with('postBack', ['status' => 'danger', 'message' => 'Order not found']);
        }

        $totalCost = $data['order']['amount'];
        $taxAmount = $totalCost * 0.16;
        $totalPriceInclTax = $totalCost + $taxAmount;
       
        $data['order']['total_price'] = $totalPriceInclTax;
        $data['order']['total_price_incl_tax'] = $taxAmount;


        $mdBillboards = new BillboardModel();
        $list = $mdBillboards
            ->join('billboard_types', 'billboard_types.id = billboards.billboard_type_id')
            ->where('status', 'active')
            ->select('billboards.id as id,billboards.name, billboard_types.name as typeName,billboards.area')
            ->findAll();

        $billboards = [];
        foreach ($list as $key => $value) {
            $billboards[$value['typeName']][] = $value;
        }
        $data['billboards'] = $billboards;

        $mdCustomer = new CustomerModel();
        $data['customers'] = $mdCustomer->findAll();


        return view("admin/orders/edit", $data);
    }

    public function update()
    {
        $inputs = $this->request->getPost();
        $rules = [
           'billboard' => 'required',
            'customer' => 'required',
            'reservationStart' => 'required|date',
            'reservationEnd' => 'required|date',
            'totalCost' => 'required|numeric',
            'paymentMethod' => 'required',
            'paymentDueDate' => 'required',
        ];
        $validation = \Config\Services::validation();
        if (!$this->validate($rules)) {
            $error = ucfirst(strtolower(array_values($validation->getErrors())[0]));
            return redirect()->back()->withInput()->with('postBack', ['status' => 'error', 'message' => $error]);
        }
        $mdBillboard = new BillboardModel();
        $billboard = $mdBillboard->find($inputs['billboard']);
        if (empty($billboard)) {
            return redirect()->back()->withInput()->with('postBack', ['status' => 'error', 'message' => 'Billboard not found']);
        }
        if ($inputs['totalCost'] < $billboard['booking_price']) {
            return redirect()->back()->withInput()->with('postBack', ['status' => 'error', 'message' => 'Total cost cannot be less than minimum billing price']);
        }
        $totalCost = $inputs['totalCost'];
        $taxAmount = $totalCost * 0.16;
        $totalPriceInclTax = $totalCost + $taxAmount;
        $mdOrder = new OrderModel();
        $insData = [
            'billboard_id' => $inputs['billboard'],
            'display' => $inputs['display'] ?? null,
            'customer_id' => $inputs['customer'],
            'start_date' => $inputs['reservationStart'],
            'end_date' => $inputs['reservationEnd'],
            'addtional_info' => $inputs['addtionalInformatoin'],
            'amount' => $totalCost,
            'tax_amount' => $taxAmount,
            'total_price' => $totalPriceInclTax,
            'payment_method' => $inputs['paymentMethod'],
            'payment_due_date' => $inputs['paymentDueDate'] ?? null,
        ];
        $saved = $mdOrder->update($inputs['order_id'], $insData);
        if (!$saved) {
            return redirect()->back()->withInput()->with('postBack', ['status' => 'error', 'message' => 'Unable to update order']);
        }

        if (!is_null($inputs['advPayment'])) {
            $mdPayments = new PaymentModel();
            $advPayment = $mdPayments->where('order_id', $inputs['order_id'])->where('addtional_info', 'Advance Payment')->first();
            if (!empty($advPayment)) {
                $mdPayments->update($advPayment['id'], ['amount' => $inputs['advPayment']]);
            } else {
                $insData = [
                    'order_id' => $inputs['order_id'],
                    'amount' => $inputs['advPayment'],
                    'addtional_info' => 'Advance Payment',
                    'added_by' => $this->userId,
                    'status_id' => 1
                ];
                $saved = $mdPayments->insert($insData);
            }

        }

        return redirect()->route('admin.orders.list')->with('postBack', ['status' => 'success', 'message' => 'Order updated successfully']);
    }

    public function view($id)
    {
        if (!$id) {
            return redirect()->back()->with('postBack', ['status' => 'danger', 'message' => 'Order not found']);
        }

        $data = [];

        // Get order details with related data
        $data['order'] = (new OrderModel())
            ->select('orders.*, order_status.name as status_name')
            ->join('order_status', 'order_status.id = orders.status_id')
            ->join('payments', "payments.order_id = orders.id AND payments.addtional_info = 'Advance Payment'", 'left')
            ->select('orders.*, order_status.name as status_name, payments.amount as advPayment')
            ->where('orders.id', $id)
            ->first();

        if (empty($data['order'])) {
            return redirect()->back()->with('postBack', ['status' => 'danger', 'message' => 'Order not found']);
        }

        // Get billboard details
        $data['billboard'] = (new BillboardModel())
            ->select('billboards.*, billboard_types.name as typeName')
            ->join('billboard_types', 'billboard_types.id = billboards.billboard_type_id')
            ->where('billboards.id', $data['order']['billboard_id'])
            ->first();

        // Get customer details
        $data['customer'] = (new CustomerModel())
            ->where('id', $data['order']['customer_id'])
            ->first();

        // Get payment history
        $data['payments'] = (new PaymentModel())
            ->select('payments.*, users.name as added_by_name')
            ->join('users', 'users.id = payments.added_by')
            ->where('payments.order_id', $id)
            ->orderBy('payments.created_at', 'DESC')
            ->findAll();

        $data['totalPaid'] = 0;
        foreach ($data['payments'] as $payment) {
            $data['totalPaid'] += $payment['amount'];
        }

        return view("admin/orders/view", $data);
    }

    public function addPayment()
    {
        $inputs = $this->request->getPost();
        $rules = [
            'order_id' => 'required|is_natural_no_zero',
            'amount' => 'required|numeric',
            'payment_type' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('postBack', ['status' => 'error', 'message' => 'Invalid input data']);
        }

        $mdPayment = new PaymentModel();
        $insData = [
            'order_id' => $inputs['order_id'],
            'amount' => $inputs['amount'],
            'addtional_info' => $inputs['payment_type'],
            'notes' => $inputs['notes'] ?? null,
            'added_by' => $this->userId,
            'status_id' => 1 // Completed
        ];

        $saved = $mdPayment->insert($insData);
        if (!$saved) {
            return redirect()->back()->with('postBack', ['status' => 'error', 'message' => 'Unable to add payment']);
        }

        return redirect()->back()->with('postBack', ['status' => 'success', 'message' => 'Payment added successfully']);
    }
}
