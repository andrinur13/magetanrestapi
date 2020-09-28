<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{

    public function run()
    {


        $data = [
            [
                'id_user_type' => 1,
                'username' => 'admin',
                'name' => 'Admin Sekolah',
                'email' => 'admin@sekolah.sch.id',
                'password' => password_hash('Bismillah', PASSWORD_DEFAULT)
            ],
            [
                'id_user_type' => 1,
                'username' => 'sekretaris',
                'name' => 'Sekretaris Sekolah',
                'email' => 'sekretaris@sekolah.sch.id',
                'password' => password_hash('Bismillah', PASSWORD_DEFAULT)
            ]
        ];

        $this->db->table('user')->insertBatch($data);
    }
}
