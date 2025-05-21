<?php

namespace App\Controllers;

use App\Models\BillboardModel;
use App\Models\ExpenseModel;

class Expense extends BaseController
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


        return view("admin/expense/create", $data);
    }

    public function save()
    {
        $inputs = $this->request->getPost();
        $rules = [
            'type' => 'required',
            'amount' => 'required',
            'expenseDate' => 'required|date',

        ];
        if (!empty($inputs['type']) == "billboard") {
            $rules['billboard'] = 'required';
        }
        $validation = \Config\Services::validation();
        if (!$this->validate($rules)) {
            $error = ucfirst(strtolower(array_values($validation->getErrors())[0]));
            return redirect()->back()->withInput()->with('postBack', ['status' => 'error', 'message' => $error]);
        }

        $mdOrder = new  ExpenseModel();
        $insData = [
            'type' => $inputs['type'],
            'amount' => $inputs['amount'],
            'addtional_info' => $inputs['addtionalInformatoin'],
            'expense_date' => $inputs['expenseDate'],
            'added_by' => $this->userId,

        ];
        if (!empty($inputs['type']) == "billboard") {
            $insData['billboard_id'] = $inputs['billboard'];
        }
        $saved = $mdOrder->insert($insData);
        if (!$saved) {
            return redirect()->back()->withInput()->with('postBack', ['status' => 'error', 'message' => 'Unable to add expense']);
        }

        return redirect()->route('admin.expense.list')->with('postBack', ['status' => 'success', 'message' => 'Expense added successfully']);
    }

    public function listAll()
    {
        $data = [];
        return view("admin/expense/list", $data);
    }

    public function dtList()
    {
        $inputs = $this->request->getPost();
        $model = new ExpenseModel();

        $builder = $model->builder()
            ->join('billboards', 'billboards.id = expenses.billboard_id', 'left')
            ->join('users', 'users.id = expenses.added_by', 'left');

        if (!empty($inputs['search']['value'])) {
            $searchValue = $inputs['search']['value'];
            $builder->groupStart()
                ->like('billboards.name', $searchValue)
                ->like('billboards.area', $searchValue)
                ->like('users.name', $searchValue)
                ->like('users.email', $searchValue)
                ->groupEnd();
        }
        $totalRecords = $builder->countAllResults(false);
        $builder->limit($inputs['length'], $inputs['start'])->groupBy('expenses.id')
            ->orderBy('expenses.id', 'DESC');

        $list = $builder->select('
                expenses.id,
                expenses.type,
                expenses.amount,
                expenses.created_at as addedAt,
                billboards.name as billboardName,
                billboards.area as billboardArea,
                users.name as addedByName,
                expenses.expense_date as expenseDate,
               
            ')->get()->getResultArray();
        $rows = [];
        foreach ($list as $key => $value) {
            $rows[] = [
               ucfirst($value['type']),
                $value['amount'] . ' PKR',
                $value['billboardName'] . ' ' . $value['billboardArea'],
                date('d-m-Y', strtotime($value['expenseDate'])),
                $value['addedByName'],
                date('d-m-Y', strtotime($value['addedAt'])),
//                '<a href="' . route_to('admin.order.edit', $value['id']) . '" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>',

            ];
        }
        return response()->setJSON([
            "draw" => intval($inputs['draw']),
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => count($rows),
            "data" => $rows,
        ]);
    }
}
