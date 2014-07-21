<?php  namespace Bookkeeper\Repo\Category;

interface CategoryInterface {

    /**
     * Get all categories
     * @return Array Arrayable Collection
     */
    public function all();

    /**
     * Get a category by name
     * @param $name
     * @return object Category object
     */
    public function byName($name);

    /**
     * Get a category by ID
     * @param int $id Category ID
     * @return object Category object
     */
    public function byId($id);

    /**
     * Returns an array of category names
     * @return array
     */
    public function getDropdownArray();
} 