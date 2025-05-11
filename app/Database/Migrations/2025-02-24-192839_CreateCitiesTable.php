<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCitiesTable extends Migration
{
    public function up()
    {
        // Create 'cities' table
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
            'state_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
            ],
        ]);

        // Define primary key for the table
        $this->forge->addKey('id', true);

        // Create the 'cities' table
        $this->forge->createTable('cities');
        
        // Add foreign key constraint to 'state_id' (references 'states' table)
        $this->forge->addForeignKey('state_id', 'states', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        // Drop the 'cities' table if it exists
        $this->forge->dropTable('cities');
    }
}
