<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateHordingTableNewFields extends Migration
{
    public function up()
    {
        $this->forge->addColumn('billboards', [
            'annual_increase' => [
                'type' => 'INT',
                'constraint' => '11',
                'default' => '5'
            ],
            'traffic_commming_from' => [
                'type' => 'varchar',
                'constraint' => '500',
                'default' => 'N/A'
            ],
            'contract_duration' => [
                'type' => 'int',
                'constraint' => '11',
                'default' => '1'
            ],
            'contract_date' => [
                'type' => 'date',
                'null' => true
            ],
            'authority_name' => [
                'type' => 'varchar',
                'constraint' => '255',
                'default' => 'N/A'
            ],
            'monthly_rent' => [
                'type' => 'decimal',
                'constraint' => '10,2',
                'default' => '0.00'
            ],
        ]);
            
            
            
    }

    public function down()
    {
        $this->forge->dropColumn('billboards', ['annual_increase', 'traffic_commming_from', 'contract_duration', 'contract_date', 'authority_name', 'monthly_rent']);
    }
}
