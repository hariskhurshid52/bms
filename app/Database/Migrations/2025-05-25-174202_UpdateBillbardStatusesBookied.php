<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateBillbardStatusesBookied extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('billboards', [
            'status'            => [
                'type'       => 'ENUM',
                'constraint' => ['available', 'not_available', 'under_maintenance', 'booked'],
                'default'    => 'available',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->modifyColumn('billboards', [
            'status'            => [
                'type'       => 'ENUM',
                'constraint' => ['active', 'inactive', 'under_maintenance'],
                'constraint' => ['active', 'inactive', 'under_maintenance', 'booked'],
                'default'    => 'active',
            ],
        ]);
    }
}
