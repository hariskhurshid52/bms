<?php

namespace App\Models;

use CodeIgniter\Model;

class RoleModel extends Model
{
    protected $table      = 'roles';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['roleName', 'createdAt', 'updatedAt'];

    // Use timestamps with camelCase
    protected $useTimestamps = true;
    protected $createdField  = 'createdAt';
    protected $updatedField  = 'updatedAt';

    // Validation rules
    protected $validationRules = [
        'roleName'   => 'required|alpha_numeric_space|min_length[3]|max_length[100]',
    ];

    // Validation messages (optional)
    protected $validationMessages = [
        'roleName' => [
            'required'   => 'Role name is required',
            'alpha_numeric_space' => 'Role name can only contain alphanumeric characters and spaces',
        ],
    ];

    // Skip validation if needed
    protected $skipValidation = false;
}
