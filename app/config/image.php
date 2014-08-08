<?php

/*
|--------------------------------------------------------------------------
| Image Configuration
|--------------------------------------------------------------------------
*/
return [

   /**
     * This is the default upload directory for all user uploaded files
     * Be sure to keep trailing slash!
     *
     */

    'upload_dir' => base_path() . '/user_uploads/',


    /**
     * Default Quality
     */

    'quality'     => 85,


    /**
     * Dimensions
     * width, height, crop, quality
     */

    'dimensions' => [
        'thumb' => [200]
    ]


];
