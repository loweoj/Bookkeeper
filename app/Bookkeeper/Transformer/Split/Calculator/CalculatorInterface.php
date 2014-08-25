<?php

namespace Bookkeeper\Transformer\Split\Calculator;

interface CalculatorInterface {

    /**
     * Perform the calculation
     *
     * @param $operand
     * @param $modifier
     * @return mixed
     */
    public function calculate($operand, $modifier);

    /**
     * Do any neccessary preparatory work on the calculator object
     * @param $totalAmount
     * @param $numberOfSplits
     * @return mixed
     */
    public function newCalculation($totalAmount, $numberOfSplits);
} 