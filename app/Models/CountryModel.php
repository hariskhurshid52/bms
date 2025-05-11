<?php

namespace App\Models;

use CodeIgniter\Model;

class CountryModel extends Model
{
    protected $table      = 'countries';
    protected $primaryKey = 'id';
    protected $useTimestamps = true; 
    protected $allowedFields = ['code', 'name', 'phonecode'];
    
    // Validation Rules (Optional)
    protected $validationRules    = [
        'code' => 'required|max_length[5]',
        'name' => 'required|max_length[255]',
        'phonecode' => 'required|integer',
    ];
    protected $validationMessages = [
        'code' => [
            'required' => 'The country code is required.',
            'max_length' => 'The country code cannot exceed 5 characters.'
        ],
        'name' => [
            'required' => 'The country name is required.',
            'max_length' => 'The country name cannot exceed 255 characters.'
        ],
        'phonecode' => [
            'required' => 'The phone code is required.',
            'integer' => 'The phone code must be an integer.'
        ]
    ];
    
    public function getCountries()
    {
        return $this ->where('code', "PK")->findAll();
    }
    public function getStates($countryId)
    {
        return $this->db->table('states')
                        ->where('country_id', $countryId)
                        ->get()
                        ->getResult();
    }
}
