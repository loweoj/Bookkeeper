<?php  namespace Bookkeeper\Image;

use Config;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Image {

    /**
     * @var Filesystem
     */
    private $files;

    public function __construct(Filesystem $files)
    {
        $this->dimensions = $this->getDimensions();
        $this->files = $files;
    }

    /**
     * Move and uploaded file to local storage
     *
     * @param UploadedFile $file
     * @param null         $dir
     * @return bool|string
     */
    public function upload(UploadedFile $file, $dir = null)
    {
        if ( ! $dir) {
            return false;
        }
        $filename = $this->createUploadFilename($file);

        try {
            $uploadedFile = $file->move($dir, $filename);
        } catch (\Exception $e) {
            return false;
        }

        return $uploadedFile->getPathName();
    }

    /**
     * Create a thumbnail for a given filepath
     * and return the new thumb's path
     *
     * @param $filePath
     * @return string
     */
    public function createThumbnail($filePath)
    {
        $thumbnail = new File($filePath);

        if ($thumbnail->guessExtension() == 'pdf') {
            return $this->createPdfThumb($thumbnail, $this->dimensions['thumb']['width']);
        }

        return false;
    }

    /**
     * Create a PDF thumbnail using Imagick
     *
     * @param      $filepath
     * @param      $width
     * @param null $height
     * @param bool $crop
     * @return string
     */
    public function createPdfThumb($filepath, $width, $height = null, $crop = false)
    {
        if ( ! class_exists('Imagick')) {
            return false;
        }

        $Image = new \Imagick($filepath . '[0]');

        $Image->setImageFormat('jpg');

        if ($Image->getImageHeight() <= $Image->getImageWidth()) {
            $Image->thumbnailImage($width, 0);
        } else {
            $Image->thumbnailImage(0, $width);
        }

        $saveAs = dirname($filepath) . '/' . $this->getBasename($filepath) . '-thumb.jpg';

        $Image->writeImage($saveAs);

        $Image->destroy();

        return $saveAs;
    }

    /**
     * Return the filename without extension
     *
     * @param $filepath
     * @return string
     */
    public function getBasename($filepath)
    {
        return basename($filepath, '.' . $this->files->extension($filepath));
    }

    /**
     * Create a file name for upladed file
     *
     * @param UploadedFile $file
     * @return mixed
     */
    public function createUploadFilename(UploadedFile $file)
    {
        $basename = $this->getBasename($file->getClientOriginalName());
        $ext = $file->getClientOriginalExtension();

        // Create the filename
        $filename = $basename . '_' . sha1(time()) . '.' . $ext;

        // Clean whitespace in filename
        return preg_replace('/\s+/', '_', $filename);
    }

    /**
     * Get dimensions from configuration
     *
     * @return array
     */
    private function getDimensions()
    {
        $return = [];
        $dimensions = Config::get('image.dimensions');
        foreach ($dimensions as $key => $dimension) {
            $return[$key]['width'] = (int)$dimension[0];
            $return[$key]['height'] = isset($dimension[1]) ? (int)$dimension[1] : $return[$key]['width'];
            $return[$key]['crop'] = isset($dimension[2]) ? (bool)$dimension[2] : false;
            $return[$key]['quality'] = isset($dimension[3]) ? (int)$dimension[3] : Config::get('image.quality');
        }

        return $return;
    }

}