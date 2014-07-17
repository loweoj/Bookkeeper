<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        Category::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1');

		Eloquent::unguard();

        $this->call('CategoriesTableSeeder');
	}

}
