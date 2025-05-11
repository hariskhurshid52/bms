<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderStatusModel extends Model
{
    protected $table            = 'orderstatus';
    protected $primaryKey       = 'id';
    protected $useSoftDeletes = false;

    protected $allowedFields = [

    ];

    protected $useTimestamps = true;
    protected $createdField = 'createdAt';
    protected $updatedField = 'updatedAt';
    protected $deletedField = 'deletedAt';

    protected $validationRules = [

    ];

    protected $validationMessages = [
        'email' => [
            'is_unique' => 'The email address is already in use.',
        ],
        'username' => [
            'is_unique' => 'The username is already in use.',
        ],
    ];

    protected $skipValidation = false;
}
