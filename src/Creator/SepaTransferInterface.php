<?php


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