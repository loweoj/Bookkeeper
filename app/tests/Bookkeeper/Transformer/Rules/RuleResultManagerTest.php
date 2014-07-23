<?php namespace Bookkeeper\Transformer\Rules;

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
        $this->mockSplitManager = M::mock('Bookkeeper\Transformer\Split\SplitManager');
        $this->resultManager = new RuleResultManager($this->mockSplitManager);
    }

    public function tearDown()
    {
        M::close();
    }

    public function test_run_results_converts_payee_field()
    {
        // Mock a rule with just the relevant info (to_xxx)
        $ruleArray = [
            'title'          => 'Match O2',
            'conditionType'  => 'any',
            'to_payee'       => 'O2 Mobile - CHANGED BY TEST RULE',
            'to_category'    => '',
            'to_stream'      => '',
            'to_description' => '',
            'splitJson'      => '',
        ];

        $transactionMock = M::mock();
        $transactionMock->payee = 'OLD PAYEE';
        $transactionMock->description = '';
        $transactionMock->amount = '50.00';
        $transactionMock->date = '2014-05-05 15:16:30';

        $ResultManager = new RuleResultManager($this->mockSplitManager);
        $newTransaction = $ResultManager->runResults($transactionMock, $ruleArray);

        $this->assertEquals($newTransaction->payee, 'O2 Mobile - CHANGED BY TEST RULE');
    }

    public function test_run_results_converts_multiple_fields()
    {
        $transactionMock = M::mock();
        $transactionMock->payee = 'OLD PAYEE';
        $transactionMock->description = 'OLD DESCRIPTION';
        $transactionMock->amount = '50.00';
        $transactionMock->category = 0;
        $transactionMock->date = '2014-05-05 15:16:30';

        // Mock the dbRule object with two conditions
        $ruleArray = [
            'title'          => 'Match O2',
            'conditionType'  => 'any',
            'to_payee'       => 'O2 Mobile - NEW PAYEE',
            'to_category'    => 4,
            'to_stream'      => '',
            'to_description' => 'NEW DESCRIPTION',
            'splitJson'      => '',
        ];

        $ResultManager = new RuleResultManager($this->mockSplitManager);
        $newTransaction = $ResultManager->runResults($transactionMock, $ruleArray);

        $this->assertEquals($newTransaction->payee, 'O2 Mobile - NEW PAYEE');
        $this->assertEquals($newTransaction->description, 'NEW DESCRIPTION');
        $this->assertEquals($newTransaction->category, 4);
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

        $transactionMock = M::mock();

        // Mock the rule with some simulated json_decoded data
        $ruleArray = [
            'splitJson'      => array(new stdClass()),
        ];

        $ResultManager = new RuleResultManager($mock);
        $ResultManager->runResults($transactionMock, $ruleArray);
    }
}
