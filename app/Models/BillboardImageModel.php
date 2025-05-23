<?php

namespace App\Models;

use CodeIgniter\Model;

class BillboardImageModel extends Model
{
    protected $table = 'billboard_images';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'billboard_id',
        'image_url',
        'created_at',
    ];
    protected $useTimestamps = false;
    protected $returnType = 'array';
} 