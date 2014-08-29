<?php  namespace Bookkeeper\Import\Parser;

use OfxParser\Parser;

class OfxParser implements ImportParserInterface {

    protected $ofxParser;

    public function __construct(Parser $parser)
    {
        $this->ofxParser = $parser;
    }

    /**
     * Load data from file into PHP objects/arrays
     *
     * @param string $filePath
     * @return mixed
     */
    public function parse($filePath = '')
    {
        if ( ! $filePath || $filePath == '') {
            throw new \InvalidArgumentException('Filepath should not be empty');
        }

        return $this->ofxParser->loadFromFile($filePath);
    }
}