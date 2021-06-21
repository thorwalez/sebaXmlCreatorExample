<?php


namespace App\Model;


class DepitData
{
    const SEQUENCE_TYPE_SINGLE_DEPIT = 'OOFF';
    const SEQUENCE_TYPE_FIRST_DEPIT = 'FRST';
    const SEQUENCE_TYPE_CONTINUE_DEPIT = 'RCUR';
    const SEQUENCE_TYPE_FINAL_DEPIT = 'FNAL';

    const NEW_BIC_PATTERN = 'SMNDA';

    /**
     * @var string
     */
    private $sequenceType;

    /**
     * @var string
     */
    private $mandateReference;

    /**
     * @var string
     */
    private $signMandateDate;


    /**
     * Alte Mandatsrefernz bei wechsel des Mandats
     * @var string
     */
    private $oldMandateReference;

    /**
     * @var string
     */
    private $oldPayeeName;

    /**
     * Alte Gläubiger ID bei Gläubiger wechsel
     * @var string
     */
    private $oldCreditorId;

    /**
     * Alte Schuldner IBAN bei IBAN wechsel
     * @var string
     */
    private $oldDeptorIban;

    /**
     * Bei wechsel der IBAN hier NEW_BIC_PATTERN verwenden
     * @var string
     */
    private $oldDeptorBic;

    /**
     * @return string
     */
    public function getSequenceType() : string
    {
        return $this->sequenceType;
    }

    /**
     * @param string $sequenceType
     */
    public function setSequenceType(string $sequenceType) : void
    {
        $this->sequenceType = $sequenceType;
    }

    /**
     * @return string
     */
    public function getMandateReference() : string
    {
        return $this->mandateReference;
    }

    /**
     * @param string $mandateReference
     */
    public function setMandateReference(string $mandateReference) : void
    {
        $this->mandateReference = $mandateReference;
    }

    /**
     * @return string
     */
    public function getSignMandateDate() : string
    {
        return $this->signMandateDate;
    }

    /**
     * @param string $signMandateDate
     */
    public function setSignMandateDate(string $signMandateDate) : void
    {
        $this->signMandateDate = $signMandateDate;
    }

    /**
     * @return string
     */
    public function getOldMandateReference() : string
    {
        return $this->oldMandateReference;
    }

    /**
     * @param string $oldMandateReference
     */
    public function setOldMandateReference(string $oldMandateReference) : void
    {
        $this->oldMandateReference = $oldMandateReference;
    }

    /**
     * @return string
     */
    public function getOldPayeeName() : string
    {
        return $this->oldPayeeName;
    }

    /**
     * @param string $oldPayeeName
     */
    public function setOldPayeeName(string $oldPayeeName) : void
    {
        $this->oldPayeeName = $oldPayeeName;
    }

    /**
     * @return string
     */
    public function getOldCreditorId() : string
    {
        return $this->oldCreditorId;
    }

    /**
     * @param string $oldCreditorId
     */
    public function setOldCreditorId(string $oldCreditorId) : void
    {
        $this->oldCreditorId = $oldCreditorId;
    }

    /**
     * @return string
     */
    public function getOldDeptorIban() : string
    {
        return $this->oldDeptorIban;
    }

    /**
     * @param string $oldDeptorIban
     */
    public function setOldDeptorIban(string $oldDeptorIban) : void
    {
        $this->oldDeptorIban = $oldDeptorIban;
    }

    /**
     * @return string
     */
    public function getOldDeptorBic() : string
    {
        return $this->oldDeptorBic;
    }

    /**
     * @param string $oldDeptorBic
     */
    public function setOldDeptorBic(string $oldDeptorBic) : void
    {
        $this->oldDeptorBic = $oldDeptorBic;
    }

    /**
     * @return bool
     */
    public function existOldMandat() : bool
    {
        return !(empty($this->oldPayeeName) &&
            empty($this->oldMandateReference) &&
            empty($this->oldDeptorIban) &&
            empty($this->oldDeptorBic) &&
            empty($this->oldCreditorId));
    }
}