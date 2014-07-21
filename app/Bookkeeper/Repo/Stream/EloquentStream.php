<?php  namespace Bookkeeper\Repo\Stream;

use Illuminate\Database\Eloquent\Model;

class EloquentStream implements StreamInterface {

    public function __construct(Model $stream)
    {
        $this->stream = $stream;
    }

    /**
     * Return all streams
     *
     * @return mixed
     */
    public function all()
    {
        return $this->stream->all();
    }

    /**
     * Get a stream by ID
     */
    public function byId($id)
    {
        return $this->stream->find($id);
    }

    /**
     * Get a stream by name
     *
     * @return mixed
     */
    public function byName($name)
    {
        return $this->stream->whereName($name);
    }

    /**
     * Get a category by ID or Name
     * @param $IdOrName
     * @return \Illuminate\Database\Eloquent\Collection|Model|static
     */
    public function byIdOrName($IdOrName)
    {
        if( is_numeric($IdOrName) ) {
            return $this->byId($IdOrName);
        }

        return $this->byName($IdOrName);
    }

    /**
     * Returns an array of category names
     * @return array
     */
    public function getDropdownArray()
    {
        return $this->stream->lists('name', 'id');
    }

}