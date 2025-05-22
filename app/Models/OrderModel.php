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
        'updated_at',
        'display',
        'tax_percent',
        'tax_amount',
        'total_price',
        'advance_payment',
        'payment_due_date',
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
        'display' => 'permit_empty|string',
        'tax_percent' => 'permit_empty|decimal',
        'tax_amount' => 'permit_empty|decimal',
        'total_price' => 'permit_empty|decimal',
        'payment_method' => 'required',
        'advance_payment' => 'permit_empty|decimal',
        'payment_due_date' => 'permit_empty|valid_date',
    ];

    protected $validationMessages = [
        'billboard_id' => [
            'required' => 'The billboard is required.',
            'is_natural_no_zero' => 'The billboard ID must be a positive integer.'
        ],
        'customer_id' => [
            'required' => 'The customer is required.',
            'is_natural_no_zero' => 'The customer ID must be a positive integer.'
        ],
        'start_date' => [
            'required' => 'The start date is required.',
            'valid_date' => 'The start date must be a valid date.'
        ],
        'end_date' => [
            'required' => 'The end date is required.',
            'valid_date' => 'The end date must be a valid date.'
        ],
        'amount' => [
            'required' => 'The amount is required.',
            'decimal' => 'The amount must be a decimal number.'
        ],
        'status_id' => [
            'required' => 'The status is required.',
            'is_natural_no_zero' => 'The status ID must be a positive integer.'
        ],
        'payment_method' => [
            'required' => 'The payment method is required.'
        ],
        'payment_due_date' => [
            'valid_date' => 'The payment due date must be a valid date.'
        ],
    ];

    protected $skipValidation = false;
}
