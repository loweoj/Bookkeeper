<?php  namespace Bookkeeper\Transformer\Split;


use Bookkeeper\Transformer\Split\Calculator\CalculatorInterface;

class SplitManager {

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

        // Start a new percentage calculation
        if( isset($transaction->amount) ) {
            $this->calculator->newCalculation($transaction->amount, count($splitObjects));
        }

        foreach( $splitObjects as $split )
        {
            $clone = clone $transaction;
            // Spin through and change the values on this clone
            foreach( $split as $key => $val ) {

                if( $key == 'percentage' ) {
                    $amount = $this->calculator->calculate($transaction->amount, $val);
                    $clone->amount = $amount;
                    continue;
                }

                // Set the value on clone
                $clone->$key = $val;
            }
            $transactions[] = $clone;
            unset($clone);
        }
        return $transactions;
    }

} 