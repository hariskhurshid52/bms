<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name'             => 'Muhammad Haris Khurshid',
                'email'            => 'hariskhurshid52@gmail.com',
                'username'         => 'hariskhurshid52',
                'password'         => password_hash('hariskhurshid52', PASSWORD_BCRYPT),
                'role_id'           => 1,
                'added_by'          => 1,
                'status'           => 'active',
                'created_at'        => date('Y-m-d H:i:s'),
                'updated_at'        => null,
                'deleted_at'        => null,
            ],
        ];

        $this->db->table('users')->insertBatch($data);
    }
}
