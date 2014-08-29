<?php

use Faker\Factory as Faker;

class RecordsTableSeeder extends Seeder {

    public function run()
    {
        $faker = Faker::create();

        $transaction_ids = Transaction::lists('id');
        $stream_ids = Stream::lists('id');
        $account_ids = BankAccount::lists('id');

        foreach (range(1, 20) as $index) {
            $defaultFields = [
                'date'           => $faker->dateTimeBetween('-1 month', 'now')->format('d/m/Y'),
                'payee'          => $faker->name,
                'description'    => $faker->sentence(),
                'transaction_id' => $faker->randomElement($transaction_ids),
                'stream_id'      => $faker->randomElement($stream_ids),
                'account_id'     => $faker->randomElement($account_ids)
            ];

            $typeSpecificFields = $this->chooseRandomRecordType($faker);
            $fields = array_merge($defaultFields, $typeSpecificFields);
            Record::create($fields);
        }
    }

    /**
     * Assign a random amount to one of money_in or money_out
     *
     * @param $faker
     * @return array
     */
    protected function chooseRandomRecordType($faker)
    {
        $return = [];
        $return['type'] = $faker->randomElement(['income', 'expense']);
        $return['amount'] = $faker->randomFloat(2, 3, 500);

        if ($return['type'] == 'expense') {
            $return['amount'] = -1 * abs($return['amount']);
            $category_ids = Category::where('type', '=', 'expense')->lists('id');
        } else {
            $category_ids = Category::where('type', '=', 'income')->lists('id');
        }

        $return['category_id'] = $faker->randomElement($category_ids);

        return $return;
    }
}