<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AboutUsSeeder extends Seeder
{

    public function run()
    {
        $faker = \Faker\Factory::create();

        for($i = 0; $i < 100; $i++)
        {
            $data = [
                'name' => $faker->name(),
                'email' => $faker->freeEmail(),
                'subject' => $faker->sentence(),
                'messages' => $faker->paragraph()
            ];

            $this->db->table('about_us')->insert($data);
        }
    }

}