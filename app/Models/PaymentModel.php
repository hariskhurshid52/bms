<?php

namespace App\Models;

use CodeIgniter\Model;

class PaymentModel extends Model
{
    protected $table = 'payments';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'order_id',
        'addtional_info',
        'amount',
        'statusId',
        'added_by',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;

    protected $dateFormat = 'datetime';

    // Validation rules (if needed)
    protected $validationRules = [
        'order_id' => 'required|is_natural_no_zero',
        'amount' => 'required|numeric',
        'status_id' => 'required|integer',
        'added_by' => 'required|is_natural_no_zero',
    ];

    protected $validationMessages = [
        'order_id' => [
            'required' => 'The order is required.',
            'is_natural_no_zero' => 'The order ID must be a positive integer.'
        ],
        'amount' => [
            'required' => 'The amount is required.',
            'numeric' => 'The amount must be a number.'
        ],
        'status_id' => [
            'required' => 'The status is required.',
            'integer' => 'The status must be a valid status.'
        ],
        'added_by' => [
            'required' => 'The user is required.',
            'is_natural_no_zero' => 'The user ID must be a positive integer.'
        ],
    ];

    protected $skipValidation = false;
}
