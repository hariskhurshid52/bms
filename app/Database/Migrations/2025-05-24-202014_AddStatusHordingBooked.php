<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStatusHordingBooked extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('billboards', [
            'status'            => [
                'type'       => 'ENUM',
                'constraint' => ['active', 'inactive', 'under_maintenance','booked'],
                'default'    => 'active',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->modifyColumn('billboards', [
            'status'            => [
                'type'       => 'ENUM',
                'constraint' => ['active', 'inactive', 'under_maintenance'],
                'default'    => 'active',
            ],
        ]);
    }
}
