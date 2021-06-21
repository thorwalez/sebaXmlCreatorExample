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

namespace App\Model;

/**
 * Class ClientBankData
 * @package App\Model
 */
class ClientBankData
{
    /**
     * @var string
     */
    private $clientName;

    /**
     * @var string
     */
    private $iban;

    /**
     * @var string
     */
    private $bic;

    /**
     * @var
     */
    private $creditorId;

    /**
     * @return string
     */
    public function getClientName() : string
    {
        return $this->clientName;
    }

    /**
     * @param string $clientName
     */
    public function setClientName(string $clientName) : void
    {
        $this->clientName = $clientName;
    }

    /**
     * @return string
     */
    public function getIban() : string
    {
        return $this->iban;
    }

    /**
     * @param string $iban
     */
    public function setIban(string $iban) : void
    {
        $this->iban = $iban;
    }

    /**
     * @return string
     */
    public function getBic() : string
    {
        return $this->bic;
    }

    /**
     * @param string $bic
     */
    public function setBic(string $bic) : void
    {
        $this->bic = $bic;
    }

    /**
     * @return mixed
     */
    public function getCreditorId()
    {
        return $this->creditorId;
    }

    /**
     * @param mixed $creditorId
     */
    public function setCreditorId($creditorId) : void
    {
        $this->creditorId = $creditorId;
    }

}