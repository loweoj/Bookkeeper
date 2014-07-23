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

        Stream::truncate();
        Category::truncate();
        Rule::truncate();
        Statement::truncate();
        Transaction::truncate();
        Record::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1');

		Eloquent::unguard();

        $this->call('StreamsTableSeeder');
        $this->call('CategoriesTableSeeder');
        $this->call('RulesTableSeeder');
        $this->call('StatementsTableSeeder');
        $this->call('TransactionsTableSeeder');
        $this->call('RecordsTableSeeder');
	}

}
