<?php

namespace App\Models;

use CodeIgniter\Model;

class StateModel extends Model
{
    protected $table      = 'states';
    protected $primaryKey = 'id';
    protected $useTimestamps = true; 
    protected $allowedFields = ['name', 'country_id'];
    
    // Validation Rules (Optional)
    protected $validationRules    = [
        'name' => 'required|max_length[255]',
        'country_id' => 'required|integer',
    ];
    protected $validationMessages = [
        'name' => [
            'required' => 'The state name is required.',
            'max_length' => 'The state name cannot exceed 255 characters.'
        ],
        'country_id' => [
            'required' => 'The country ID is required.',
            'integer' => 'The country ID must be an integer.'
        ]
    ];

    // Relationships (Optional)
    public function getCities($stateId)
    {
        return $this->db->table('cities')
                        ->where('state_id', $stateId)
                        ->get()
                        ->getResult();
    }
    
    // Get country details for a state (optional)
    public function getCountry($stateId)
    {
        return $this->db->table('countries')
                        ->join('states', 'states.country_id = countries.id')
                        ->where('states.id', $stateId)
                        ->get()
                        ->getRow();
    }
    public function getCountryStatesList($countryId)
    {
        return $this ->where('country_id', $countryId)->findAll();
    }
}
