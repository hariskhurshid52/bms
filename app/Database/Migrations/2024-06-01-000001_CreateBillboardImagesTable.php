<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBillboardImagesTable extends Migration
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
            'billboard_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'image_url' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('billboard_id', 'billboards', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('billboard_images');
    }

    public function down()
    {
        $this->forge->dropTable('billboard_images');
    }
} 