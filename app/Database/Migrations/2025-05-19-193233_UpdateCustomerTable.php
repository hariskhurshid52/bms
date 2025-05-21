<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateCustomerTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('customers', [
            'customer_type' => [
                'type' => 'ENUM',
                'constraint' => ['customer', 'agency'],
                'default' => 'customer',
            ],
            'contact_person' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ]);
        $this->forge->modifyColumn('customers',[
            'cnic' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
                'unique'     => false,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('customers', ['customer_type','contact_person']);
        $this->forge->modifyColumn('customers',[
            'cnic' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => false,
                'unique'     => true,
            ],
        ]);
    }
}
