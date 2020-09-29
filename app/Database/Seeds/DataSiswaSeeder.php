<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DataSiswaSeeder extends Seeder
{

    public function run()
    {
        $faker = \Faker\Factory::create();

        for($i = 0; $i < 100; $i++)
        {
            $data = [
                'nisn' => $faker->randomNumber(6),
                'nik' => $faker->randomNumber(9),
                'nama' => $faker->name(),
                'tgl_lahir' => $faker->date('Y-m-d', '2004-12-31'),
                'alamat' => $faker->address(),
                'lulus' => 0,
                'ijazah' => ''
            ];

            $this->db->table('data_siswa')->insert($data);
        }
    }
}
