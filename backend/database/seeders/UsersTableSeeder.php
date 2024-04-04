<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

require_once 'vendor/autoload.php';

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::truncate();

        $faker = \Faker\Factory::create();

        $password = bcrypt('12345678');
        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => $password,
            'phone' => $faker->phoneNumber(),
            'location' => $faker->sentence,
            'picture' => $faker->sentence,
            'instagram' => $faker->url(),
            'facebook' => $faker->url(),
            'twitter' => $faker->url(),
            'telegram' => $faker->url(),
        ]);

        for ($i = 0; $i < 10; $i++) {
            User::create([
                'name' => $faker->name,
                'email' => $faker->email,
                'password' => $password,
                'phone' => $faker->phoneNumber(),
                'location' => $faker->sentence,
                'picture' => $faker->sentence,
                'instagram' => $faker->url(),
                'facebook' => $faker->url(),
                'twitter' => $faker->url(),
                'telegram' => $faker->url(),
            ]);
        }
    }
}
