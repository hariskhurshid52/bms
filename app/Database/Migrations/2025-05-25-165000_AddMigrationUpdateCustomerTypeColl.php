<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddMigrationUpdateCustomerTypeColl extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('customers',[
            'customer_type' => [
                'type' => 'ENUM',
                'constraint' => ['customer', 'agency','advertisor'],
                'default' => 'customer',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->modifyColumn('customers',[
            'customer_type' => [
                'type' => 'ENUM',
                'constraint' => ['customer', 'agency'],
                'default' => 'customer',
            ],
        ]);
    }
}
