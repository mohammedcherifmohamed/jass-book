<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // 1. Create some categories
        $categories = [
            ['name' => 'Fiction', 'image_path' => $faker->imageUrl(640, 480, 'books', true)],
            ['name' => 'Non-Fiction', 'image_path' => $faker->imageUrl(640, 480, 'books', true)],
            ['name' => 'Science', 'image_path' => $faker->imageUrl(640, 480, 'books', true)],
            ['name' => 'History', 'image_path' => $faker->imageUrl(640, 480, 'books', true)],
            ['name' => 'Biography', 'image_path' => $faker->imageUrl(640, 480, 'books', true)],
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'name'       => $category['name'],
                'image_path' => $category['image_path'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Get all category IDs to assign randomly
        $categoryIds = DB::table('categories')->pluck('id')->toArray();

        // 2. Create 30 books
        for ($i = 0; $i < 30; $i++) {
            DB::table('products')->insert([
                'category_id'  => $faker->randomElement($categoryIds),
                'title'        => $faker->sentence(3), // e.g. "The Great Adventure"
                'description'  => $faker->paragraphs(3, true),
                'author'       => $faker->name,
                'image_path'   => $faker->imageUrl(640, 480, 'books', true),
                'available'    => $faker->boolean(80), // 80% chance true
                'price'        => $faker->randomFloat(2, 5, 100),
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);
        }
    }
}