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


use App\Collection\PaymentInformationCollection;
use App\Creator\PaymentInformationTransferInterface;
use App\Creator\SepaTransferInterface;

/**
 * Class SepaOrder
 * @package App\Model
 */
class SepaOrder
{
    const SEPA_VERSION_NEW = 1;
    const SEPA_VERSION_OLD = 3;

    const PAYMENT_TYPE_BANK_TRANSFERS = 'TRF';
    const PAYMENT_TYPE_BANK_TRANSFERS_EBICS = 'CCT';
    const PAYMENT_BASIC_DIRECT_DEBITS = 'CORE';
    const PAYMENT_BASIC_DIRECT_DEBITS_EBICS = 'CDD';
    const PAYMENT_CORPORATE_DIRECT_DEBITS = 'B2B';
    const PAYMENT_CORPORATE_DIRECT_DEBITS_EBICS = 'CDB';

    /**
     * @var string
     */
    private $sepaVersion;

    /**
     * @var string
     */
    private $paymentType;

    /**
     * msgid
     * @var string
     */
    private $messageIdentification;

    /**
     * @var string
     */
    private $paymentInformationId;

    /**
     * Auftraggeber Name des InitgPty-Knoten
     * @var string
     */
    private $clientName;

    /**
     * @var ClientBankData
     */
    private $clientBankData;

    /**
     * @var SepaTransferInterface
     */
    private $sebaTransfer;

    /**
     * @var PaymentInformationCollection
     */
    private $paymentInformations;

    /**
     * @var PaymentInformation
     */
    private $paymentInformation;

    /**
     * @var PaymentInformationTransferInterface
     */
    private $paymentInformationTransfer;

    /**
     * @return string
     */
    public function getSepaVersion() : string
    {
        return $this->sepaVersion;
    }

    /**
     * @param string $sepaVersion
     */
    public function setSepaVersion(string $sepaVersion) : void
    {
        $this->sepaVersion = $sepaVersion;
    }

    /**
     * @return string
     */
    public function getPaymentType() : string
    {
        return $this->paymentType;
    }

    /**
     * @param string $paymentType
     */
    public function setPaymentType(string $paymentType) : void
    {
        $this->paymentType = $paymentType;
    }

    /**
     * @return string
     */
    public function getMessageIdentification() : string
    {
        return $this->messageIdentification;
    }

    /**
     * @param string $messageIdentification
     */
    public function setMessageIdentification(string $messageIdentification) : void
    {
        $this->messageIdentification = $messageIdentification;
    }

    /**
     * @return mixed
     */
    public function getPaymentInformationId()
    {
        return $this->paymentInformationId;
    }

    /**
     * @param mixed $paymentInformationId
     */
    public function setPaymentInformationId($paymentInformationId) : void
    {
        $this->paymentInformationId = $paymentInformationId;
    }

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
     * @return ClientBankData
     */
    public function getClientBankData() : ClientBankData
    {
        return $this->clientBankData;
    }

    /**
     * @param ClientBankData $clientBankData
     */
    public function setClientBankData(ClientBankData $clientBankData) : void
    {
        $this->clientBankData = $clientBankData;
    }

    /**
     * @return SepaTransferInterface
     */
    public function getSebaTransfer() : SepaTransferInterface
    {
        return $this->sebaTransfer;
    }

    /**
     * @param SepaTransferInterface $sebaTransfer
     */
    public function setSebaTransfer(SepaTransferInterface $sebaTransfer) : void
    {
        $this->sebaTransfer = $sebaTransfer;
    }

    /**
     * @return PaymentInformationCollection
     */
    public function getPaymentInformations() : PaymentInformationCollection
    {
        return $this->paymentInformations;
    }

    /**
     * @param PaymentInformationCollection $paymentInformations
     */
    public function setPaymentInformations(PaymentInformationCollection $paymentInformations) : void
    {
        $this->paymentInformations = $paymentInformations;
    }

    /**
     * @return PaymentInformation
     */
    public function getPaymentInformation() : PaymentInformation
    {
        return $this->paymentInformation;
    }

    /**
     * @param PaymentInformation $paymentInformation
     */
    public function setPaymentInformation(PaymentInformation $paymentInformation) : void
    {
        $this->paymentInformation = $paymentInformation;
    }

    /**
     * @return PaymentInformationTransferInterface
     */
    public function getPaymentInformationTransfer() : PaymentInformationTransferInterface
    {
        return $this->paymentInformationTransfer;
    }

    /**
     * @param PaymentInformationTransferInterface $paymentInformationTransfer
     */
    public function setPaymentInformationTransfer(PaymentInformationTransferInterface $paymentInformationTransfer) : void
    {
        $this->paymentInformationTransfer = $paymentInformationTransfer;
    }

}