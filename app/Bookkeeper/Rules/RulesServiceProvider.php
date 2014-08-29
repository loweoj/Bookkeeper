<?php  namespace Bookkeeper\Rules;

use Bookkeeper\Rules\Split\Calculator\PercentageCalculator;
use Illuminate\Support\ServiceProvider;

class RulesServiceProvider extends ServiceProvider {

    public function register()
    {
        $app = $this->app;
        $app->bind('Bookkeeper\Rules\Split\Calculator\CalculatorInterface', function($app)
        {
            return new PercentageCalculator;
        });
    }

}