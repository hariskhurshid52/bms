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
        'status_id' => 'required|integer',
        'added_by' => 'required|is_natural_no_zero',
    ];

    protected $validationMessages = [
        'order_id' => [
            'required' => 'The order ID is required.',
            'is_natural_no_zero' => 'The order ID must be a positive integer.'
        ],
        'status_id' => [
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
