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
 * Für Zahlungsempfänger ohne Lastschrift Daten
 * Für Zahlungspflichtige mit Lastschrift Daten
 * Class BankTransfer
 * @package App\Model
 */
class PaymentInformation
{
    const SALARY_TRANSFERS = 'SALA';
    const DEFAULT_TRANSFERS = '';

    /**
     * @var string
     */
    private $executionDate;

    /**
     * @var PayeeData
     */
    private $payeeData;

    /**
     * @var string
     */
    private $amount;

    /**
     * CtfyPurp
     * Éntspricht dem Textschlüssel der DTAUS-Dateien/Purp
     * @var string
     */
    private $categoryPurposeCode;

    /**
     * @var string
     */
    private $purposeCode;

    /**
     * Zahlungsreferenz
     * @var string
     */
    private $reference;

    /**
     * Verwendungszweg
     * @var string
     */
    private $intendedUse;

    /**
     * @var DepitData
     */
    private $depit;

    /**
     * @return string
     */
    public function getExecutionDate() : string
    {
        return $this->executionDate;
    }

    /**
     * @param string $executionDate
     */
    public function setExecutionDate(string $executionDate) : void
    {
        $this->executionDate = $executionDate;
    }

    /**
     * @return PayeeData
     */
    public function getPayeeData() : PayeeData
    {
        return $this->payeeData;
    }

    /**
     * @param PayeeData $payeeData
     */
    public function setPayeeData(PayeeData $payeeData) : void
    {
        $this->payeeData = $payeeData;
    }

    /**
     * @return string
     */
    public function getAmount() : string
    {
        return $this->amount;
    }

    /**
     * @param string $amount
     */
    public function setAmount(string $amount) : void
    {
        $this->amount = $amount;
    }

    /**
     * @return string
     */
    public function getCategoryPurposeCode() : string
    {
        return \is_null($this->categoryPurposeCode) ? '' : $this->categoryPurposeCode;
    }

    /**
     * @param string $categoryPurposeCode
     */
    public function setCategoryPurposeCode(string $categoryPurposeCode) : void
    {
        $this->categoryPurposeCode = $categoryPurposeCode;
    }

    /**
     * @return string
     */
    public function getPurposeCode() : string
    {
        return \is_null($this->purposeCode) ? '' : $this->purposeCode;
    }

    /**
     * @param string $purposeCode
     */
    public function setPurposeCode(string $purposeCode) : void
    {
        $this->purposeCode = $purposeCode;
    }

    /**
     * @return string
     */
    public function getReference() : string
    {
        return $this->reference;
    }

    /**
     * @param string $reference
     */
    public function setReference(string $reference) : void
    {
        $this->reference = $reference;
    }

    /**
     * @return string
     */
    public function getIntendedUse() : string
    {
        return $this->intendedUse;
    }

    /**
     * @param string $intendedUse
     */
    public function setIntendedUse(string $intendedUse) : void
    {
        $this->intendedUse = $intendedUse;
    }

    /**
     * @return DepitData
     */
    public function getDepit() : DepitData
    {
        return $this->depit;
    }

    /**
     * @param DepitData $depit
     */
    public function setDepit(DepitData $depit) : void
    {
        $this->depit = $depit;
    }

    /**
     * @return bool
     */
    public function hasDepitData() : bool
    {
        return $this->depit instanceof DepitData;
    }

    /**
     * @return bool
     */
    public function existOldMandat() : bool
    {
        return $this->hasDepitData() && $this->getDepit()->existOldMandat();
    }

}