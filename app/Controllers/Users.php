<?php

namespace App\Controllers;

use App\Libraries\Validation;
use App\Models\CityModel;
use App\Models\CountryModel;
use App\Models\CustomerModel;
use App\Models\RoleModel;
use App\Models\StateModel;
use App\Models\UsersModel;

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

        $builder = $model->builder();
        $builder->select('users.*, roles.name as role_name, roles.description as role_description');
        $builder->join('roles', 'roles.id = users.role_id');

        if (!empty($inputs['search']['value'])) {
            $search = $inputs['search']['value'];
            $builder->groupStart()
                ->like('users.name', $search)
                ->orLike('users.username', $search)
                ->orLike('users.email', $search)
                ->orLike('roles.name', $search)
                ->orLike('roles.description', $search)
                ->groupEnd();
        }

        $totalRecords = $builder->countAllResults(false);
        
        // Store filtered count before applying pagination limits
        $filteredRecords = $totalRecords;

        $builder->limit($inputs['length'], $inputs['start']);
        if (!empty($inputs['order'])) {
            $columns = ['users.id', 'users.name', 'users.email', 'users.username', 'roles.name', 'users.created_at', 'users.status'];
            $dir = $inputs['order'][0]['dir'];
            $column = $columns[$inputs['order'][0]['column']];
            $builder->orderBy($column, $dir);
        } else {
            $builder->orderBy('users.id', 'DESC');
        }

        $list = $builder->get()->getResultArray();
        $rows = [];
        foreach ($list as $key => $value) {
            $statusClass = $value['status'] === 'active' ? 'success' : 'danger';
            $rows[] = [
                $value['id'],
                $value['name'],
                $value['email'],
                $value['username'],
                $value['role_name'],
                date('d-m-Y', strtotime($value['created_at'])),
                '<span class="badge bg-' . $statusClass . '">' . ucfirst($value['status']) . '</span>',
                '<div class="btn-group" role="group" aria-label="Actions">
                    <a href="' . route_to('admin.user.edit', $value['id']) . '" class="btn btn-sm btn-outline-primary">
                        <i class="fa fa-edit"></i>
                    </a>
                </div>'
            ];
        }
        return response()->setJSON([
            "draw" => intval($inputs['draw']),
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $filteredRecords,
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

        $roleModel = new RoleModel();
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
        $data = $this->request->getPost();
        $userModel = new UsersModel();
        $user = [
            'name' => $data['name'],
            'email' => $data['email'],
            'username' => $data['username'],
            'password' => $userModel->encryptPassword($data['password']),
            'role_id' => intval($data['role']),
            'status' => $data['status'],
        ];
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

        return view("admin/customers/add-new", $data);
    }

    public function saveCustomerInfo()
    {
        $rules = [
            'firstName' => Validation::$REQUIRED,
            'email' => Validation::$REQUIRED,
            'phone' => Validation::$REQUIRED,
            'address_line_1' => Validation::$REQUIRED,
        ];
        $validation = \Config\Services::validation();
        if (!$this->validate($rules)) {
            $errors = $validation->getErrors();
            log_message('error', 'Validation errors: ' . json_encode($errors));
            log_message('error', 'POST data: ' . json_encode($this->request->getPost()));
            $error = ucfirst(array_values($errors)[0]);
            return redirect()->back()->withInput()->with('postBack', ['status' => 'error', 'message' => $error]);
        }

        $inputs = $this->request->getPost();
        log_message('error', 'Form inputs: ' . json_encode($inputs));

        $insData = [
            'first_name' => $inputs['firstName'],
            'email' => $inputs['email'],
            'phone' => $inputs['phone'],
            'contact_person' => $inputs['contactPerson'],
            'address_line_1' => $inputs['address_line_1'],
            'customer_type' => $inputs['customerType'],
            'added_by' => $this->userId
        ];
        log_message('error', 'Data to be inserted: ' . json_encode($insData));
        $model = new CustomerModel();
        $saved = $model->save($insData);
        if ($saved) {
            return redirect()->route('admin.customers.list')->with('postBack', ['status' => 'success', 'message' => 'Customer added successfully']);
        } elseif (!empty($model->errors())) {
            return redirect()->back()->withInput()->with('postBack', ['status' => 'error', 'message' => array_values($model->errors())[0]]);
        }

        return redirect()->back()->withInput()->with('postBack', ['status' => 'error', 'message' => 'Unable to add customer']);
    }

    public function saveCustomerAjax()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid request method']);
        }

        $rules = [
            'firstName' => Validation::$REQUIRED,
            'email' => Validation::$REQUIRED,
            'phone' => Validation::$REQUIRED,
            'address_line_1' => Validation::$REQUIRED,
        ];
        $validation = \Config\Services::validation();
        if (!$this->validate($rules)) {
            $errors = $validation->getErrors();
            return $this->response->setJSON(['status' => 'error', 'message' => ucfirst(array_values($errors)[0])]);
        }

        $inputs = $this->request->getPost();
        $insData = [
            'first_name' => $inputs['firstName'],
            'email' => $inputs['email'],
            'phone' => $inputs['phone'],
            'contact_person' => $inputs['contactPerson'],
            'address_line_1' => $inputs['address_line_1'],
            'customer_type' => $inputs['customerType'],
            'added_by' => $this->userId
        ];

        $model = new CustomerModel();
        $saved = $model->save($insData);
        
        if ($saved) {
            $customer = $model->find($model->getInsertID());
            return $this->response->setJSON([
                'status' => 'success', 
                'message' => 'Customer added successfully',
                'data' => $customer
            ]);
        } elseif (!empty($model->errors())) {
            return $this->response->setJSON([
                'status' => 'error', 
                'message' => array_values($model->errors())[0]
            ]);
        }

        return $this->response->setJSON([
            'status' => 'error', 
            'message' => 'Unable to add customer'
        ]);
    }

    public function dtCustomersList($customerId = false)
    {
        $inputs = $this->request->getPost();
        $model = new CustomerModel();

        $builder = $model->builder()
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
        
        // Store filtered count before applying pagination limits
        $filteredRecords = $totalRecords;

        $builder->limit($inputs['length'], $inputs['start'])
            ->orderBy('customers.id', 'DESC');

        $list = $builder->select('
                customers.*,
                users.name as addedByName
            ')->get()->getResultArray();
            
        $rows = [];
        foreach ($list as $key => $value) {
            $rows[] = [
                $value['first_name'] . " " . $value['last_name'],
                $value['email'],
                $value['phone'],
                $value['address_line_1'],
                $value['company_name'],
                $value['customer_type'],
                $value['addedByName'],
                date('d-m-Y', strtotime($value['created_at'])),
                '<div class="btn-group" role="group" aria-label="Actions">
                    <a href="' . route_to('admin.customer.edit', $value['id']) . '" class="btn btn-sm btn-outline-primary" title="Edit">
                        <i class="fa fa-edit"></i>
                    </a>
                    <a href="' . route_to('admin.customer.detail', $value['id']) . '" class="btn btn-sm btn-outline-success" title="View">
                        <i class="fa fa-eye"></i>
                    </a>
                </div>'
            ];
        }
        
        return response()->setJSON([
            "draw" => intval($inputs['draw']),
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $filteredRecords,
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
        if (!isset($inputs['customerId']) || empty($inputs['customerId'])) {
            return redirect()->back()->with('postBack', ['status' => 'error', 'message' => 'Customer not found']);
        }
        $rules = [
            'firstName' => Validation::$REQUIRED,
            'email' => Validation::$REQUIRED,
            'phone' => Validation::$REQUIRED,
            'address_line_1' => Validation::$REQUIRED,
        ];
        $validation = \Config\Services::validation();
        if (!$this->validate($rules)) {
            $error = ucfirst(array_values($validation->getErrors())[0]);
            return redirect()->back()->withInput()->with('postBack', ['status' => 'error', 'message' => $error]);
        }


        $insData = [
            'first_name' => $inputs['firstName'],
            'email' => $inputs['email'],
            'phone' => $inputs['phone'],
            'contact_person' => $inputs['contactPerson'],
            'address_line_1' => $inputs['address_line_1'],
            'customer_type' => $inputs['customerType'],
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
