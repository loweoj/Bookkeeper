<?php  namespace Bookkeeper\Import;

use Bookkeeper\Import\Parser\CsvParser;
use Bookkeeper\Import\Parser\OfxParser;
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
         * Import Statement Form
         */
        $app->bind('Bookkeeper\Import\Parser\OfxParser', function ($app) {
            return new OfxParser(
                new \OfxParser\Parser
            );
        });

        /**
         * Upload Attachment Form
         */
        $app->bind('Bookkeeper\Import\Parser\CsvParser', function ($app) {
            return new CsvParser();
        });
    }
} 