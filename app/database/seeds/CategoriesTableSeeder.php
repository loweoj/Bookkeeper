<?php

use Faker\Factory as Faker;

class CategoriesTableSeeder extends Seeder
{

    public function run()
    {
        $categories = include 'Fixtures/categories.php';

        foreach ($categories as $c) {
            Category::create([
                'type'        => $c['type'],
                'code'        => $c['code'],
                'name'        => $c['name'],
                'description' => $c['description']
            ]);
        }
    }

} 