<?php namespace Bookkeeper\Repo\Rule;

interface RuleInterface {

    /**
     * Return all resources
     * @return mixed
     */
    public function all();

    /**
     * Return all resources as arrays
     * @return mixed
     */
    public function allAsArray();

}