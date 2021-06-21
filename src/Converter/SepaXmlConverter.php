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

namespace App\Converter;


use App\Model\SepaOrder;

/**
 * Class SepaXmlConverter
 * @package App\Converter
 */
class SepaXmlConverter
{
    /**
     * @param SepaOrder $sepaOrder
     * @return string
     */
    public function converted(SepaOrder $sepaOrder) : string
    {
        $content = $this->xmlSepaBody($sepaOrder);

        return $content;
    }

    /**
     * @param string $paymentTransfersType
     * @return bool
     */
    private function isPaymentTypeBankTransfers(string $paymentTransfersType) : bool
    {
        return $paymentTransfersType != SepaOrder::PAYMENT_TYPE_BANK_TRANSFERS;
    }

    /**
     * @param SepaOrder $sepaOrder
     * @return string
     */
    private function xmlSepaBody(SepaOrder $sepaOrder) : string
    {

        $urnSepaTransfer = $sepaOrder->getSebaTransfer()->buildUrn($sepaOrder->getSepaVersion());

        $content = '<?xml version="1.0" encoding="UTF-8"?>' . \PHP_EOL;
        $content .= "<Document xmlns=\"$urnSepaTransfer\"" . \PHP_EOL;
        $content .= '  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"' . \PHP_EOL;
        $content .= "  xsi:schemaLocation=\"$urnSepaTransfer.xsd\">" . \PHP_EOL;
        $content .= $sepaOrder->getSebaTransfer()->buildBody($sepaOrder);
        $content .= '</Document>' . \PHP_EOL;

        return $content;
    }

}