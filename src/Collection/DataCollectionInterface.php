<?php
/**
 * Copyright (c) 2021.
 * Created By
 * @author    Mike Hartl
 * @copyright 2021  Mike Hartl All rights reserved
 * @license   The source code of this document is proprietary work, and is licensed for distribution or use.
 * @created   20.05.2021
 * @version   0.0.0
 */

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