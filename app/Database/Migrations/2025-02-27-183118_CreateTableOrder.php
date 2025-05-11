<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableOrder extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'billboard_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'customer_id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
            ],
            'start_date' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'end_date' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'addtional_info' => [
                'type' => 'LONGTEXT',
                'null' => true,
            ],
            'amount' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true,
            ],
            'payment_method' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'statusId' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
                'new' => '1',
            ],
            'added_by' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'default' => date('Y-m-d H:i:s'),
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'on update' => date('Y-m-d H:i:s'),
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('billboard_id', 'billboards', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('customer_id', 'customers', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('added_by', 'users', 'id', 'CASCADE', 'CASCADE');
       
        $this->forge->createTable('orders');
        
    }

    public function down()
    {
        $this->forge->dropTable('orders');
    }
}
