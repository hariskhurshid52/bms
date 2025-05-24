<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddInvoiceTypeToInvoices extends Migration
{
    public function up()
    {
        $this->forge->addColumn('invoices', [
            'invoice_type' => [
                'type' => 'VARCHAR',
                'constraint' => 32,
                'null' => true,
                'after' => 'grand_total',
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('invoices', 'invoice_type');
    }
} 