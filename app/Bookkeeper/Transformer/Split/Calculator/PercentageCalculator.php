<?php  namespace Bookkeeper\Transformer\Split;

use Bookkeeper\Transformer\Split\Calculator\CalculatorInterface;

class PercentageCalculator implements CalculatorInterface {

    private $seenPercentages = array();

    /**
     *
     * @param $total
     * @param $percentage
     */
    public function calculate($total, $percentage)
    {

    }

    private function percent($num_amount, $num_total) {
        $count1 = $num_amount / $num_total;
        $count2 = $count1 * 100;
        echo $count;
    }

}