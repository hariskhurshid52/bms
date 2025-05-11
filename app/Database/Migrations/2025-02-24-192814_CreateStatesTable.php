<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStatesTable extends Migration
{
    public function up()
    {
        // Create 'states' table
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'country_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
            ],
        ]);

        // Define primary key for the table
        $this->forge->addKey('id', true);

        // Create the 'states' table
        $this->forge->createTable('states');
        
        // Add foreign key constraint to 'country_id' (references 'countries' table)
        $this->forge->addForeignKey('country_id', 'countries', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        // Drop the 'states' table if it exists
        $this->forge->dropTable('states');
    }
}
