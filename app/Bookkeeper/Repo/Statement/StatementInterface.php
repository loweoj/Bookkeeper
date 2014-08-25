<?php namespace Bookkeeper\Repo\Statement;

interface StatementInterface {

    /**
     * Create a statement
     *
     * @param $data
     * @return mixed
     */
    public function create($data);

} 