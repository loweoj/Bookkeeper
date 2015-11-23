<?php namespace Bookkeeper\Rules\Split;

use Mockery as M;
use stdClass;

class SplitManagerTest extends \TestCase
{
    protected $calculatorMockName;
    protected $splitManager;
    protected $splitJsonData = '[
                {
                    "description":"Split Description One",
                    "category_id":1,
                    "stream_id":1,
                    "percentage":35
                },
                {
                    "description":"Split Description Two",
                    "category_id":2,
                    "stream_id":1,
                    "percentage":35
                },
                {
                    "description":"Split Description three",
                    "category_id":53,
                    "stream_id":3,
                    "percentage":30
                }]';

    public function setUp()
    {
        parent::setUp();
        $this->calculatorMockName = 'Bookkeeper\Rules\Split\Calculator\CalculatorInterface';

        $calculatorMock = M::mock($this->calculatorMockName);
        $calculatorMock->shouldReceive('newCalculation')->zeroOrMoreTimes();
        $calculatorMock->shouldReceive('calculate')->zeroOrMoreTimes();

        $this->splitManager = new SplitManager($calculatorMock);
    }

    public function tearDown()
    {
        M::close();
    }

    public function test_split_transaction_returns_array()
    {
        $transaction = array();
        $splitJson = [new stdClass];
        $this->assertInternalType('array', $this->splitManager->splitTransaction($transaction, $splitJson));
    }

    public function test_returns_new_transaction_for_each_split()
    {
        $transaction = array();
        $transaction['payee'] = 'Some Payee that Matches a rule and needs splitting';
        $transaction['description'] = 'OLD DESCRIPTION';
        $transaction['amount'] = '50.00';
        $transaction['category'] = 0;
        $transaction['stream'] = 0;
        $transaction['date'] = '2014-05-05 15:16:30';

        $splitJson = json_decode($this->splitJsonData);

        $transactions = $this->splitManager->splitTransaction($transaction, $splitJson);
        $this->assertCount(3, $transactions);
    }

    public function test_clones_transactions_and_modifies_with_split_data()
    {
        $transaction = array();
        $transaction['payee'] = 'Some Payee that Matches a rule and needs splitting';
        $transaction['description'] = 'OLD DESCRIPTION';
        $transaction['amount'] = '50.00';
        $transaction['category'] = 0;
        $transaction['stream'] = 0;
        $transaction['date'] = '2014-05-05 15:16:30';

        $splitJson = json_decode($this->splitJsonData);

        $transactions = $this->splitManager->splitTransaction($transaction, $splitJson);

        // Loop through the transactions
        foreach ($transactions as $i => $t) {
            // Loop through the expected changed fields from json
            foreach ($splitJson[$i] as $key => $val) {
                if (array_key_exists($key, $t)) {
                    $this->assertEquals($val, $t[$key]);
                }
            }
        }
    }

    public function test_applies_percentages_to_amount()
    {
        $transaction = [];
        $transaction['payee'] = 'Some Payee that Matches a rule and needs splitting';
        $transaction['description'] = 'OLD DESCRIPTION';
        $transaction['amount'] = '50.00';
        $transaction['category'] = 0;
        $transaction['stream'] = 0;
        $transaction['date'] = '2014-05-05 15:16:30';
        $splitJson = json_decode($this->splitJsonData);

        // Mock the percentage calculator to return 100 each time
        $percentageCalc = M::mock($this->calculatorMockName);
        $percentageCalc->shouldReceive('newCalculation')->once();
        $percentageCalc->shouldReceive('calculate')
                        ->times(3)
                        ->andReturn(100);

        $manager = new SplitManager($percentageCalc);
        $transactions = $manager->splitTransaction($transaction, $splitJson);

        // Loop through the transactions and test each transaction amount is 100!
        foreach ($transactions as $i => $t) {
            $this->assertEquals(100, $t['amount']);
        }
    }
}
