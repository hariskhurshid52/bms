<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerModel extends Model
{
    protected $table            = 'customers';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    protected $returnType       = 'array'; // Can be 'object' or 'array'
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        'company_name', 
        'first_name', 
        'last_name', 
        'email', 
        'phone', 
        'cnic', 
        'date_of_birth', 
        'address_line_1', 
        'address_line_2', 
        'city_id', 
        'pronvince_id', 
        'country_id', 
        'postal_code', 
        'billing_address', 
        'status', 
        'created_at', 
        'added_by', 
        'updated_at', 
        'deleted_at'
    ];

    // Using timestamps (if enabled)
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation rules (if you need validation)
    protected $validationRules = [
        'first_name' => 'required|min_length[3]|max_length[255]',
        'last_name'  => 'required|min_length[3]|max_length[255]',
        // 'email'      => 'required|valid_email|is_unique[customers.email]',
        // 'cnic'       => 'required|is_unique[customers.cnic]',
    ];

    protected $validationMessages = [
        'first_name' => [
            'required' => 'First name is required.',
            'min_length' => 'First name must be at least 3 characters long.',
        ],
        'last_name' => [
            'required' => 'Last name is required.',
            'min_length' => 'Last name must be at least 3 characters long.',
        ],
        'email' => [
            'required' => 'Email is required.',
            'valid_email' => 'Please provide a valid email address.',
            'is_unique' => 'This email is already in use.',
        ],
        'cnic' => [
            'required' => 'CNIC is required.',
            'is_unique' => 'This CNIC is already in use.',
        ],
    ];

    

    
}
