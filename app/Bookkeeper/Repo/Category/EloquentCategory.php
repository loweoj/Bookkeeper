<?php  namespace Bookkeeper\Repo\Category;

use Illuminate\Database\Eloquent\Model;

class EloquentCategory implements CategoryInterface {

    /**
     * @var Model
     */
    protected $category;

    public function __construct(Model $category)
    {
        $this->category = $category;
    }

    /**
     * Get all categories
     * @return Array Arrayable Collection
     */
    public function all()
    {
        return $this->category->all();
    }

    /**
     * Get a category by name
     * @param $name
     * @return object Category object
     */
    public function byName($name)
    {
        return $this->category->where('name', $name);
    }

    /**
     * Get a category by ID
     * @param int $id Category ID
     * @return object Category object
     */
    public function byId($id)
    {
        return $this->category->find($id);
    }

    /**
     * Get a category by ID or Name
     * @param $IdOrName
     * @return EloquentCategory|\Illuminate\Database\Eloquent\Collection|Model|static
     */
    public function byNameOrId($NameOrID)
    {
        if( is_numeric($NameOrID) ) {
            return $this->byId($NameOrID);
        }

        return $this->byName($NameOrID);
    }

    /**
     * Get a category by ID or Name (Helper method)
     * @param $IdOrName
     * @return \Illuminate\Database\Eloquent\Collection|Model|static
     */
    public function byIdOrName($IdOrName)
    {
        return $this->byNameOrId($IdOrName);
    }

    /**
     * Returns an array of category names
     * @return array
     */
    public function getDropdownArray($type = null)
    {
        if( $type ) {
            $cats = $this->category->where('type', '=', $type)->get();
        } else {
            $cats = $this->category->get();
        }
        $return = [];
        foreach($cats as $c) {
            $return[$c->id] = $c->name;
        }
        return $return;
    }

}