<?php namespace Bookkeeper\Transformer\Rules;

use \Mockery as M;

class RuleConditionManagerTest extends \TestCase {

    protected $fullClassName;
    protected $conditionManager;

    public function setUp()
    {
        parent::setUp();
        $mockFactory = M::mock('Bookkeeper\Transformer\Conditions\ConditionFactory');
        $this->conditionManager = new RuleConditionManager($mockFactory);
        $this->fullClassName = 'Bookkeeper\Transformer\Rules\RuleConditionManager';
    }

    public function tearDown()
    {
        M::close();
    }

    public function test_get_conditions_results_creates_array_of_booleans()
    {
        // Mock the condition class
        $mockCondition = M::mock(['test' => true]);

        // Mock the factory class
        $mockFactory = M::mock('Bookkeeper\Transformer\Conditions\ConditionFactory');
        $mockFactory->shouldReceive('make')
            ->times(2)
            ->andReturn($mockCondition);

        // Mock the dbRule object with two conditions
        $dbRule= M::mock();

        // encode and decode to produce a stdClass
        $dbRule->conditions = json_decode( json_encode([
            [
                'field' => 'payee',
                'match' => 'contains',
                'value' => 'anything'
            ],
            [
                'field' => 'payee',
                'match' => 'contains',
                'value' => 'anything'
            ]
        ]));

        // Mock the transaction object with a payee field
        $transaction = M::mock();
        $transaction->payee = 'something';

        $method = new \ReflectionMethod($this->fullClassName, 'getConditionResults');
        $method->setAccessible(true);

        $this->assertEquals($method->invoke(new RuleConditionManager($mockFactory), $transaction, $dbRule), [true, true]);
    }


    /**
     * All / Any Condition tests
     */
    public function testAllConditionsShouldReturnTrueIfAllItemsAreTrue()
	{
        $method = new \ReflectionMethod($this->fullClassName, 'allConditions');
        $method->setAccessible(true);

        $testConditionResults = [true, true, true];

        $this->assertTrue($method->invoke($this->conditionManager, $testConditionResults));
	}

    public function test_all_conditions_should_return_false_if_one_or_more_items_are_false()
	{
        $method = new \ReflectionMethod($this->fullClassName, 'allConditions');
        $method->setAccessible(true);
        $testConditionResults = [false, true, true];
        $this->assertFalse($method->invoke($this->conditionManager, $testConditionResults));
	}

    public function test_any_conditions_should_return_true_if_one_or_more_items_are_true()
    {
        $method = new \ReflectionMethod($this->fullClassName, 'anyConditions');
        $method->setAccessible(true);
        $testConditionResults = [false, false, true];
        $this->assertTrue($method->invoke($this->conditionManager, $testConditionResults));
    }

    public function test_any_conditions_should_return_false_if_no_items_are_true()
    {
        $method = new \ReflectionMethod($this->fullClassName, 'anyConditions');
        $method->setAccessible(true);
        $testConditionResults = [false, false, false];
        $this->assertFalse($method->invoke($this->conditionManager, $testConditionResults));
    }

}
