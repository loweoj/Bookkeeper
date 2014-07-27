<?php  namespace tests\Bookkeeper\Transformer;

use Mockery as M;

class TransactionTransformerTest extends \TestCase {

    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {
        M::close();
    }

    public function test_transformer_creates_transactions_and_returns_array()
    {
        $constructorArgs = [M::mock('\Bookkeeper\Transformer\Rules\RuleManager')->shouldIgnoreMissing()];
        $transformer = M::mock('\Bookkeeper\Transformer\AbstractTransactionTransformer', $constructorArgs)->makePartial();

        $transformer->shouldReceive('getTransactionModel')
            ->once()
            ->andReturn(M::mock('Illuminate\Database\Eloquent\Model'));

        $data = [new \stdClass];

        $this->assertInternalType('array', $transformer->transform($data));
    }

    public function test_transformer_runs_rules_on_transaction()
    {
        $ruleManager = M::mock('\Bookkeeper\Transformer\Rules\RuleManager');
        $transformer = M::mock('\Bookkeeper\Transformer\AbstractTransactionTransformer', [$ruleManager])->makePartial();

        $transformer->shouldReceive('getTransactionModel')
            ->once()
            ->andReturn(M::mock('Illuminate\Database\Eloquent\Model'));

        $ruleManager->shouldReceive('run')->once();

        $transformer->transform([new \stdclass]);
    }
}