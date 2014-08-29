<?php

use Faker\Factory as Faker;

class BankAccountsTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

		foreach(range(1, 2) as $index)
		{
			BankAccount::create([
                'name' => $faker->name(),
                'account_number' => $faker->randomNumber(8),
                'sort_code' => $faker->randomNumber(2) . '-' . $faker->randomNumber(2) . '-' . $faker->randomNumber(2),
			]);
		}
	}

}