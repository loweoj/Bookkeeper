<?php  namespace Bookkeeper\Service\Form;

use Bookkeeper\Service\Form\ImportStatement\ImportStatementForm;
use Bookkeeper\Service\Form\ImportStatement\ImportStatementLaravelValidator;
use Bookkeeper\Service\Form\UploadAttachment\UploadAttachmentForm;
use Bookkeeper\Service\Form\UploadAttachment\UploadAttachmentLaravelValidator;
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

        /**
         * TEMP Transformer Interface
         */
        $app->bind('Bookkeeper\Transformer\TransactionTransformerInterface', 'Bookkeeper\Transformer\OfxTransactionTransformer');

        /**
         * Import Statement Form
         */
        $app->bind('Bookkeeper\Service\Form\ImportStatement\ImportStatementForm', function ($app) {
            return new ImportStatementForm(
                $app->make('Bookkeeper\Transformer\TransactionTransformerInterface'),
                new \OfxParser\Parser(),
                new ImportStatementLaravelValidator($app['validator']),
                $app->make('Bookkeeper\Repo\Statement\StatementInterface')
            );
        });

        /**
         * Upload Attachment Form
         */
        $app->bind('Bookkeeper\Service\Form\UploadAttachment\UploadAttachmentForm', function ($app) {
            return new UploadAttachmentForm(
                new UploadAttachmentLaravelValidator($app['validator']),
                $app->make('Bookkeeper\Image\Image')
            );
        });
    }
}