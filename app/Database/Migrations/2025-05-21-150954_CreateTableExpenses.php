<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableExpenses extends Migration
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
            'type' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => false,
            ],
            'billboard_id' => [
                'type' => 'BIGINT',
                'constraint'     => 11,
                'unsigned'       => true,
                'unsigned' => true,
                'null' => false,
            ],
            'addtional_info' => [
                'type' => 'LONGTEXT',
                'null' => true,
            ],
            'amount' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => false,
            ],

            'added_by' => [
                'type'       => 'BIGINT',
                'unsigned'   => true,
                'null'       => false,
            ],
            'expense_date' => [
                'type' => 'DATETIME',
                'null' => true,
                'default' => date('Y-m-d H:i:s'),
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
        $this->forge->addForeignKey('added_by', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('expenses');

    }

    public function down()
    {
        $this->forge->dropTable('expenses');
    }
}
