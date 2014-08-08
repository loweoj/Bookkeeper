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
     * Return any validation errors or a new
     * MessageBag instance to send our own messages!
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

    /**
     * Add an arbitrary error message to the errors
     *
     * @param $key
     * @param $message
     * @return mixed
     */
    protected function addError($key, $message)
    {
        return $this->errors()->add($key, $message);
    }
}