<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCustomersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'BIGINT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'company_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true, 
            ],
            'first_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'last_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
                'unique'     => true,
            ],
            'phone' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'cnic' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => false,
                'unique'     => true, 
            ],
            'date_of_birth' => [
                'type'       => 'DATE',
                'null'       => true,
            ],
            'address_line_1' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'address_line_2' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'city_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'pronvince_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'country_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'postal_code' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'billing_address' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['active', 'inactive', 'suspended'],
                'null'       => false,
                'default'    => 'active',
            ],
            'created_at' => [
                'type'    => 'DATETIME',
                'null'    => false,
                'default' => date('Y-m-d H:i:s'), 
            ],
            'added_by' => [
                'type'       => 'BIGINT',
                'unsigned'   => true,
                'null'       => false,
            ],
            'updated_at' => [
                'type'    => 'DATETIME',
                'null'    => false,
                'default'    => null,
                'on update' => date('Y-m-d H:i:s'), 
            ],
            'deleted_at' => [
                'type'    => 'DATETIME',
                'null'    => false,
                'default'    => null,
                'on update' => date('Y-m-d H:i:s'), 
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('added_by', 'users', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('customers');
    }

    public function down()
    {
        $this->forge->dropTable('customers', true);
    }
}
