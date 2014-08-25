<?php  namespace Bookkeeper\Transformer;

use Bookkeeper\Transformer\Split\Calculator\PercentageCalculator;
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

        /**
         * TEMP Transformer Interface
         */
        $app->bind('Bookkeeper\Transformer\TransactionTransformerInterface', 'Bookkeeper\Transformer\OfxTransactionTransformer');
    }
}