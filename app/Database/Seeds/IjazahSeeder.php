<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class IjazahSeeder extends Seeder
{

    public function run()
    {


        $data = [
            [
                'id_data_siswa' => 34,
                'link_ijazah' => 'uploads/ijazah/ijazah34.pdf'
            ],
            [
                'id_data_siswa' => 76,
                'link_ijazah' => 'uploads/ijazah/ijazah76.pdf'
            ]
        ];

        $this->db->table('ijazah')->insertBatch($data);
    }
}
