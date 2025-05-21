<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddImagesCollsHordings extends Migration
{
    public function up()
    {
        $this->forge->addColumn('billboards',[
            'image_url' => [
                'type' => 'text',
                'null' => true
            ],
            'video_url' => [
                'type' => 'text',
                'null' => true
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('billboards',['image_url','video_url']);
    }
}
