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
         * Import Statement Form
         */
        $app->bind('Bookkeeper\Service\Form\ImportStatement\ImportStatementForm', function ($app) {
            return new ImportStatementForm(
                new ImportStatementLaravelValidator($app['validator'])
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