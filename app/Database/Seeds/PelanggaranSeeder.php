<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PelanggaranSeeder extends Seeder
{

    public function run()
    {


        $data = [
            [
                'id_data_siswa' => 2,
                'jenis' => 2,
                'nama_pelanggaran' => 'Bolos Sekolah',
                'hukuman' => 'Menulis essay 100 lembar'
            ],
            [
                'id_data_siswa' => 23,
                'jenis' => 3,
                'nama_pelanggaran' => 'Knalpot Blombongan',
                'hukuman' => 'Mengganti knalpot'
            ]
        ];

        $this->db->table('pelanggaran')->insertBatch($data);
    }
}
