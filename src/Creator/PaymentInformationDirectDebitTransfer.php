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


use App\Model\PaymentInformation;
use App\Model\SepaOrder;

/**
 * Class PaymentInformationDirectDebitTransfer
 * @package App\Creator
 */
class PaymentInformationDirectDebitTransfer implements PaymentInformationTransferInterface
{
    /**
     * @var string
     */
    private $transactionTotal;

    /**
     * @var string
     */
    private $transactionQuantity;

    /**
     * PaymentInformationXmlConverter constructor.
     * @param string $transactionQuantity
     * @param string $transactionTotal
     */
    public function __construct(string $transactionQuantity, string $transactionTotal)
    {
        $this->transactionQuantity = \trim($transactionQuantity);
        $this->transactionTotal = \trim($transactionTotal);
    }

    /**
     * @param SepaOrder $sepaOrder
     * @return string
     */
    public function build(SepaOrder $sepaOrder) : string
    {
        $content = '    <PmtInf>' . \PHP_EOL;

        $myPmtInfId = $this->buildPaymentInformationIdContent($sepaOrder);
        $content .= "      <PmtInfId>$myPmtInfId</PmtInfId>" . \PHP_EOL;
        $content .= '      <PmtMtd>DD</PmtMtd>' . \PHP_EOL;

        $content .= "      <NbOfTxs>$this->transactionQuantity</NbOfTxs>" . \PHP_EOL;

        $total = sprintf('%.2F', $this->transactionTotal);
        $content .= "      <CtrlSum>$total</CtrlSum>" . \PHP_EOL;

        ### PmtTpInf start
        $content .= '      <PmtTpInf>' . \PHP_EOL;
        $content .= '        <SvcLvl>' . \PHP_EOL;
        $content .= '          <Cd>SEPA</Cd>' . \PHP_EOL;
        $content .= '        </SvcLvl>' . \PHP_EOL;

        $content .= '        <LclInstrm>' . \PHP_EOL;
        $content .= '          <Cd>' . $sepaOrder->getPaymentType() . '</Cd>' . \PHP_EOL;
        $content .= '        </LclInstrm>' . \PHP_EOL;
        $sequenceType = $sepaOrder->getPaymentInformation()->getDepit()->getSequenceType();
        $content .= "        <SeqTp>$sequenceType</SeqTp>" . \PHP_EOL;

        $ctgyPurp = $sepaOrder->getPaymentInformation()->getCategoryPurposeCode();
        if (!empty($ctgyPurp)) {
            $content .= '        <CtgyPurp>' . \PHP_EOL;
            $content .= "          <Cd>$ctgyPurp</Cd>" . \PHP_EOL;
            $content .= '        </CtgyPurp>' . \PHP_EOL;
        }
        $content .= '      </PmtTpInf>' . \PHP_EOL;
        ### PmtTpInf ende

        // Ausfuehrungsdatum
        $executionDate = $sepaOrder->getPaymentInformation()->getExecutionDate();
        $content .= "      <ReqdColltnDt>$executionDate</ReqdColltnDt>" . \PHP_EOL;

        $content .= '      <Cdtr>' . \PHP_EOL;
        $content .= '        <Nm>' . $sepaOrder->getClientBankData()->getClientName() . '</Nm>' . \PHP_EOL;
        $content .= '      </Cdtr>' . \PHP_EOL;
        $content .= '      <CdtrAcct>' . \PHP_EOL;
        $content .= '        <Id>' . \PHP_EOL;
        $content .= '          <IBAN>' . $sepaOrder->getClientBankData()->getIban() . '</IBAN>' . \PHP_EOL;
        $content .= '        </Id>' . PHP_EOL;
        $content .= '      </CdtrAcct>' . \PHP_EOL;

        $content .= '      <CdtrAgt>' . \PHP_EOL;
        $content .= '        <FinInstnId>' . \PHP_EOL;
        $clientBic = $sepaOrder->getClientBankData()->getBic();
        if (!empty($clientBic)) {
            $content .= "          <BIC>$clientBic</BIC>" . \PHP_EOL;
        } else {
            $content .= '          <Othr>' . \PHP_EOL;
            $content .= '            <Id>NOTPROVIDED</Id>' . \PHP_EOL;
            $content .= '          </Othr>' . \PHP_EOL;
        }
        $content .= '        </FinInstnId>' . \PHP_EOL;
        $content .= '      </CdtrAgt>' . \PHP_EOL;

        $content .= '      <ChrgBr>SLEV</ChrgBr>' . \PHP_EOL;

        $content .= '      <CdtrSchmeId>' . \PHP_EOL;
        $content .= '        <Id>' . \PHP_EOL;
        $content .= '          <PrvtId>' . \PHP_EOL;
        $content .= '            <Othr>' . \PHP_EOL;
        $content .= '              <Id>' . $sepaOrder->getClientBankData()->getCreditorId() . '</Id>' . \PHP_EOL;
        $content .= '              <SchmeNm>' . \PHP_EOL;
        $content .= '                <Prtry>SEPA</Prtry>' . \PHP_EOL;
        $content .= '              </SchmeNm>' . \PHP_EOL;
        $content .= '            </Othr>' . \PHP_EOL;
        $content .= '          </PrvtId>' . \PHP_EOL;
        $content .= '        </Id>' . \PHP_EOL;
        $content .= '      </CdtrSchmeId>' . \PHP_EOL;

        $content .= $this->bookingInformation($sepaOrder->getPaymentInformation());

        $content .= '    </PmtInf>' . \PHP_EOL;

        return $content;
    }

