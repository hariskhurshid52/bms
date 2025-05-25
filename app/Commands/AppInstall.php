<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class AppInstall extends BaseCommand
{
    /**
     * The Command's Group
     *
     * @var string
     */
    protected $group = 'App';

    /**
     * The Command's Name
     *
     * @var string
     */
    protected $name = 'app:install';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = 'Handles application installation, including migrations and seeders.';

    /**
     * The Command's Usage
     *
     * @var string
     */
    protected $usage = 'command:name [arguments] [options]';

    /**
     * The Command's Arguments
     *
     * @var array
     */
    protected $arguments = [];

    /**
     * The Command's Options
     *
     * @var array
     */
    protected $options = [];

    /**
     * Actually execute a command.
     *
     * @param array $params
     */
    public function run(array $params)
    {
        CLI::write('Running migrations...', 'yellow');
        try {
            \Config\Services::cache()->clean();
            CLI::write('Cache cleared successfully!', 'green');
        } catch (\Throwable $e) {
            CLI::error('Error during cache clearing: ' . $e->getMessage());
        }
        try {
            $migrate = \Config\Services::migrations();
            $migrate->latest();
            CLI::write('Migrations completed successfully!', 'green');
        } catch (\Throwable $e) {
            CLI::error('Error during migrations: ' . $e->getMessage());
            return;
        }
        CLI::write('Running seeders...', 'yellow');
        try {
            $seeder = \Config\Database::seeder();
            $seeder->call('RolesSeeder');
            $seeder->call('UsersSeeder');
            $seeder->call('CountriesTableSeeder');
            $seeder->call('StatesTableSeeder');
            $seeder->call('CitiesTableSeeder');
            $seeder->call('BillboardTypes');
            $seeder->call('OrderStatusSeeder');

            CLI::write('Seeders executed successfully!', 'green');
        } catch (\Throwable $e) {
            CLI::error('Error during seeding: ' . $e->getMessage());
            return;
        }

        CLI::write('Clearing application cache...', 'yellow');
        try {
            \Config\Services::cache()->clean();
            CLI::write('Cache cleared successfully!', 'green');
        } catch (\Throwable $e) {
            CLI::error('Error during cache clearing: ' . $e->getMessage());
        }
        CLI::write('Application installation completed successfully!', 'blue');
    }
}




