<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderStatusModel extends Model
{
    protected $table            = 'order_status';
    protected $primaryKey       = 'id';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'name'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [
        'name' => 'required|min_length[3]|max_length[50]'
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'Status name is required.',
            'min_length' => 'Status name must be at least 3 characters long.',
            'max_length' => 'Status name cannot exceed 50 characters.'
        ]
    ];

    protected $skipValidation = false;
}
