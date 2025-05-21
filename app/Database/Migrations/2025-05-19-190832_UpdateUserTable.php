<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateUserTable extends Migration
{
    public function up()
    {
        $this->forge->dropColumn('users',['createdAt','password_updated']);
    }

    public function down()
    {
        $this->forge->addColumn('users',[
            'createdAt' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
            'password_updated' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
        ]);

    }
}
