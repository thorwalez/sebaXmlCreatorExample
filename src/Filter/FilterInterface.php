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