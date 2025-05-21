<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateCustomerTable extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('customers', [
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
                'unique'     => false,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->modifyColum('customers', [
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
                'unique'     => true,
            ],
        ]);
    }
}
