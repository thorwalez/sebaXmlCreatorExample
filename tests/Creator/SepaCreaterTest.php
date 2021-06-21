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
namespace App\Tests\Creator;

use App\Converter\SepaXmlConverter;
use App\Creator\PaymentInformationCreditTransfer;
use App\Creator\PaymentInformationDirectDebitTransfer;
use App\Creator\SepaCreditTransfer;
use App\Creator\SepaDirectDebitTransfer;
use App\Model\ClientBankData;
use App\Model\DepitData;
use App\Model\PayeeData;
use App\Model\PaymentInformation;
use App\Model\SepaOrder;
use PHPUnit\Framework\TestCase;

/**
 * Class SepaCreaterTest
 * @package App\Tests\Creator
 */
class SepaCreaterTest extends TestCase
{
    public function testConvertGehalt()
    {
        $transactionQuantity = 1;
        $transactionTotal = 0;

        $sepaOrder = new SepaOrder();
        $sepaOrder->setSepaVersion(SepaOrder::SEPA_VERSION_NEW);
        $sepaOrder->setPaymentType(SepaOrder::PAYMENT_TYPE_BANK_TRANSFERS);

        $sepaOrder->setMessageIdentification('Gehalt.05.2021');
        $sepaOrder->setPaymentInformationId('Pers.-Nr.1069');
        $sepaOrder->setClientName('Dienstleister GmbH');

        $clientBankData = new ClientBankData();
        $clientBankData->setClientName('Fanta AG');
        $clientBankData->setIban('DE179978000222200001741');
        $clientBankData->setBic('FIRMDELLXXX');
        $sepaOrder->setClientBankData($clientBankData);
        // möglicher Loop start

        //erstellung Zahlungsinformation
        //        $paymentInformations = new PaymentInformationCollection();

        $paymentInformation = new PaymentInformation();
        $paymentInformation->setExecutionDate('2021-05-30');
        $paymentInformation->setAmount('2114.15');
        $transactionTotal += (float)$paymentInformation->getAmount();

        $paymentInformation->setReference('2058/202105');
        $paymentInformation->setIntendedUse('Gehalt 05/2021');
        $paymentInformation->setCategoryPurposeCode(PaymentInformation::SALARY_TRANSFERS);
        $paymentInformation->setPurposeCode(PaymentInformation::SALARY_TRANSFERS);

        $payeeData = new PayeeData();
        $payeeData->setName('Max Mustermann');
        $payeeData->setIban('DE93143505390101753982');
        $payeeData->setBic('BANKDEFF');

        $paymentInformation->setPayeeData($payeeData);

        //        $paymentInformations->addItem($paymentInformation);
        $sepaOrder->setPaymentInformation($paymentInformation);

        // möglicher Loop ende

        //        $sepaOrder->setPaymentInformations($paymentInformations);

        $sepaOrder->setPaymentInformationTransfer(
            new PaymentInformationCreditTransfer((string)$transactionQuantity, (string)$transactionTotal)
        );
        $sepaOrder->setSebaTransfer(new SepaCreditTransfer((string)$transactionQuantity, (string)$transactionTotal));

        $instance = new SepaXmlConverter();
        $result = $instance->converted($sepaOrder);

        $pubDate = date('Ymd', \time());
        \file_put_contents("/var/www/app/build/phpUnitResult-salary-$pubDate.xml", $result);

        $this->assertNotEmpty($result);
    }

