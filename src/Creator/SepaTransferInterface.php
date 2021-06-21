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

namespace App\Creator;

use App\Model\SepaOrder;

/**
 * Interface SepaTransferInterface
 * @package App\Creator
 */
interface SepaTransferInterface
{
    /**
     * @param string $version
     * @return string
     */
    public function buildUrn(string $version):string;

    /**
     * @param SepaOrder $sepaOrder
     * @return string
     */
    public function buildBody(SepaOrder $sepaOrder) : string;
}