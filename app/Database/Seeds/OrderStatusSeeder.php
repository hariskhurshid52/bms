<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['id' => 1, 'name' => 'Active'],
            ['id' => 2, 'name' => 'Pending'],
            ['id' => 3, 'name' => 'Completed'],
            ['id' => 4, 'name' => 'Cancelled'],
        ];

        // Insert data into 'order_status' table
        $this->db->table('order_status')->insertBatch($data);
    }
}
