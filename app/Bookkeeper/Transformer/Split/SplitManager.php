<?php  namespace Bookkeeper\Transformer\Split;

use Bookkeeper\Transformer\Split\Calculator\CalculatorInterface;

class SplitManager
{

    /**
     * @var CalculatorInterface
     */
    private $calculator;

    public function __construct(CalculatorInterface $calculator)
    {
        $this->calculator = $calculator;
    }

    public function splitTransaction($transaction, array $splitObjects)
    {
        $transactions = [];

//        if( isset($transaction->splits) )
//        {
//
//        }

        // Start a new percentage calculation
        if (isset($transaction->amount)) {
            $this->calculator->newCalculation($transaction->amount, count($splitObjects));
        }

        foreach ($splitObjects as $split) {
            $clone = clone $transaction;
            // Spin through and change the values on this clone
            $clone = $this->fillClone($transaction, $split, $clone);
            $transactions[] = $clone;
            unset($clone);
        }

        // $transaction->splits = $transactions;
        return $transactions;
    }

    /**
     * @param $transaction
     * @param $split
     * @param $clone
     */
    protected function fillClone($transaction, $split, $clone)
    {
        foreach ($split as $key => $val) {

            if ($key == 'percentage') {
                $amount = $this->calculator->calculate($transaction->amount, $val);
                $clone->amount = $amount;
                continue;
            }

            // Set the value on clone
            $clone->$key = $val;
        }

        return $clone;
    }
}