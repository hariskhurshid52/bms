<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddBookingPriceBillboards extends Migration
{
    public function up()
    {
        $this->forge->addColumn('billboards', [
            'booking_price' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('billboards', 'booking_price');
    }
}
