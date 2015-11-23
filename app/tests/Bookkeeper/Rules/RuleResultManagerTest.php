<?php namespace Bookkeeper\Rules;

use Mockery as M;
use stdClass;

class RuleResultManagerTest extends \TestCase
{

    protected $fullClassName;
    protected $conditionManager;
    protected $mockSplitManager;

    public function setUp()
    {
        parent::setUp();
        $this->mockSplitManager = M::mock('Bookkeeper\Rules\Split\SplitManager');
        $this->resultManager = new RuleResultManager($this->mockSplitManager);
    }

    public function tearDown()
    {
        M::close();
    }

    /**
     * Get a mock of a
     * @param $data
     * @return M\MockInterface
     */
    protected function getEloquentArrayMock($data)
    {
        $m = M::mock();
        $m->shouldReceive('toArray')->zeroOrMoreTimes()->andReturn($data);
        foreach($data as $k => $v)
        {
            $m->{$k} = $v;
        }
        return $m;
    }

    public function test_run_results_converts_payee_field()
    {
        // Mock a rule with just the relevant info (to_xxx)
        $rule = [
            'title'          => 'Match O2',
            'conditionType'  => 'any',
            'to_payee'       => 'O2 Mobile - CHANGED BY TEST RULE',
            'to_category'    => '',
            'to_stream'      => '',
            'to_description' => '',
            'splitJson'      => '',
        ];

        $transaction = [];
        $transaction['payee'] = 'OLD PAYEE';
        $transaction['description'] = '';
        $transaction['amount'] = '50.00';
        $transaction['date'] = '2014-05-05 15:16:30';

        $ResultManager = new RuleResultManager($this->mockSplitManager);
        $newTransaction = $ResultManager->runResults($transaction, $rule);

        $this->assertEquals('O2 Mobile - CHANGED BY TEST RULE', $newTransaction['payee']);
    }

    public function test_run_results_converts_multiple_fields()
    {
        $transaction = array();
        $transaction['payee'] = 'OLD PAYEE';
        $transaction['description'] = 'OLD DESCRIPTION';
        $transaction['amount'] = '50.00';
        $transaction['category'] = 0;
        $transaction['date'] = '2014-05-05 15:16:30';

        // Mock the dbRule object with two conditions
        $rule = [
            'title'          => 'Match O2',
            'conditionType'  => 'any',
            'to_payee'       => 'O2 Mobile - NEW PAYEE',
            'to_category'    => 4,
            'to_stream'      => '',
            'to_description' => 'NEW DESCRIPTION',
            'splitJson'      => '',
        ];

        $ResultManager = new RuleResultManager($this->mockSplitManager);
        $newTransaction = $ResultManager->runResults($transaction, $rule);

        $this->assertEquals($newTransaction['payee'], 'O2 Mobile - NEW PAYEE');
        $this->assertEquals($newTransaction['description'], 'NEW DESCRIPTION');
        $this->assertEquals($newTransaction['category'], 4);
    }

    public function test_calls_split_manager_if_split_json()
    {
        $mock = $this->mockSplitManager;
        $mock->shouldReceive('splitTransaction')
            ->once()
            ->andReturn(
                [
                    ['name' => 'transaction1'],
                    ['name' => 'transaction2']
                ]
            );

        $transactionMock = array();

        // Mock the rule with some simulated json_decoded data
        $rule = [
            'splitJson'      => [new stdClass()],
        ];

        $ResultManager = new RuleResultManager($mock);
        $ResultManager->runResults($transactionMock, $rule);
    }
}
