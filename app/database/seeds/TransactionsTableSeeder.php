<?php

use Faker\Factory as Faker;

class TransactionsTableSeeder extends Seeder {

    public function run()
    {
        $faker = Faker::create();

        $statement_ids = Statement::lists('id');
        $accountIds = BankAccount::lists('id');

        foreach (range(1, 20) as $i) {
            $statementID = $faker->randomElement($statement_ids);
            $statement = Statement::find($statementID);

            Transaction::create([
                'date'         => $faker->dateTimeBetween($statement->start_date, $statement->end_date)->format('Y-m-d H:i:s'),
                'payee'        => $faker->name,
                'description'  => $faker->sentence(),
                'amount'       => $faker->randomFloat(2, 3, 500),
                'statement_id' => $statementID,
                'account_id'   => $faker->randomElement($accountIds)
            ]);
        }
    }
}