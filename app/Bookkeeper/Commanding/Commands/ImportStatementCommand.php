<?php namespace Bookkeeper\Commanding\Commands;

class ImportStatementCommand {

    public $accountData;

    public function __construct($data)
    {
        $this->accountData = $data;
    }
}