<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Enums\BookCondition;
use App\Enums\BookCategory;

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
                'condition' => BookCondition::random()->value,
                'categories' => BookCategory::random()->value,
                'images' => 'https://m.media-amazon.com/images/I/71QT4UeAHGL._AC_UF1000,1000_QL80_.jpg',
                'descriptions' => $faker->sentence,
                'availability' => $faker->boolean(33),
            ]);
        }
    }
}
