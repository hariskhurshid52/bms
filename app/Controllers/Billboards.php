<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Validation;
use App\Models\BillboardModel;
use App\Models\BillboardTypeModel;
use App\Models\CityModel;
use CodeIgniter\HTTP\ResponseInterface;

class Billboards extends BaseController
{
    private $userId;
    public function __construct()
    {
        parent::__construct();
        $this->userId = session()->get('loggedIn')['userId'];

    }
    public function create()
    {
        $data = [];
        $model = new CityModel();
        $data['cities'] = $model->findAll();

        $model = new BillboardTypeModel();
        $data['billboardTypes'] = $model->findAll();

        return view("admin/billboards/add-new", $data);

    }
    public function save()
    {
        $rules = [
            'name' => Validation::$REQUIRED,
            'type' => Validation::$REQUIRED,
            'width' => Validation::$REQUIRED,
            'height' => Validation::$REQUIRED,
            'area' => Validation::$REQUIRED,
        ];
        $validation = \Config\Services::validation();
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('postBack', ['status' => 'error', 'message' => 'Please fill all required fields']);
        }
        $inputs = $this->request->getPost();
        $model = new \App\Models\BillboardModel();
        $insData = [
            'name' => $inputs['name'],
            'billboard_type_id' => $inputs['type'],
            'description' => $inputs['description'],
            'width' => $inputs['width'],
            'height' => $inputs['height'],
            'size_type' => $inputs['size_type'],
            'city_id' => $inputs['area'],
            'area' => $inputs['area'],
            'address' => $inputs['address'],
            'installation_date' => $inputs['installation_date'],
            'status' => $inputs['status'],
            'added_by' => $this->userId,
        ];
        $save = $model->insert($insData);
        if ($save) {
            return redirect()->back()->with('postBack', ['status' => 'success', 'message' => 'Billboard saved successfully']);
        }
        return redirect()->back()->withInput()->with('postBack', ['status' => 'danger', 'message' => 'Failed to save billboard']);

    }

    public function listAll()
    {
        $data = [];

        return view("admin/billboards/list-all", $data);
    }
    public function dtBillboardList()
    {
        $inputs = $this->request->getPost();
        $model = new BillboardModel();

        $builder = $model->builder()
            ->join('billboard_types', 'billboard_types.id = billboards.billboard_type_id', 'left')
            ->join('cities', 'cities.id = billboards.city_id', 'left')
            ->join('users', 'users.id = billboards.added_by', 'left');

        if (!empty($inputs['search']['value'])) {
            $searchValue = $inputs['search']['value'];
            $builder->groupStart()
                ->like('billboards.name', $searchValue)
                ->like('billboards.description', $searchValue)
                ->like('billboards.address', $searchValue)
                ->like('billboards.area', $searchValue)
                ->like('billboards.width', $searchValue)
                ->like('billboards.height', $searchValue)
                ->like('billboard_types.name', $searchValue)
                ->like('users.name', $searchValue)
                ->like('users.email', $searchValue)
                ->like('cities.name', $searchValue)

                ->groupEnd();
        }
        $totalRecords = $builder->countAllResults(false);
        $builder->limit($inputs['length'], $inputs['start'])
            ->orderBy('billboards.id', 'DESC');

        $list = $builder->select('
                billboards.*, cities.name as cityName, users.name as addedBy, billboard_types.name as typeName
               
            ')->get()->getResultArray();
        $rows = [];
        foreach ($list as $key => $value) {
            $statusClass = $value['status'] == "active" ? 'success' : ($value['status'] == "inactive" ? 'danger' : 'warning');
            $rows[] = [
                $value['name'],
                $value['typeName'],
                $value['cityName'],
                $value['area'],
                $value['width'] . "x" . $value['height'] . " " . $value['size_type'],
                '<span class="badge bg-'.$statusClass.'">'.ucfirst($value['status']).'</span>',
                date('d-m-Y', strtotime($value['installation_date'])),
                date('d-m-Y', strtotime($value['created_at'])),
                '<a href="' . route_to('admin.billboard.edit', $value['id']) . '" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>',

            ];
        }
        return response()->setJSON([
            "draw" => intval($inputs['draw']),
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => count($rows),
            "data" => $rows,
        ]);
    }

    public function editBillboard($id=false){
        if (!$id) {
            return redirect()->back()->with('postBack', ['status' => 'danger', 'message' => 'Billboard not found']);
        }
        helper(['form']);
        $model = new BillboardModel();
        $data = [];
        $data['billboard'] = $model->find($id);
        if(empty($data['billboard'])){
            return redirect()->back()->with('postBack', ['status' => 'danger', 'message' => 'Billboard not found']);
        }
        $data['billboardTypes'] = (new \App\Models\BillboardTypeModel())->findAll();
        $data['cities'] = (new \App\Models\CityModel())->findAll();
        return view('admin/billboards/edit', $data);
    }
    public function updateBillboardInfo(){
        $inputs = $this->request->getPost();
        if(empty($inputs['billboardId'])){
            return redirect()->back()->with('postBack', ['status' => 'danger', 'message' => 'Billboard not found']);
        }
        $model = new \App\Models\BillboardModel();
        $insData = [
            'name' => $inputs['name'],
            'billboard_type_id' => $inputs['type'],
            'description' => $inputs['description'],
            'width' => $inputs['width'],
            'height' => $inputs['height'],
            'size_type' => $inputs['size_type'],
            'city_id' => $inputs['area'],
            'area' => $inputs['area'],
            'address' => $inputs['address'],
            'installation_date' => $inputs['installation_date'],
            'status' => $inputs['status'],
        ];
        $save = $model->update($inputs['billboardId'], $insData);
        if ($save) {
            return redirect()->back()->with('postBack', ['status' => 'success', 'message' => 'Billboard updated successfully']);
        }
        return redirect()->back()->with('postBack', ['status' => 'danger', 'message' => 'Failed to update billboard']);

    }
}
