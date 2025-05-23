<?php

namespace App\Models;

use CodeIgniter\Model;

class BookingPaymentModel extends Model
{
    protected $table = 'booking_payments';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'order_id',
        'amount',
        'payment_date',
        'payment_method',
        'notes',
        'created_at',
        'updated_at',
    ];
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
} 