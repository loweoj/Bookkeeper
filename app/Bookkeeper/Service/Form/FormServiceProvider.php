<?php  namespace Bookkeeper\Service\Form;

use Bookkeeper\Service\Form\ImportStatement\ImportStatementForm;
use Bookkeeper\Service\Form\ImportStatement\ImportStatementLaravelValidator;
use Illuminate\Support\ServiceProvider;

class FormServiceProvider extends ServiceProvider {

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $app = $this->app;
        $app->bind('Bookkeeper\Service\Form\ImportStatement\ImportStatementForm', function($app)
        {
            return new ImportStatementForm(
                $app->make('Bookkeeper\Transformer\TransactionTransformer'),
                new \OfxParser\Parser(),
                new ImportStatementLaravelValidator( $app['validator'] ),
                $app->make('Bookkeeper\Repo\Statement\StatementInterface')
            );
        });
    }
}