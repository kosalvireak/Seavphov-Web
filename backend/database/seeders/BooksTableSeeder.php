<?php

namespace Database\Seeders;

use App\Models\Book;
use BookCategory;
use BookCondition;
use BookImage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

require_once  "BookCondition.php";
require_once  "BookImage.php";
require_once  "BookCategory.php";
require_once 'vendor/autoload.php';



class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Book::truncate();

        $bookCondition = new BookCondition;
        $bookCategory = new BookCategory;
        $bookImage = new BookImage;
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 40; $i++) {
            Book::create([
                'title' => $faker->sentence,
                'author' => $faker->name,
                'condition' => $bookCondition->getCondition(),
                'categories' =>  $bookCategory->getCategory(),
                'images' => $bookImage->getImageUrl(),
                'descriptions' => $faker->sentence(300),
                'availability' => 1,
                'owner_id' => rand(1, 5)
            ]);
        }
    }
}