    /**
     * @param SepaOrder $sepaOrder
     * @return string
     */
    private function buildPaymentInformationIdContent(SepaOrder $sepaOrder) : string
    {
        $content = $sepaOrder->getPaymentInformationId();

        if (!empty($sepaOrder->getPaymentInformation()->getCategoryPurposeCode())) {
            $content .= '-' . $sepaOrder->getPaymentInformation()->getCategoryPurposeCode();
        }

        if (!empty($sepaOrder->getPaymentInformation()->hasDepitData())) {
            $content .= '-' . $sepaOrder->getPaymentInformation()->getDepit()->getSequenceType();
        }

        return $content;
    }

    /**
     * @param PaymentInformation $paymentInformation
     * @return string
     */
    private function bookingInformation(PaymentInformation $paymentInformation) : string
    {

        $startTag = '      <DrctDbtTxInf>';
        $referenceInformation = $paymentInformation->getReference();
        $endToEndId = empty($referenceInformation) ? 'NOTPROVIDED' : $referenceInformation;
        $amount = \sprintf('%.2F', $paymentInformation->getAmount());

        $content = $startTag . \PHP_EOL;
        $content .= '        <PmtId>' . \PHP_EOL;
        $content .= "          <EndToEndId>$endToEndId</EndToEndId>" . \PHP_EOL;
        $content .= '        </PmtId>' . \PHP_EOL;

        $content .= $this->buildOldInformations($paymentInformation);

        $bic = $paymentInformation->getPayeeData()->getBic();
        if (!empty($bic)) {
            $content .= '        <DbtrAgt>' . \PHP_EOL;
            $content .= '          <FinInstnId>' . \PHP_EOL;
            $content .= "            <BIC>$bic</BIC>" . \PHP_EOL;
            $content .= '          </FinInstnId>' . \PHP_EOL;
            $content .= '        </DbtrAgt>' . \PHP_EOL;
        } else {
            $content .= '        <DbtrAgt>' . \PHP_EOL;
            $content .= '          <FinInstnId>' . \PHP_EOL;
            $content .= '            <Othr>' . \PHP_EOL;
            $content .= '              <Id>NOTPROVIDED</Id>' . \PHP_EOL;
            $content .= '            </Othr>' . \PHP_EOL;
            $content .= '          </FinInstnId>' . \PHP_EOL;
            $content .= '        </DbtrAgt>' . \PHP_EOL;
        }

        $content .= '        <Dbtr>' . \PHP_EOL;
        $content .= '          <Nm>' . $paymentInformation->getPayeeData()->getName() . '</Nm>' . \PHP_EOL;
        $content .= '        </Dbtr>' . \PHP_EOL;

        $content .= '        <DbtrAcct>' . \PHP_EOL;
        $content .= '          <Id>' . \PHP_EOL;
        $content .= '            <IBAN>' . $paymentInformation->getPayeeData()->getIban() . '</IBAN>' . \PHP_EOL;
        $content .= '          </Id>' . \PHP_EOL;
        $content .= '        </DbtrAcct>' . \PHP_EOL;

        $purb = $paymentInformation->getPurposeCode();
        if (!empty($purb)) {
            $content .= '        <Purp>' . \PHP_EOL;
            $content .= "          <Cd>$purb</Cd>" . \PHP_EOL;
            $content .= '        </Purp>' . \PHP_EOL;
        }

        $intendedUse = $paymentInformation->getIntendedUse();
        if (!empty($intendedUse)) {
            $content .= '        <RmtInf>' . \PHP_EOL;
            $content .= "          <Ustrd>$intendedUse</Ustrd>" . \PHP_EOL;
            $content .= '        </RmtInf>' . \PHP_EOL;
        }

        $content .= '      </DrctDbtTxInf>' . \PHP_EOL;

        return $content;
    }

