<?php


namespace App\Filter;

/**
 * Interface FilterInterface
 * @package App\Filter
 */
interface FilterInterface
{
    /**
     * @param array $data
     * @return array
     */
    public function filter(array $data) : array;
}