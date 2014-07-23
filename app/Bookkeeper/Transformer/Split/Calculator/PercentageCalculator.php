<?php  namespace Bookkeeper\Transformer\Split\Calculator;

class PercentageCalculator implements CalculatorInterface
{
    /**
     * The total we were sent in the new Calculator
     *
     * @var
     */
    protected $expectedTotal;

    /**
     * The total at any given current state.
     *
     * @var int
     */
    protected $currentTotal = 0;

    /**
     * @var
     */
    protected $expectedNumberOfPercentages;

    /**
     * @var array
     */
    protected $seenPercentageAmounts = [];

    /**
     *
     *
     * @param $percentage
     * @param $total
     * @return string
     */
    public function calculate($percentage, $total)
    {
        // Get the percentage amount
        $percentage = $this->applyPercentage($percentage, $total);

        // Update current total
        $this->currentTotal = bcadd($this->currentTotal, $percentage, 2);

        // Add this percentage onto the seen list
        $this->seenPercentageAmounts[] = $percentage;

        // If we have seen all expected amounts, the  we
        // calculate the remainder and add it onto the last
        // percentage. This ensures the individual splits
        // total the initial amount that we recieved.
        if (count($this->seenPercentageAmounts) == (int)$this->expectedNumberOfPercentages) {
            $remainder = $this->calculateRemainder();
            $percentage = bcadd($percentage, $remainder, 2);
        }

        return $percentage;
    }

    /**
     * Do the percentage calculation rounded down
     * to 2 decimal places.
     *
     * @param $percentage
     * @param $operand
     * @return string
     */
    public function applyPercentage($percentage, $operand)
    {
        $percent = ($percentage * $operand) / 100;

        return number_format(floor($percent * 100) / 100, 2);
    }

    /**
     * Calculate the remainder between expected
     * total and current total
     *
     * @return string
     */
    public function calculateRemainder()
    {
        return bcsub($this->expectedTotal, $this->currentTotal, 2);
    }

    /**
     * Start a new calculation.
     *
     * Sets the total amount we expect and the number
     * of percentage values, or splits that we expect.
     *
     * Resets the object properties
     *
     * @param $total
     * @param $numberOfPercentages
     * @return void
     */
    public function newCalculation($total, $numberOfPercentages)
    {
        // Apply expectations
        $this->expectedTotal = $total;
        $this->expectedNumberOfPercentages = $numberOfPercentages;

        // Reset increments
        $this->currentTotal = 0;
        $this->seenPercentageAmounts = [];
    }

    /**
     * Returns the current total
     *
     * @return int
     */
    public function getCurrentTotal()
    {
        return $this->currentTotal;
    }
}