<?php  namespace Bookkeeper\Rules\Split;

use Bookkeeper\Rules\Split\Calculator\CalculatorInterface;

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
     * @param array $transaction
     * @param array $splitObjects
     * @return array
     */
    public function splitTransaction(array $transaction, array $splitObjects)
    {
        // Prepare the return array
        $transactions = [];

        // Start a new percentage calculation and pass the total
        // amount and the total number of splits to expect
        if (isset($transaction['amount'])) {
            $this->calculator->newCalculation($transaction['amount'], count($splitObjects));
        }

        foreach ($splitObjects as $split) {
            // Clone the original transaction ready for modification
            $clone = $transaction;

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
     * @param array $transaction
     * @param array $split
     * @param array $clone
     * @return array
     */
    protected function fillClone(array $transaction, $split, array $clone)
    {
        foreach ($split as $key => $val) {

            // Calculate the percentage if required
            if ($key == 'percentage') {
                $amount = $this->calculator->calculate($transaction['amount'], $val);
                $clone['amount'] = $amount;
                continue;
            }

            // Set the split's values on the clone
            $clone[$key] = $val;
        }

        return $clone;
    }
}