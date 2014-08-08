<?php  namespace Bookkeeper\Service\Validation;

use Illuminate\Support\MessageBag;
use Illuminate\Validation\Factory;

abstract class AbstractLaravelValidator implements ValidableInterface {

    /**
     * Validator
     *
     * @var \Illuminate\Validation\Factory
     */
    protected $validator;

    /**
     * Validation data key => value array
     *
     * @var Array
     */
    protected $data = [];

    /**
     * Validation errors
     *
     * @var Array
     */
    protected $errors = [];

    /**
     * Validation rules
     *
     * @var Array
     */
    protected $rules = [];

    /**
     * Validation messages
     *
     * @var array
     */
    protected $messages = [];

    /**
     * Message bag if no errors
     * @var
     */
    protected $messageBag;

    public function __construct(Factory $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Set data to validate
     *
     * @return \Bookkeeper\Service\Validation\AbstractLaravelValidator
     */
    public function with(array $data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Validation passes or fails
     *
     * @return Boolean
     */
    public function passes()
    {
        $validator = $this->validator->make($this->data, $this->rules, $this->messages);
        if ($validator->fails()) {
            $this->errors()->merge($validator->messages());
            return false;
        }

        return true;
    }

    /**
     * Return errors, if any
     * Otherwise return an empty message bag.
     *
     * @return array
     */
    public function errors()
    {
        if ( ! empty($this->errors))
            return $this->errors;

        $this->errors = new MessageBag;

        return $this->errors;
    }
}