<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableOrderStatus extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('order_status');

        $this->forge->modifyColumn('orders',[
            'statusId' => [
                'type' => 'INT',
                'name' => 'status_id',
                'constraint' => 11,
                'null' => false,
                'new' => '1',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('order_status');
        $this->forge->modifyColumn('orders',[
            'status_id' => [
                'type' => 'INT',
                'name' => 'statusId',
                'constraint' => 11,
                'null' => false,
                'new' => '1',
            ],
        ]);
    }
}
