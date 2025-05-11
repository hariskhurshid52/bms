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

class Home extends BaseController
{
    protected $user;

    public function __construct()
    {
        parent::__construct();

        $this->user = $this->session->get('loggedIn');
    }

    public function index()
    {

        $data = [];
        return view("home/dashboard", $data);
    }

    public function home()
    {

        $data = [];

        return view("home/dashboard", $data);
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


}
