<?php


namespace App\Collection;

use App\Filter\FilterInterface;

/**
 * Interface DataCollectionInterface
 * @package App\Collection
 */
interface DataCollectionInterface extends \Countable
{
    /**
     * @param object $obj
     * @param string $key
     */
    public function addItem($obj, $key = null) : void;

    /**
     * @param string $key
     */
    public function deleteItem(string $key) : void;

    /**
     * @param string $key
     * @return string | int | object |array |DataCollectionInterface
     */
    public function getItem(string $key);

    /**
     * @return int
     */
    public function count() : int;

    /**
     * @param FilterInterface $filter
     * @return DataCollectionInterface
     */
    public function filter(FilterInterface $filter) : DataCollectionInterface;

    /**
     * @return array
     */
    public function toArray() : array;
}