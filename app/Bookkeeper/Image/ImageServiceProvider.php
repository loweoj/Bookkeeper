<?php  namespace Bookkeeper\Image;

use Illuminate\Support\ServiceProvider;

class ImageServiceProvider extends ServiceProvider {

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $app = $this->app;

        /**
         * Image
         */
        $app->bind('Bookkeeper\Image\Image', function ($app) {
            return new Image(
                $app->make('files')
            );
        });
    }
}