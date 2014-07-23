<?php  namespace Bookkeeper\Service\Form;

use Bookkeeper\Service\Validation\ValidableInterface;
use Illuminate\Mail\Message;
use Illuminate\Support\MessageBag;

abstract class AbstractValidableForm {

    protected $messageBag;

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
        if( $this->validator->errors() )
            return $this->validator->errors();

        if( ! isset($this->messageBag) )
            $this->messageBag = new MessageBag;

        return $this->messageBag;
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