<?php namespace Bookkeeper\Repo\Stream;

interface StreamInterface {

    /**
     * Return all streams
     * @return mixed
     */
    public function all();

    /**
     * Get a stream by ID
     */
    public function byId($id);

    /**
     * Get a stream by name
     * @return mixed
     */
    public function byName($name);

} 