<?php namespace Bookkeeper\Import\Parser;

interface ImportParserInterface {

    /**
     * Load data from file into PHP objects/arrays
     *
     * @param string $filePath
     * @return mixed
     */
    public function parse($filePath = '');

} 