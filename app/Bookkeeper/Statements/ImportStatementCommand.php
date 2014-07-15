<?php

namespace Bookkeeper\Statements;

class ImportStatementCommand {

    public $file;

    public function __construct($file)
    {
        $this->file = $file;
    }

}
