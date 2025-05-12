<?php

namespace App\Models;

use CodeIgniter\Model;

class CityModel extends Model
{
    protected $table      = 'cities';
    protected $primaryKey = 'id';
    protected $useTimestamps = true; // Enable if you have created_at/updated_at fields
    protected $allowedFields = ['name', 'state_id'];
    
    // Validation Rules (Optional)
    protected $validationRules    = [
        'name' => 'required|max_length[255]',
        'state_id' => 'required|integer',
    ];
    protected $validationMessages = [
        'name' => [
            'required' => 'The city name is required.',
            'max_length' => 'The city name cannot exceed 255 characters.'
        ],
        'state_id' => [
            'required' => 'The state ID is required.',
            'integer' => 'The state ID must be an integer.'
        ]
    ];

    // Relationships (Optional)
    public function getState($cityId)
    {
        return $this->db->table('states')
                        ->where('id', $cityId)
                        ->get()
                        ->getRow();
    }

    public function getCities($countryId)
    {
        return $this->db->table('cities')
            ->whereIn('id', [])
            ->get()
            ->getResult();
    }
}
