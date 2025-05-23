<?php

namespace App\Controllers;

use App\Libraries\Validation;
use App\Models\BillboardModel;
use App\Models\BillboardTypeModel;
use App\Models\CityModel;
use App\Models\BillboardImageModel;

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
            'booking_price' => Validation::$REQUIRED,
            'annual_increase' => Validation::$REQUIRED,
            'traffic_commming_from' => Validation::$REQUIRED,
            'contract_duration' => Validation::$REQUIRED,
            'contract_date' => Validation::$REQUIRED,
            'authority_name' => Validation::$REQUIRED,
            'monthly_rent' => Validation::$REQUIRED,
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
            'city_id' => $inputs['city'],
            'area' => $inputs['area'],
            'address' => $inputs['address'],
            'installation_date' => $inputs['installation_date'],
            'status' => $inputs['status'],
            'booking_price' => $inputs['booking_price'],
            'image_url' => $inputs['image_url'],
            'video_url' => $inputs['video_url'],
            'annual_increase' => $inputs['annual_increase'],
            'traffic_commming_from' => $inputs['traffic_commming_from'],
            'contract_duration' => $inputs['contract_duration'],
            'contract_date' => $inputs['contract_date'],
            'authority_name' => $inputs['authority_name'],
            'monthly_rent' => $inputs['monthly_rent'],
            'added_by' => $this->userId,
        ];
       
        $save = $model->insert($insData);
        if ($save) {
            return redirect()->route('admin.billboard.list')->with('postBack', ['status' => 'success', 'message' => 'Billboard saved successfully']);
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

        // DataTables search box
        if (!empty($inputs['search']['value'])) {
            $searchValue = $inputs['search']['value'];
            $builder->groupStart()
                ->like('billboards.name', $searchValue)
                ->orLike('billboards.description', $searchValue)
                ->orLike('billboards.address', $searchValue)
                ->orLike('billboards.area', $searchValue)
                ->orLike('billboards.width', $searchValue)
                ->orLike('billboards.height', $searchValue)
                ->orLike('billboard_types.name', $searchValue)
                ->orLike('users.name', $searchValue)
                ->orLike('users.email', $searchValue)
                ->orLike('cities.name', $searchValue)
                ->groupEnd();
        }

        // Custom filters
        if (!empty($inputs['city'])) {
            $builder->where('cities.name', $inputs['city']);
        }
        if (!empty($inputs['area'])) {
            $builder->where('billboards.area', $inputs['area']);
        }
        if (!empty($inputs['type'])) {
            $builder->where('billboard_types.id', $inputs['type']);
        }
        if (!empty($inputs['status'])) {
            $builder->where('billboards.status', $inputs['status']);
        }

        $totalRecords = $builder->countAllResults(false);
        $builder->limit($inputs['length'], $inputs['start'])
            ->orderBy('billboards.id', 'DESC');

        $list = $builder->select('
                billboards.*, cities.name as cityName, users.name as addedBy, billboard_types.name as typeName
            ')->get()->getResultArray();
        $rows = [];
        $imageModel = new BillboardImageModel();
        foreach ($list as $key => $value) {
            $statusClass = $value['status'] == "active" ? 'success' : ($value['status'] == "inactive" ? 'danger' : 'warning');
            // Fetch all images for this billboard
            $images = $imageModel->where('billboard_id', $value['id'])->findAll();
            $imageUrls = array_map(function($img) {
                return base_url($img['image_url']);
            }, $images);
            // Use the first image as thumbnail, or fallback to no-image
            $thumbUrl = !empty($imageUrls) ? $imageUrls[0] : base_url('assets/images/no-image.png');
            $imageTag = '<img src="' . $thumbUrl . '" alt="Billboard" class="img-thumbnail" style="max-width: 60px; max-height: 40px;">';
            $rows[] = [
                $imageTag,
                $value['name'],
                $value['typeName'],
                $value['booking_price'],
                $value['cityName'],
                $value['area'],
                $value['width'] . "x" . $value['height'] . " " . $value['size_type'],
                '<span class="badge bg-' . $statusClass . '">' . ucfirst($value['status']) . '</span>',
                date('d-m-Y', strtotime($value['installation_date'])),
                date('d-m-Y', strtotime($value['created_at'])),
                '<div class="btn-group" role="group" aria-label="Actions">'
                . '<a href="' . route_to('admin.billboard.edit', $value['id']) . '" class="btn btn-sm btn-outline-primary" title="Edit"><i class="fa fa-edit"></i></a>'
                . '<a href="' . route_to('admin.billboard.detail', $value['id']) . '" class="btn btn-sm btn-outline-success" title="View"><i class="fa fa-eye"></i></a>'
                . '</div>',
                $imageUrls // <-- Add image URLs array as last column
            ];
        }
        return response()->setJSON([
            "draw" => intval($inputs['draw']),
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => count($rows),
            "data" => $rows,
        ]);
    }

    public function editBillboard($id = false)
    {
        if (!$id) {
            return redirect()->back()->with('postBack', ['status' => 'danger', 'message' => 'Billboard not found']);
        }
        helper(['form']);
        $model = new BillboardModel();
        $data = [];
        $data['billboard'] = $model->find($id);
        if (empty($data['billboard'])) {
            return redirect()->back()->with('postBack', ['status' => 'danger', 'message' => 'Billboard not found']);
        }
        $data['billboardTypes'] = (new \App\Models\BillboardTypeModel())->findAll();
        $data['cities'] = (new \App\Models\CityModel())->findAll();
        // Fetch all images for this billboard
        $data['billboardImages'] = (new BillboardImageModel())->where('billboard_id', $id)->findAll();
        return view('admin/billboards/edit', $data);
    }

    public function detailBillboard($id = false)
    {
        if (!$id) {
            return redirect()->back()->with('postBack', ['status' => 'danger', 'message' => 'Billboard not found']);
        }

        $model = new BillboardModel();
        $data = [];
        $data['billboard'] = $model
            ->select('billboards.*, cities.name as cityName, billboard_types.name as typeName')
            ->join('billboard_types', 'billboard_types.id = billboards.billboard_type_id', 'left')
            ->join('cities', 'cities.id = billboards.city_id', 'left')->where('billboards.id', $id)->first();
        if (empty($data['billboard'])) {
            return redirect()->back()->with('postBack', ['status' => 'danger', 'message' => 'Billboard not found']);
        }
        $data['billboardTypes'] = (new \App\Models\BillboardTypeModel())->findAll();
        $data['cities'] = (new \App\Models\CityModel())->findAll();

        return view('admin/billboards/details', $data);
    }

    public function updateBillboardInfo()
    {
        $inputs = $this->request->getPost();
        if (empty($inputs['billboardId'])) {
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
            'city_id' => $inputs['city'],
            'area' => $inputs['area'],
            'address' => $inputs['address'],
            'installation_date' => $inputs['installation_date'],
            'booking_price' => $inputs['booking_price'],
            'status' => $inputs['status'],
            'image_url' => $inputs['image_url'] ?? null,
            'video_url' => $inputs['video_url'],
            'annual_increase' => $inputs['annual_increase'],
            'traffic_commming_from' => $inputs['traffic_commming_from'],
            'contract_duration' => $inputs['contract_duration'],
            'contract_date' => $inputs['contract_date'],
            'authority_name' => $inputs['authority_name'],
            'monthly_rent' => $inputs['monthly_rent'],
        ];
        $save = $model->update($inputs['billboardId'], $insData);
        // Handle images
        $imageUrls = json_decode($inputs['image_urls'] ?? '[]', true);
        $imageModel = new BillboardImageModel();
        $existingImages = $imageModel->where('billboard_id', $inputs['billboardId'])->findAll();
        $existingUrls = array_column($existingImages, 'image_url');
        // Add new images
        foreach ($imageUrls as $url) {
            if (!in_array($url, $existingUrls)) {
                $imageModel->insert([
                    'billboard_id' => $inputs['billboardId'],
                    'image_url' => $url,
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
            }
        }
        // Remove deleted images
        foreach ($existingImages as $img) {
            if (!in_array($img['image_url'], $imageUrls)) {
                $imageModel->delete($img['id']);
            }
        }
        if ($save) {
            return redirect()->route('admin.billboard.list')->with('postBack', ['status' => 'success', 'message' => 'Billboard updated successfully']);
        }
        return redirect()->back()->with('postBack', ['status' => 'danger', 'message' => 'Failed to update billboard']);
    }

    public function getHoardingDataAjax()
    {
        $inputs = $this->request->getPost();
        if (empty($inputs['hoarding'])) {
            return response()->setJSON(['status' => 'error', 'message' => 'Billboard not found']);
        }
        $model = new \App\Models\BillboardModel();
        $data = $model->find($inputs['hoarding']);
        return response()->setJSON(['status' => 'success', 'data' => $data]);
    }

    public function uploadImage()
    {
        $file = $this->request->getFile('file');
        
        if (!$file->isValid() || $file->hasMoved()) {
            return response()->setJSON([
                'status' => 'error',
                'message' => 'Invalid file upload'
            ]);
        }

        // Validate file type
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($file->getMimeType(), $allowedTypes)) {
            return response()->setJSON([
                'status' => 'error',
                'message' => 'Only JPG, PNG and GIF images are allowed'
            ]);
        }

        // Create upload directory if it doesn't exist
        $uploadPath = FCPATH . 'uploads/billboards';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        // Generate unique filename
        $newName = $file->getRandomName();
        
        // Move file to upload directory
        if ($file->move($uploadPath, $newName)) {
            return response()->setJSON([
                'status' => 'success',
                'image_url' => 'uploads/billboards/' . $newName
            ]);
        }

        return response()->setJSON([
            'status' => 'error',
            'message' => 'Failed to upload file'
        ]);
    }

    public function deleteImage()
    {
        $imageUrl = $this->request->getPost('image_url');
        
        if (empty($imageUrl)) {
            return response()->setJSON([
                'status' => 'error',
                'message' => 'No image specified'
            ]);
        }

        // Get the full path to the file
        $filePath = FCPATH . $imageUrl;

        // Check if file exists and is within the uploads directory
        if (file_exists($filePath) && strpos($filePath, FCPATH . 'uploads/billboards/') === 0) {
            // Delete the file
            if (unlink($filePath)) {
                return response()->setJSON([
                    'status' => 'success',
                    'message' => 'File deleted successfully'
                ]);
            }
        }

        return response()->setJSON([
            'status' => 'error',
            'message' => 'Failed to delete file'
        ]);
    }
}
