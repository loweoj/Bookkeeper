<?php namespace Bookkeeper\Commanding\Commands;

class ImportStatementCommand {

    private $importFile;

    public function __construct($importFile)
    {
        $this->importFile = $importFile;
    }
}