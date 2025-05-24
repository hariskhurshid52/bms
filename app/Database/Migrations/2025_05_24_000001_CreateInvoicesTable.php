<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInvoicesTable extends Migration
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
            'invoice_number' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'customer_id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
            ],
            'invoice_date' => [
                'type' => 'DATE',
            ],
            'po_number' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'amount_words' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'sub_total' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'sales_tax' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'grand_total' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
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
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('customer_id', 'customers', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('invoices');

        // Create invoice_items table
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'invoice_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'description' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'size' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'sqft' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'from_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'to_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'amount' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
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
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('invoice_id', 'invoices', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('invoice_items');
    }

    public function down()
    {
        $this->forge->dropTable('invoice_items');
        $this->forge->dropTable('invoices');
    }
} 