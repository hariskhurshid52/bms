<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateOrderTableNewFields extends Migration
{
    public function up()
    {
        $this->forge->addColumn('orders', [
            'display' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'tax_percent' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true,
            ],
            'tax_amount' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true,
            ],
            'total_price' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true,
            ],
            'payment_due_date' => [
                'type' => 'DATE',
                'null' => true,
            ],

        ]);
        
    }

    public function down()
    {
        $this->forge->dropColumn('orders', ['display', 'tax_percent', 'tax_amount', 'total_price', 'payment_due_date']);
    }
}
