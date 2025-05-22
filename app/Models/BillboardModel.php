<?php

namespace App\Models;

use CodeIgniter\Model;

class BillboardModel extends Model
{
    protected $table = 'billboards';

    protected $primaryKey = 'id';

    protected $allowedFields = [
        'name',
        'description',
        'city_id',
        'area',
        'address',
        'height',
        'width',
        'size_type',
        'billboard_type_id',
        'status',
        'installation_date',
        'created_at',
        'added_by',
        'updated_at',
        'booking_price',
        'video_url',
        'image_url',
        'annual_increase',
        'traffic_commming_from',
        'contract_duration',
        'contract_date',
        'authority_name',
        'monthly_rent',
        
    ];

    protected $useTimestamps = true;

    // Validation rules
    protected $validationRules = [
        'name' => 'required|max_length[255]',
        'city_id' => 'required|max_length[255]',
        'height' => 'required|max_length[100]',
        'width' => 'required|max_length[100]',
        'size_type' => 'required|in_list[ft,m,in,cm]',
        'billboard_type_id' => 'required|integer|is_not_unique[billboard_types.id]',
        'status' => 'required|in_list[active,inactive,under_maintenance]',
        'installation_date' => 'permit_empty|valid_date',
        'updated_at' => 'permit_empty|valid_date',
        'annual_increase' => 'permit_empty|integer',
        'traffic_commming_from' => 'permit_empty|max_length[500]',
        'contract_duration' => 'permit_empty|integer',
        'contract_date' => 'permit_empty|valid_date',
        'authority_name' => 'permit_empty|max_length[255]',
        'monthly_rent' => 'permit_empty|numeric',
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'The name of the billboard is required.',
            'max_length' => 'The name cannot exceed 255 characters.'
        ],
        'city_id' => [
            'required' => 'The city ID is required.',
            'max_length' => 'The city ID cannot exceed 255 characters.'
        ],
        'height' => [
            'required' => 'The height of the billboard is required.',
            'max_length' => 'The height cannot exceed 100 characters.'
        ],
        'width' => [
            'required' => 'The width of the billboard is required.',
            'max_length' => 'The width cannot exceed 100 characters.'
        ],
        'sizeType' => [
            'required' => 'The size type is required.',
            'in_list' => 'The size type must be one of the following: ft, m, cm, in.'
        ],
        'billboard_type_id' => [
            'required' => 'The billboard type ID is required.',
            'integer' => 'The billboard type ID must be an integer.',
            'is_not_unique' => 'The billboard type ID must exist in the billboard_types table.'
        ],
        'status' => [
            'required' => 'The status is required.',
            'in_list' => 'The status must be one of the following: active, inactive, under_maintenance.'
        ],
        'installation_date' => [
            'valid_date' => 'The installation date must be a valid date.',
        ],
        'created_at' => [
            'valid_date' => 'The created date must be a valid date.',
        ],
        'updated_at' => [
            'valid_date' => 'The updated date must be a valid date.',
        ],
        'annual_increase' => [
            'integer' => 'The annual increase must be an integer.',
        ],
        'traffic_commming_from' => [
            'max_length' => 'The traffic commming from cannot exceed 500 characters.',
        ],
        'contract_duration' => [
            'integer' => 'The contract duration must be an integer.',
        ],
        'contract_date' => [
            'valid_date' => 'The contract date must be a valid date.',
        ],
        'authority_name' => [
            'max_length' => 'The authority name cannot exceed 255 characters.',
        ],
        'monthly_rent' => [
            'numeric' => 'The monthly rent must be a numeric value.',
        ],
        
        
    ];

    protected $returnType = 'array';
}
