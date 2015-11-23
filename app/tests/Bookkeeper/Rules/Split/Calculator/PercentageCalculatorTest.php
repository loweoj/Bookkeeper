<?php  namespace Bookkeeper\Rules\Split\Calculator;

use Bookkeeper\Rules\Split\Calculator\PercentageCalculator;
use Mockery as M;

class PercentageCalculatorTest extends \TestCase
{

    protected $fullClassName;
    protected $conditionManager;

    public function test_can_make_percentage()
    {
        $calculator = new PercentageCalculator;

        $this->assertEquals($calculator->applyPercentage(30, 100), 30);
    }

    public function test_rounds_percentage_down_to_two_decimals()
    {
        $calculator = new PercentageCalculator;

        // 15% of 100.15 = 15.0225 rounded down = 15.02
        $this->assertEquals($calculator->applyPercentage(15, 100.15), 15.02);
    }

    public function test_current_total_adds()
    {
        $calculator = new PercentageCalculator;
        $calculator->calculate(15, 100);
        $calculator->calculate(20, 100);
        $calculator->calculate(15, 100.15);

        // 15 + 20 + 15.02 = 50.02
        $this->assertEquals(50.02, $calculator->getCurrentTotal());
    }

    public function test_processed_amounts_add_up_to_total()
    {
        $calculator = new PercentageCalculator;
        $transactionTotal = 49.59;
        $calculator->newCalculation($transactionTotal, 3);

        $amounts = [];
        foreach ([15, 35, 50] as $percentage) {
            $amounts[] = $calculator->calculate($percentage, $transactionTotal);
        }
        $this->assertEquals(array_sum($amounts), $transactionTotal);
    }
}