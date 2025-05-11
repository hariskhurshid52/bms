<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBillboardsTable extends Migration
{
    public function up()
    {
        // Define the 'billboards' table
        $this->forge->addField([
            'id'                => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name'              => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => false,
            ],
            'description'              => [
                'type'       => 'LONGTEXT',
                'null'       => true,
            ],
            'area'              => [
                'type'       => 'VARCHAR',
                'constraint' => '500',
                'null'       => true,
            ],
            'address'              => [
                'type'       => 'LONGTEXT',
                'null'       => true,
            ],
            'city_id'          => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'height'              => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'width'              => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
               
            ],
            'size_type'              => [
                'type'       => 'ENUM',
                'constraint' => ["ft", "m", "cm", "in"],
            ],
            'billboard_type_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'null'           => false,
                'comment'        => 'Foreign key to billboard_types table',
            ],
            'status'            => [
                'type'       => 'ENUM',
                'constraint' => ['active', 'inactive', 'under_maintenance'],
                'default'    => 'active',
            ],
            'installation_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'added_by' => [
                'type'       => 'BIGINT',
                'unsigned'   => true,
                'null'       => false,
            ],
            'created_at'        => [
                'type' => 'DATETIME',
                'null' => false,
                'default' => date('Y-m-d H:i:s'),
            ],
            'updated_at'        => [
                'type' => 'DATETIME',
                'null' => true,
                'default' => null,
                'on update' => date('Y-m-d H:i:s'),
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('billboard_type_id', 'billboard_types', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('added_by', 'users', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('billboards');
    }

    public function down()
    {
        $this->forge->dropTable('billboards');
    }
}
