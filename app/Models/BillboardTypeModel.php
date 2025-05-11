<?php

namespace App\Models;

use CodeIgniter\Model;

class BillboardTypeModel extends Model
{
    protected $table      = 'billboard_types';  // Table name
    protected $primaryKey = 'id';               // Primary key column

    protected $allowedFields = ['name'];

    protected $useTimestamps = true;
    
    protected $validationRules = [
        'name' => 'required|is_unique[billboard_types.type_name]|max_length[100]',
    ];

    // Define custom error messages (optional)
    protected $validationMessages = [
        'type_name' => [
            'required' => 'The type name is required.',
            'is_unique' => 'This type name already exists.',
            'max_length' => 'The type name must not exceed 100 characters.',
        ],
    ];

}
