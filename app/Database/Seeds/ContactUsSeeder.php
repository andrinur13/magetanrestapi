<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ContactUsSeeder extends Seeder
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

            $this->db->table('contact_us')->insert($data);
        }
    }

}