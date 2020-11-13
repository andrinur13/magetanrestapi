<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PrestasiSeeder extends Seeder
{

    public function run()
    {

        $faker = \Faker\Factory::create();

        for($i=0; $i<80; $i++) {
            $data = [
                'id_data_siswa' => $faker->randomElement([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]),
                'tingkat' => $faker->randomElement([1, 2, 3, 4, 5, 6]),
                'penyelenggara' => $faker->company(),
                'nama_kegiatan' => $faker->sentence(6),
                'hasil' => $faker->randomElement(['Juara 1', 'Juara 2', 'Juara 3', 'Harapan 1', 'Harapan 2', 'Finalis']),
                'tgl_kegiatan' => $faker->randomElement(['2015-02-01', '2016-02-01', '2017-02-01', '2018-02-01', '2019-02-01', '2020-02-01']),
                'foto_kegiatan' => $faker->unixTime($min = '2015-01-01') . ".jpg",
                'piagam' => ''
            ];

            $this->db->table('prestasi')->insert($data);
        }


        // $data = [
        //     [
        //         'id_data_siswa' => 2,
        //         'tingkat' => 4,
        //         'penyelenggara' => 'Kementrian Riset Teknologi dan Pendidikan Tinggi',
        //         'nama_kegiatan' => 'Hackathon Covid-19 Apps',
        //         'hasil' => 'Juara 2',
        //         'tgl_kegiatan' => '2019-06-03',
        //         'foto_kegiatan' => '001244342.jpg',
        //         'piagam' => ''
        //     ],
        //     [
        //         'id_data_siswa' => 27,
        //         'tingkat' => 5,
        //         'penyelenggara' => 'Wuhan University',
        //         'nama_kegiatan' => 'Robotic Contest',
        //         'hasil' => 'Juara Harapan 1',
        //         'tgl_kegiatan' => '2019-05-01',
        //         'foto_kegiatan' => '001243553.jpg',
        //         'piagam' => ''
        //     ]
        // ];

        // $this->db->table('prestasi')->insertBatch($data);
    }
}
