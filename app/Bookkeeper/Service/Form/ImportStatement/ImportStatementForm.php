<?php  namespace Bookkeeper\Service\Form\ImportStatement;

use Bookkeeper\Service\Form\AbstractValidableForm;
use Bookkeeper\Service\Validation\ValidableInterface;

class ImportStatementForm extends AbstractValidableForm {

    /**
     * @var
     */
    protected $validator;

    public function __construct(ValidableInterface $validator)
    {
        $this->validator = $validator;
    }

    public function isValid($input)
    {
        return $this->valid($input);
    }

    public function import($input)
    {
        // valid() adds validation error message.
        return $this->valid($input);
    }
}