<?php  namespace Bookkeeper\Facades;

use Illuminate\Filesystem\Filesystem as BaseFilesystem;

class Filesystem extends BaseFilesystem {

    /**
     * Get a file MIME type by extension.
     *
     * <code>
     *		// Determine the MIME type for the .tar extension
     *		$mime = File::mime('tar');
     *
     *		// Return a default value if the MIME can't be determined
     *		$mime = File::mime('ext', 'application/octet-stream');
     * </code>
     *
     * @param  string  $extension
     * @param  string  $default
     * @return string
     */
    public function mime($extension, $default = 'application/octet-stream')
    {
        $mimes = Config::get('mimes');

        if ( ! array_key_exists($extension, $mimes)) return $default;

        return (is_array($mimes[$extension])) ? $mimes[$extension][0] : $mimes[$extension];
    }

    /**
     * Determine if a file is of a given type.
     *
     * The Fileinfo PHP extension is used to determine the file's MIME type.
     *
     * <code>
     *		// Determine if a file is a JPG image
     *		$jpg = File::is('jpg', 'path/to/file.jpg');
     *
     *		// Determine if a file is one of a given list of types
     *		$image = File::is(array('jpg', 'png', 'gif'), 'path/to/file');
     * </code>
     *
     * @param  array|string  $extensions
     * @param  string        $path
     * @return bool
     */
    public function is($extensions, $path)
    {
        $mimes = Config::get('mimes');

        $mime = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $path);

        // The MIME configuration file contains an array of file extensions and
        // their associated MIME types. We will loop through each extension the
        // developer wants to check and look for the MIME type.
        foreach ((array) $extensions as $extension)
        {
            if (isset($mimes[$extension]) and in_array($mime, (array) $mimes[$extension]))
            {
                return true;
            }
        }

        return false;
    }

} 