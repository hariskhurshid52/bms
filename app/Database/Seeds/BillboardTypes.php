<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BillboardTypes extends Seeder
{
    public function run()
    {
        $this->db->disableForeignKeyChecks();
        $this->db->table('billboard_types')->truncate();
        $types = [
            ['name' => 'Digital'],
            ['name' => 'Static'],
            ['name' => 'LED'],
            ['name' => 'Banner'],
        ];

        $this->db->table('billboard_types')->insertBatch($types);
        $this->db->enableForeignKeyChecks();
    }
}
