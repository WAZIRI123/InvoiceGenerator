<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $user = User::create([
            'name'          => 'super-admin',
            'email'         => 'super-admin@demo.com', 
            'password'      => bcrypt('12345678'),
            'email_verified_at' => now(),
            'created_at'    => date("Y-m-d H:i:s")
        ]);
    }
}