    public function testConvertEinfach()
    {
        $transactionQuantity = 1;
        $transactionTotal = 0;

        $sepaOrder = new SepaOrder();
        $sepaOrder->setSepaVersion(SepaOrder::SEPA_VERSION_OLD);
        $sepaOrder->setPaymentType(SepaOrder::PAYMENT_TYPE_BANK_TRANSFERS);

        $sepaOrder->setMessageIdentification('AuftragsBezeichnung');
        $sepaOrder->setPaymentInformationId('Zahlungsinformationen');
        $sepaOrder->setClientName('Ihr Name');

        $clientBankData = new ClientBankData();
        $clientBankData->setClientName('Ihr Name');
        $clientBankData->setIban('Ihre IBAN');
        $clientBankData->setBic('Ihr BIC');
        $sepaOrder->setClientBankData($clientBankData);
        // möglicher Loop start

        //erstellung Zahlungsinformation
        //        $paymentInformations = new PaymentInformationCollection();

        $paymentInformation = new PaymentInformation();
        $paymentInformation->setExecutionDate('2021-06-22');
        $paymentInformation->setAmount('45.90');
        $transactionTotal += (float)$paymentInformation->getAmount();

        $paymentInformation->setReference('Referenz');
        $paymentInformation->setIntendedUse('Verwendungszweck');

        $payeeData = new PayeeData();
        $payeeData->setName('Max Mustermann');
        $payeeData->setIban('DE69756100880102296856');
        $payeeData->setBic('PBNKDEFFXXX');

        $paymentInformation->setPayeeData($payeeData);

        //        $paymentInformations->addItem($paymentInformation);
        $sepaOrder->setPaymentInformation($paymentInformation);

        // möglicher Loop ende

        //        $sepaOrder->setPaymentInformations($paymentInformations);

        $sepaOrder->setPaymentInformationTransfer(
            new PaymentInformationCreditTransfer((string)$transactionQuantity, (string)$transactionTotal)
        );
        $sepaOrder->setSebaTransfer(new SepaCreditTransfer((string)$transactionQuantity, (string)$transactionTotal));

        $instance = new SepaXmlConverter();
        $result = $instance->converted($sepaOrder);

        $pubDate = date('Ymd', \time());
        \file_put_contents("/var/www/app/build/phpUnitResult-Simple-$pubDate.xml", $result);

        $this->assertNotEmpty($result);
    }

    public function testConvertLastschrift()
    {
        $transactionQuantity = 1;
        $transactionTotal = 0;

        $sepaOrder = new SepaOrder();
        $sepaOrder->setSepaVersion(SepaOrder::SEPA_VERSION_OLD);
        $sepaOrder->setPaymentType(SepaOrder::PAYMENT_BASIC_DIRECT_DEBITS);

        $sepaOrder->setMessageIdentification('Einzug.2021-06');
        $sepaOrder->setPaymentInformationId('Best.v.12.05.2021');
        $sepaOrder->setClientName('Dienstleister GmbH');

        $clientBankData = new ClientBankData();
        $clientBankData->setClientName('Firma GmbH');
        $clientBankData->setIban('DE13799300200000054321');
        $clientBankData->setBic('BNKADENN777');
        $clientBankData->setCreditorId('98ZZE99889999');
        $sepaOrder->setClientBankData($clientBankData);
        // möglicher Loop start

        //erstellung Zahlungsinformation
        //        $paymentInformations = new PaymentInformationCollection();

        $paymentInformation = new PaymentInformation();
        $paymentInformation->setExecutionDate('2021-06-30');
        $paymentInformation->setAmount('85.00');
        $transactionTotal += (float)$paymentInformation->getAmount();

        $paymentInformation->setReference('12345678');
        $paymentInformation->setIntendedUse('Rechnung 12345678');

        $depitData = new DepitData();
        $depitData->setSequenceType(DepitData::SEQUENCE_TYPE_SINGLE_DEPIT);
        $depitData->setMandateReference('KUNDE7858');
        $depitData->setSignMandateDate('2021-06-14');
        $paymentInformation->setDepit($depitData);

        $payeeData = new PayeeData();
        $payeeData->setName('Kunde,Karl');
        $payeeData->setIban('AT482015210000063789');
        $payeeData->setBic('BANKATWW');

        $paymentInformation->setPayeeData($payeeData);

        //        $paymentInformations->addItem($paymentInformation);
        $sepaOrder->setPaymentInformation($paymentInformation);

        // möglicher Loop ende

        //        $sepaOrder->setPaymentInformations($paymentInformations);

        $sepaOrder->setPaymentInformationTransfer(
            new PaymentInformationDirectDebitTransfer((string)$transactionQuantity, (string)$transactionTotal)
        );
        $sepaOrder->setSebaTransfer(
            new SepaDirectDebitTransfer((string)$transactionQuantity, (string)$transactionTotal)
        );

        $instance = new SepaXmlConverter();
        $result = $instance->converted($sepaOrder);

        $pubDate = date('Ymd', \time());
        \file_put_contents("/var/www/app/build/phpUnitResult-Last-$pubDate.xml", $result);

        $this->assertNotEmpty($result);
    }
}
