<?php

namespace App\Models;

use CodeIgniter\Model;

class ExpenseModel extends Model
{
    protected $table = 'expenses';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'type',
        'amount',
        'addtional_info',
        'expense_date',
        'added_by',
        'billboard_id'
    ];
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [
        'type' => 'required',
        'amount' => 'required|numeric',
        'expense_date' => 'required|valid_date',
        'added_by' => 'required|is_natural_no_zero',
    ];

    protected $validationMessages = [
        'type' => [
            'required' => 'The expense type is required.'
        ],
        'amount' => [
            'required' => 'The amount is required.',
            'numeric' => 'The amount must be a number.'
        ],
        'expense_date' => [
            'required' => 'The expense date is required.',
            'valid_date' => 'The expense date must be a valid date.'
        ],
        'added_by' => [
            'required' => 'The user is required.',
            'is_natural_no_zero' => 'The user ID must be a positive integer.'
        ],
    ];
}
