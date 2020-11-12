<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DataSiswaSeeder extends Seeder
{

    public function run()
    {
        $faker = \Faker\Factory::create();

        for($i = 0; $i < 30; $i++)
        {
            $data = [
                'nisn' => $faker->randomNumber(6),
                'nik' => $faker->randomNumber(9),
                'nama' => $faker->name(),
                'jenis_kelamin' => $faker->randomElement(['1', '2']),
                'kelas' => $faker->randomElement(['10', '11', '12']),
                'jurusan' => $faker->randomElement(['IPA', 'IPS']),
                'tahun_lulus' => $faker->randomElement(['2017', '2018', '2019']),
                'tgl_lahir' => $faker->date('Y-m-d', '2004-12-31'),
                'alamat' => $faker->address(),
                'lulus' => 0,
                'skhu' => 'skhu.pdf',
                'ijazah' => ''
            ];

            $this->db->table('data_siswa')->insert($data);
        }
    }
}
