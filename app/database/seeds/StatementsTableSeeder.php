<?php

use Faker\Factory as Faker;

class StatementsTableSeeder extends Seeder {

    public function run()
    {
        $faker = Faker::create();

        foreach( range(1, 2) as $i )
        {
            $start_date = $faker->dateTimeBetween('-5 years');
            Statement::create([
                'start_date' => $start_date->format('Y-m-d H:i:s'),
                'end_date' => $start_date->modify('+2 months')->format('Y-m-d H:i:s')
            ]);
        }
    }
}