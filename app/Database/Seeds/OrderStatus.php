<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class OrderStatus extends Seeder
{
    public function run()
    {
        $data = [
            ['id' => 1, 'name' => 'New Order'],
            ['id' => 2, 'name' => 'In Progress'],
            ['id' => 3, 'name' => 'Complete'],
            ['id' => 4, 'name' => 'Un Paid'],
            ['id' => 5, 'name' => 'Paid'],
            ['id' => 6, 'name' => 'Finished'],
        ];

        $this->db->table('order_status')->insertBatch($data);
    }
}
