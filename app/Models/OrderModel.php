<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'billboard_id',
        'customer_id',
        'start_date',
        'end_date',
        'addtional_info',
        'amount',
        'payment_method',
        'status_id',
        'added_by',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;

    protected $dateFormat = 'datetime';

    // Validation rules (if needed)
    protected $validationRules = [
        'billboard_id' => 'required|is_natural_no_zero',
        'customer_id' => 'required|is_natural_no_zero',
        'start_date' => 'required|valid_date',
        'end_date' => 'required|valid_date',
        'amount' => 'required|decimal',
        'status_id' => 'required|is_natural_no_zero',
    ];

    protected $validationMessages = [
        'order_id' => [
            'required' => 'The order ID is required.',
            'is_natural_no_zero' => 'The order ID must be a positive integer.'
        ],
        'statusId' => [
            'required' => 'The status ID is required.',
            'integer' => 'The status ID must be an integer.',
        ],
        'added_by' => [
            'required' => 'The added by user ID is required.',
            'is_natural_no_zero' => 'The added by user ID must be a positive integer.'
        ],
    ];

    protected $skipValidation = false;
}
