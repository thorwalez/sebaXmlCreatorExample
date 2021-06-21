<?php


namespace App\Creator;


use App\Model\SepaOrder;

interface PaymentInformationTransferInterface
{
    /**
     * @param SepaOrder          $sepaOrder
     * @return string
     */
    public function build(SepaOrder $sepaOrder) : string;
}