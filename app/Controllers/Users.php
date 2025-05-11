<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Validation;
use App\Models\RoleModel;
use App\Models\UsersModel;
use App\Models\CountryModel;
use App\Models\CityModel;
use App\Models\CustomerModel;
use App\Models\StateModel;

class Users extends BaseController
{
    private $userId;

    public function __construct()
    {
        parent::__construct();
        $this->userId = session()->get('loggedIn')['userId'];
    }

    public function index()
    {
        $data = [];
        $roleModel = new RoleModel();
        $data['roles'] = $roleModel->findAll();

        return view("admin/users/create", $data);
    }

    public function listAll()
    {
        $data = [];
        $roleModel = new RoleModel();
        $data['roles'] = $roleModel->findAll();

        return view("admin/users/list-all", $data);
    }

    public function saveUser()
    {
        $data = $this->request->getPost();
        $rules = [
            'name' => Validation::$NAME,
            'email' => Validation::$EMAIL,
            'username' => Validation::$USERNAME,
            'password' => Validation::$PASSWORD,
            'role' => Validation::$ROLE,
            'status' => Validation::$STATUS,

        ];

        $validation = \Config\Services::validation();
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }


        $userModel = new UsersModel();
        try {
            $user = [
                'name' => $data['name'],
                'email' => $data['email'],
                'username' => $data['username'],
                'password' => $userModel->encryptPassword($data['password']),
                'role_id' => $data['role'],
                'status' => $data['status'],
                'added_by' => session()->get('loggedIn')['userId'],
            ];

            $saved = $userModel->save($user);
            if ($saved) {
                return redirect()->route('admin.users.listAll')->with('postBack', ['status' => 'success', 'message' => 'User created successfully']);
            }
        } catch (Exception $e) {
            if ($userModel->errors()) {
                return redirect()->back()->withInput()->with('postBack', ['status' => 'error', 'message' => array_values($userModel->errors())[0]]);
            }
        }
        return redirect()->back()->withInput()->with('postBack', ['status' => 'error', 'message' => 'Unable to create user']);

    }

    public function usersDataTableList()
    {
        $inputs = $this->request->getPost();
        $model = new UsersModel();

        $builder = $model->builder()
            ->join('roles', 'roles.id = users.role_id', 'left')
            ->join('users as ua', 'ua.id = users.added_by', type: 'left')
        ;
        ;

        if (!empty($inputs['search']['value'])) {
            $searchValue = $inputs['search']['value'];
            $builder->groupStart()
                ->like('users.name', $searchValue)
                ->like('users.email', $searchValue)
                ->like('users.username', $searchValue)
                ->orLike('roles.role_name', $searchValue)

                ->groupEnd();
        }
        $totalRecords = $builder->countAllResults(false);
        $builder->limit($inputs['length'], $inputs['start'])
            ->orderBy('users.id', 'DESC');

        $list = $builder->select('
                users.*, roles.role_name as roleName
               
            ')->get()->getResultArray();
        $rows = [];
        foreach ($list as $key => $value) {
            $rows[] = [
                $value['name'],
                $value['email'],
                $value['roleName'],
                date('d-m-Y', strtotime($value['created_at'])),
                '<a href="' . base_url('admin/users/edit/' . $value['id']) . '" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a><a href="' . base_url('admin/order/create/' . $value['id']) . '" class="btn btn-sm btn-primary">Place Order</a>',

            ];
        }
        return response()->setJSON([
            "draw" => intval($inputs['draw']),
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => count($rows),
            "data" => $rows,
        ]);
    }

    public function edit($userId = false)
    {
        helper(['form']);
        if (!$userId) {
            return redirect()->route('admin.users.listAll')->with('postBack', ['status' => 'error', 'message' => 'User not found']);
        }
        $model = new UsersModel();
        $user = $model->where('id', $userId)->first();
        if (!$user) {
            return redirect()->route('admin.users.listAll')->with('postBack', ['status' => 'error', 'message' => 'User not found']);
        }
        $countryId = $user['countryId'];
        $CountryAggregatorsModel = new CountryAggregatorsModel();
        $data['partners'] = $CountryAggregatorsModel->countryAggregatorsList($countryId);
        $roleModel = new RoleModel();
        $data['roles'] = $roleModel->findAll();
        $operatorModel = new OperatorModel();
        $data['operators'] = $operatorModel->getOperatorsByCountry($countryId);
        $data['roles'] = $roleModel->findAll();
        $data['user'] = $user;
        return view("admin/users/edit", $data);
    }

    public function update()
    {
        $data = $this->request->getPost();
        if (!isset($data['userId']) || empty($data['userId'])) {
            return redirect()->route('admin.users.listAll')->with('postBack', ['status' => 'error', 'message' => 'User not found']);
        }

        $rules = [
            'userId' => Validation::$REQUIRED,
            'name' => Validation::$NAME,
            'email' => Validation::$EMAIL,
            'username' => Validation::$USERNAME,
            //            'password' => Validation::$PASSWORD,
            'role' => Validation::$ROLE,
            'status' => Validation::$STATUS
        ];
        if (isset($data['role']) && $data['role'] != 1) {
            $rules['operator'] = Validation::$REQUIRED;
        }
        if (isset($data['role']) && $data['role'] == 3) { // Admin check
            $rules['operator'] = Validation::$REQUIRED;
        }
        $validation = \Config\Services::validation();
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
        $data = $this->request->getPost();
        $userModel = new UsersModel();
        $user = [
            'name' => $data['name'],
            'email' => $data['email'],
            'username' => $data['username'],
            //  'password' => $userModel->encryptPassword($data['password']),
            'roleId' => intval($data['role']),
            'status' => $data['status'],
        ];
        if (isset($data['role']) && $data['role'] != 1) { // Admin check
            $user['operatorId'] = intval($data['operator']);
        }
        if (isset($data['role']) && $data['role'] == 3) { // Admin check
            $user['partnerId'] = $data['partner'];
        }
        $saved = $userModel->update(intval($data['userId']), $user);
        if ($saved) {
            return redirect()->route('admin.users.listAll')->with('postBack', ['status' => 'success', 'message' => 'User updated successfully']);
        }

        return redirect()->back()->withInput()->with('postBack', ['status' => 'error', 'message' => 'Unable to update user']);

    }

    public function customersList()
    {
        $data = [];



        return view("admin/customers/list-all", $data);
    }

    public function createCustoemr()
    {
        $data = [];
        $model = new CountryModel();
        $data['countries'] = $model->getCountries();
        if (count($data['countries']) > 0) {
            $model = new StateModel();
            $data['states'] = $model->getCountryStatesList($data['countries'][0]['id']);
            if (count($data['states']) > 0) {
                $stateIds = array_column($data['states'], 'id');

                $model = new CityModel();
                $data['cities'] = $model->whereIn('state_id', $stateIds)->findAll();
            }

        }
        return view("admin/customers/add-new", $data);
    }

    public function saveCustomerInfo()
    {
        $rules = [
            'firstName' => Validation::$REQUIRED,
            'lastName' => Validation::$REQUIRED,
            'email' => Validation::$REQUIRED,
            'cnic' => Validation::$REQUIRED,
            'address1' => Validation::$REQUIRED,
        ];
        $validation = \Config\Services::validation();
        if (!$this->validate($rules)) {
            $error = ucfirst(array_values($validation->getErrors())[0]);
            return redirect()->back()->withInput()->with('postBack', ['status' => 'error', 'message' => $error]);
        }


        $inputs = $this->request->getPost();

        $insData = [
            'first_name' => $inputs['firstName'],
            'last_name' => $inputs['lastName'],
            'email' => $inputs['email'],
            'phone' => $inputs['phone'],
            'cnic' => $inputs['cnic'],
            'date_of_birth' => $inputs['dateOfBirth'],
            'company_name' => $inputs['companyName'],
            'address_line_1' => $inputs['address1'],
            'address_line_2' => $inputs['address2'],
            'city_id' => $inputs['city'],
            'pronvince_id' => $inputs['state'],
            'country_id' => $inputs['country'],
            'postal_code' => $inputs['postalCode'],
            'billing_address' => $inputs['billingAddress'],
            'status' => $inputs['status'],
            'added_by' => $this->userId
        ];
        $model = new CustomerModel();
        $saved = $model->save($insData);
        if ($saved) {
            return redirect()->route('admin.customers.list')->with('postBack', ['status' => 'success', 'message' => 'Customer added successfully']);
        } elseif (!empty($model->errors())) {
            return redirect()->back()->withInput()->with('postBack', ['status' => 'error', 'message' => array_values($model->errors())[0]]);
        }


        return redirect()->back()->withInput()->with('postBack', ['status' => 'error', 'message' => 'Unable to add customer']);
    }

    public function dtCustomersList($customerId = false)
    {
        $inputs = $this->request->getPost();
        $model = new CustomerModel();

        $builder = $model->builder()
            ->join('countries', 'countries.id = customers.country_id', 'left')
            ->join('states', 'states.id = customers.pronvince_id', 'left')
            ->join('cities', 'cities.id = customers.city_id', 'left')
            ->join('users', 'users.id = customers.added_by', 'left');

        if (!empty($inputs['search']['value'])) {
            $searchValue = $inputs['search']['value'];
            $builder->groupStart()
                ->like('users.name', $searchValue)
                ->like('users.email', $searchValue)
                ->like('customers.first_name', $searchValue)
                ->like('customers.last_name', $searchValue)
                ->like('customers.address_line_1', $searchValue)
                ->like('customers.address_line_2', $searchValue)
                ->like('customers.address_line_2', $searchValue)
                ->like('customers.company_name', $searchValue)
                ->like('countries.name', $searchValue)
                ->like('cities.name', $searchValue)
                ->like('states.name', $searchValue)

                ->groupEnd();
        }
        $totalRecords = $builder->countAllResults(false);
        $builder->limit($inputs['length'], $inputs['start'])
            ->orderBy('customers.id', 'DESC');

        $list = $builder->select('
                customers.*, countries.name as countryName, states.name as stateName, cities.name as cityName
               
            ')->get()->getResultArray();
        $rows = [];
        foreach ($list as $key => $value) {
            $rows[] = [
                $value['first_name'] . " " . $value['last_name'],
                $value['company_name'],
                $value['email'],
                $value['phone'],
                $value['stateName'],
                $value['cityName'],
                ucfirst($value['status']),
                date('d-m-Y', strtotime($value['created_at'])),
                '<a href="' . route_to('admin.customers.edit', $value['id']) . '" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>',

            ];
        }
        return response()->setJSON([
            "draw" => intval($inputs['draw']),
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => count($rows),
            "data" => $rows,
        ]);
    }
    public function editCustomer($customerId = false)
    {
        if (!$customerId) {
            return redirect()->back()->with('postBack', ['status' => 'error', 'message' => 'Customer not found']);
        }
        helper(['form']);
        $data = [];

        $mdCustomer = new CustomerModel();
        $data['customerInfo'] = $mdCustomer->find($customerId);
        if (empty($data['customerInfo'])) {
            return redirect()->back()->with('postBack', ['status' => 'error', 'message' => 'Customer not found']);
        }
        $mdCountry = new CountryModel();
        $mdState = new StateModel();
        $mdCity = new CityModel();
        $data['countries'] = $mdCountry->getCountries();
        if (count($data['countries']) > 0) {
            $model = new StateModel();
            $data['states'] = $model->getCountryStatesList($data['countries'][0]['id']);
            if (count($data['states']) > 0) {
                $stateIds = array_column($data['states'], 'id');

                $model = new CityModel();
                $data['cities'] = $model->whereIn('state_id', $stateIds)->findAll();
            }

        }

        return view("admin/customers/edit", $data);
    }
    public function updateCustomerInfo()
    {
        $inputs = $this->request->getPost();
        if(!isset($inputs['customerId']) || empty($inputs['customerId'])){
            return redirect()->back()->with('postBack', ['status' => 'error', 'message' => 'Customer not found']);
        }
        $rules = [
            'firstName' => Validation::$REQUIRED,
            'lastName' => Validation::$REQUIRED,
            'email' => Validation::$REQUIRED,
            'cnic' => Validation::$REQUIRED,
            'address1' => Validation::$REQUIRED,
        ];
        $validation = \Config\Services::validation();
        if (!$this->validate($rules)) {
            $error = ucfirst(array_values($validation->getErrors())[0]);
            return redirect()->back()->withInput()->with('postBack', ['status' => 'error', 'message' => $error]);
        }


       

        $insData = [
            'first_name' => $inputs['firstName'],
            'last_name' => $inputs['lastName'],
            'email' => $inputs['email'],
            'phone' => $inputs['phone'],
            'cnic' => $inputs['cnic'],
            'date_of_birth' => $inputs['dateOfBirth'],
            'company_name' => $inputs['companyName'],
            'address_line_1' => $inputs['address1'],
            'address_line_2' => $inputs['address2'],
            'city_id' => $inputs['city'],
            'pronvince_id' => $inputs['state'],
            'country_id' => $inputs['country'],
            'postal_code' => $inputs['postalCode'],
            'billing_address' => $inputs['billingAddress'],
            'status' => $inputs['status'],
        ];
        $model = new CustomerModel();
        $saved = $model->update($inputs['customerId'], $insData);
        if ($saved) {
            return redirect()->route('admin.customers.list')->with('postBack', ['status' => 'success', 'message' => 'Customer updated successfully']);
        } elseif (!empty($model->errors())) {
            return redirect()->back()->withInput()->with('postBack', ['status' => 'error', 'message' => array_values($model->errors())[0]]);
        }


        return redirect()->back()->withInput()->with('postBack', ['status' => 'error', 'message' => 'Unable to update customer']);
    }
}
