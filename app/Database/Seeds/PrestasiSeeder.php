<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PrestasiSeeder extends Seeder
{

    public function run()
    {


        $data = [
            [
                'id_data_siswa' => 2,
                'tingkat' => 4,
                'penyelenggara' => 'Kementrian Riset Teknologi dan Pendidikan Tinggi',
                'nama_kegiatan' => 'Hackathon Covid-19 Apps',
                'hasil' => 'Juara 2',
                'piagam' => ''
            ],
            [
                'id_data_siswa' => 27,
                'tingkat' => 5,
                'penyelenggara' => 'Wuhan University',
                'nama_kegiatan' => 'Robotic Contest',
                'hasil' => 'Juara Harapan 1',
                'piagam' => ''
            ]
        ];

        $this->db->table('prestasi')->insertBatch($data);
    }
}
