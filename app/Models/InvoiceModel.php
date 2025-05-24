<?php

namespace App\Models;

use CodeIgniter\Model;

class InvoiceModel extends Model
{
    protected $table = 'invoices';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'invoice_number',
        'customer_id',
        'invoice_date',
        'po_number',
        'amount_words',
        'sub_total',
        'sales_tax',
        'grand_total',
        'created_at',
        'updated_at',
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
} 