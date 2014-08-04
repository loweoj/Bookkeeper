<?php

use Faker\Factory as Faker;

class RecordsTableSeeder extends Seeder {

    public function run()
    {
        $faker = Faker::create();

        $category_ids = Category::lists('id');
        $transaction_ids = Transaction::lists('id');
        $stream_ids = Stream::lists('id');

        foreach( range(1, 20) as $index )
        {
            $defaultFields = [
                'date' => $faker->dateTimeBetween('-1 month', 'now')->format('d/m/Y'),
                'payee' => $faker->name,
                'description' => $faker->sentence(),
                'transaction_id' => $faker->randomElement($transaction_ids),
                'category_id' => $faker->randomElement($category_ids),
                'stream_id' => $faker->randomElement($stream_ids)
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
        $return  = [];
        $return['type'] = $faker->randomElement(['income','expense']);
        $return['amount'] = $faker->randomFloat(2, 3, 500);
        if( $return['type'] == 'expense' ) {
            $return['amount'] = -1 * abs($return['amount']);
        }

        return $return;

//        $recordTypes = ['income', 'expense'];
//        $type = $faker->randomElement($recordTypes);
//
//        $return = [];
//        foreach ($recordTypes as $fieldName) {
//            if ($fieldName == $type)
//            {
//                $return[$fieldName] = $faker->randomFloat(2, 3, 500);
//                continue;
//            }
//            $return[$fieldName] = null;
//        }
//        dd($return);
//        return $return;
    }
}