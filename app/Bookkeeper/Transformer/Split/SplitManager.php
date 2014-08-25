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

    /**
     * @param       $transaction
     * @param array $splitObjects  Array of objects to give each of the new "split" transactions (from splitJson)
     * @return array
     */
    public function splitTransaction($transaction, array $splitObjects)
    {
        // Prepare the return array
        $transactions = [];

        // Start a new percentage calculation and pass the total
        // amount and the total number of splits to expect
        if (isset($transaction->amount)) {
            $this->calculator->newCalculation($transaction->amount, count($splitObjects));
        }

        foreach ($splitObjects as $split) {
            // Clone the original transaction ready for modification
            $clone = clone $transaction;

            // Spin through and change the values on this clone
            $clone = $this->fillClone($transaction, $split, $clone);

            // Add the modified clone to the return array
            $transactions[] = $clone;

            // Remove the clone variable
            unset($clone);
        }

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

            // Calculate the percentage if required
            if ($key == 'percentage') {
                $amount = $this->calculator->calculate($transaction->amount, $val);
                $clone->amount = $amount;
                continue;
            }

            // Set the split's values on the clone
            $clone->$key = $val;
        }

        return $clone;
    }
}