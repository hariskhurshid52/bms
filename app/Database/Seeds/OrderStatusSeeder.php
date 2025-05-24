<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    public function run()
    {
        $this->db->disableForeignKeyChecks();
        $this->db->table('order_status')->truncate();
        $this->db->enableForeignKeyChecks();
        $data = [
            ['id' => 1, 'name' => 'In Progress'],
            ['id' => 2, 'name' => 'Completed'],
            ['id' => 3, 'name' => 'Cancelled'],
        ];

        // Insert data into 'order_status' table
        $this->db->table('order_status')->insertBatch($data);
    }
}
