<?php namespace Bookkeeper\Import\Transformer;

interface ImportTransformerInterface {

    /**
     * Transform data into managable data for rule manager
     *
     * @param $data
     * @return mixed
     */
    public function transform($data);

} 