<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBillboardsTypesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name'  => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'unique'     => true,
                'comment'    => 'The name of the billboard type (e.g., Digital, Static)',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('billboard_types');
        
    }


    public function down()
    {
        $this->forge->dropTable('billboard_types');
    }
}
