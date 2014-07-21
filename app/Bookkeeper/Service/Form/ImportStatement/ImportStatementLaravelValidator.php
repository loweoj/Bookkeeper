<?php  namespace Bookkeeper\Service\Form\ImportStatement;

use Bookkeeper\Service\Validation\AbstractLaravelValidator;

class ImportStatementLaravelValidator extends AbstractLaravelValidator {

    protected $rules = [
        'file' => 'required',
    ];
} 