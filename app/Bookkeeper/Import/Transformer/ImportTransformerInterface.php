<?php namespace Bookkeeper\Import\Transformer;

interface ImportTransformerInterface {

    /**
     * Create a unified array from the parsed data
     *
     * @param      $data
     * @param null $map     Data map
     * @return mixed
     */
    public function transform($data, $map = null);

} 