    /**
     * @param PaymentInformation $paymentInformation
     * @return string
     */
    private function buildOldInformations(PaymentInformation $paymentInformation) : string
    {
        $amount = \sprintf('%.2F', $paymentInformation->getAmount());
        $content = "        <InstdAmt Ccy=\"EUR\">$amount</InstdAmt>" . \PHP_EOL;
        $content .= '        <DrctDbtTx>' . \PHP_EOL;
        $content .= '          <MndtRltdInf>' . \PHP_EOL;
        $content .= '            <MndtId>' . $paymentInformation->getDepit()->getMandateReference(
            ) . '</MndtId>' . \PHP_EOL;

        $signMandateDate = $paymentInformation->getDepit()->getSignMandateDate();
        $content .= "            <DtOfSgntr>$signMandateDate</DtOfSgntr>" . \PHP_EOL;

        $existOldMandat = $paymentInformation->existOldMandat();
        $content .= '            <AmdmntInd>' . ($existOldMandat ? 'true' : 'false') . '</AmdmntInd>' . \PHP_EOL;
        if ($existOldMandat) {
            $content .= '            <AmdmntInfDtls>' . \PHP_EOL;

            $oldMandatReference = $paymentInformation->getDepit()->getOldMandateReference();
            if (!empty($oldMandatReference)) {
                $content .= "              <OrgnlMndtId>$oldMandatReference</OrgnlMndtId>" . \PHP_EOL;
            }

            $oldName = $paymentInformation->getDepit()->getOldPayeeName();
            $oldCreditOrId = $paymentInformation->getDepit()->getOldCreditorId();
            if (!empty($oldName) or !empty($oldCreditOrId)) {
                $content .= '              <OrgnlCdtrSchmeId>' . \PHP_EOL;
                if (!empty($oldName)) {
                    $content .= "                <Nm>$oldName</Nm>" . \PHP_EOL;
                }

                if (!empty($oldCreditOrId)) {
                    $content .= '                <Id>' . \PHP_EOL;
                    $content .= '                  <PrvtId>' . \PHP_EOL;
                    $content .= '                    <Othr>' . \PHP_EOL;
                    $content .= "                      <Id>$oldCreditOrId</Id>" . \PHP_EOL;
                    $content .= '                      <SchmeNm>' . \PHP_EOL;
                    $content .= '                        <Prtry>SEPA</Prtry>' . \PHP_EOL;
                    $content .= '                      </SchmeNm>' . \PHP_EOL;
                    $content .= '                    </Othr>' . \PHP_EOL;
                    $content .= '                  </PrvtId>' . \PHP_EOL;
                    $content .= '                </Id>' . \PHP_EOL;
                }
                $content .= '              </OrgnlCdtrSchmeId>' . \PHP_EOL;
            }

            $oldIban = $paymentInformation->getDepit()->getOldDeptorIban();
            if (!empty($oldIban)) {
                $content .= '              <OrgnlDbtrAcct>' . \PHP_EOL;
                $content .= '                <Id>' . \PHP_EOL;
                $content .= "                  <IBAN>$oldIban</IBAN>" . \PHP_EOL;
                $content .= '                </Id>' . \PHP_EOL;
                $content .= '              </OrgnlDbtrAcct>' . \PHP_EOL;
            }

            $oldBic = $paymentInformation->getDepit()->getOldDeptorBic();
            if (!empty($oldBic)) {
                $content .= '              <OrgnlDbtrAgt>' . \PHP_EOL;
                $content .= '                <FinInstnId>' . \PHP_EOL;
                $content .= '                  <Othr>' . \PHP_EOL;
                $content .= "                    <Id>$oldBic</Id>" . \PHP_EOL;
                $content .= '                  </Othr>' . \PHP_EOL;
                $content .= '                </FinInstnId>' . \PHP_EOL;
                $content .= '              </OrgnlDbtrAgt>' . \PHP_EOL;
            }
            $content .= '            </AmdmntInfDtls>' . \PHP_EOL;
        }
        $content .= '          </MndtRltdInf>' . \PHP_EOL;
        $content .= '        </DrctDbtTx>' . \PHP_EOL;

        return $content;
    }
}