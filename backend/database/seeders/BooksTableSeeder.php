<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

require_once 'vendor/autoload.php';


class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Book::truncate();

        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 10; $i++) {
            Book::create([
                'title' => $faker->sentence,
                'author' => $faker->name,
                'condition' => $faker->sentence,
                'categories' => $faker->sentence,
                'images' => $faker->sentence,
                'descriptions' => $faker->sentence,
                'availability' => $faker->boolean(33),
            ]);
        }
    }
}
