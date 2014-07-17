<?php

use Faker\Factory as Faker;

class CategoriesTableSeeder extends Seeder {

    public function run()
    {
        $faker = Faker::create();
        $code = 100;
        foreach( range(1, 20) as $i )
        {
            Category::create([
                'type' => $faker->randomElement(['income', 'expense']),
                'code' => $code + $i,
                'name' => ucwords( $faker->words(3, true) ),
                'description' => $faker->sentence()
            ]);
        }
    }

} 