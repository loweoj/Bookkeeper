<?php  namespace Bookkeeper\Transformer;

use Bookkeeper\Transformer\Split\PercentageCalculator;
use Illuminate\Support\ServiceProvider;

class TransformerServiceProvider extends ServiceProvider {

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $app = $this->app;
        $app->bind('Bookkeeper\Transformer\Split\Calculator\CalculatorInterface', function($app)
        {
            return new PercentageCalculator();
        });
    }
}