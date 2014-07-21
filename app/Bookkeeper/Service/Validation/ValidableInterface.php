<?php namespace Bookkeeper\Service\Validation;

interface ValidableInterface {

    /**
     * Add data to validation against
     *
     * @param array
     * @return \Bookkeeper\Service\Validation\ValidableInterface  $this
     */
    public function with(array $input);

    /**
     * Test if validation passes
     *
     * @return boolean
     */
    public function passes();

    /**
     * Retrieve validation errors
     *
     * @return array
     */
    public function errors();

}