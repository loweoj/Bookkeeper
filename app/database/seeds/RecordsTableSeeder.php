<?php

use Faker\Factory as Faker;

class RecordsTableSeeder extends Seeder {

    public function run()
    {
        $faker = Faker::create();

        $category_ids = Category::lists('id');
        $transaction_ids = Transaction::lists('id');

        foreach( range(1, 20) as $index )
        {
            $defaultFields = [
                'date' => $faker->dateTime()->format('Y-m-d H:i:s'),
                'payee' => $faker->name,
                'description' => $faker->sentence(),
                'transaction_id' => $faker->randomElement($transaction_ids),
                'category_id' => $faker->randomElement($category_ids)
            ];

            $moneyFields = $this->chooseRandomRecordType($faker);
            $fields = array_merge($defaultFields, $moneyFields);
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
        $moneyFields = ['money_in', 'money_out'];
        $moneyEl = $faker->randomElement($moneyFields);

        $return = [];
        foreach ($moneyFields as $fieldName) {
            if ($fieldName == $moneyEl)
            {
                $return[$fieldName] = $faker->randomFloat(2, 3, 500);
                continue;
            }
            $return[$fieldName] = null;
        }
        return $return;
    }
}