<?php  namespace Bookkeeper\Service\Form;

use Bookkeeper\Service\Validation\ValidableInterface;

abstract class AbstractValidableForm {

    /**
     * @param ValidableInterface $validator
     */
    public function __construct(ValidableInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Return any validation errors
     *
     * @return array
     */
    public function errors()
    {
        return $this->validator->errors();
    }

    /**
     * Test if form validator passes
     *
     * @return boolean
     */
    protected function valid(array $input)
    {
        return $this->validator->with($input)->passes();
    }


} 