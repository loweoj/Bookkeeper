<?php  namespace Bookkeeper\Import;

use Bookkeeper\Import\Parser\CsvParser;
use Bookkeeper\Import\Parser\OfxParser;
use Bookkeeper\Import\Transformer\CsvTransformer;
use Bookkeeper\Import\Transformer\OfxTransformer;
use Illuminate\Support\ServiceProvider;

class ImportServiceProvider extends ServiceProvider {

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $app = $this->app;

        /**
         * OFX Parser
         */
        $app->bind('Bookkeeper\Import\Parser\OfxParser', function ($app) {
            return new OfxParser(
                new \OfxParser\Parser
            );
        });

        /**
         * CSV Parser
         */
        $app->bind('Bookkeeper\Import\Parser\CsvParser', function ($app) {
            return new CsvParser();
        });


        /**
         * OFX Transformer
         */
        $app->bind('Bookkeeper\Import\Transformer\OfxTransformer', function ($app) {
            return new OfxTransformer;
        });


        /**
         * CSV Transformer
         */
        $app->bind('Bookkeeper\Import\Transformer\CsvTransformer', function ($app) {
            return new CsvTransformer;
        });
    }
} 