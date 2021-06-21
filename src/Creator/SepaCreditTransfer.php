<?php


namespace App\Creator;

use App\Model\SepaOrder;

/**
 * Class SepaCreditTransfer
 * @package App\Creator
 */
class SepaCreditTransfer implements SepaTransferInterface
{
    const SEPA_CREDIT_TRANSFER_RB_URN = 'urn:iso:std:iso:20022:tech:xsd:pain.001.00%s.03';

    /**
     * @var float
     */
    private $transactionQuantity;

    /**
     * @var float
     */
    private $transactionTotal;

    /**
     * SepaCreditTransfer constructor.
     * @param float $transactionQuantity
     * @param float $transactionTotal
     */
    public function __construct(float $transactionQuantity, float $transactionTotal)
    {
        $this->transactionQuantity = $transactionQuantity;
        $this->transactionTotal = $transactionTotal;
    }

    /**
     * @param string $version
     * @return string
     */
    public function buildUrn(string $version):string
    {
        return \sprintf(self::SEPA_CREDIT_TRANSFER_RB_URN, $version);
    }

    /**
     * @param SepaOrder $sepaOrder
     * @return string
     */
    public function buildBody(SepaOrder $sepaOrder) : string
    {
        $content ='  <CstmrCdtTrfInitn>' . \PHP_EOL;

        $content .= $this->buidGroupHeader($sepaOrder);

//        foreach ($sepaOrder->getPaymentInformations()->toArray() as $item) {
        $content .= $sepaOrder->getPaymentInformationTransfer()->build($sepaOrder);
//        }
        $content.='  </CstmrCdtTrfInitn>' . \PHP_EOL;

        return $content;
    }

    /**
     * @param SepaOrder $sepaOrder
     * @return string
     */
    protected function buidGroupHeader(SepaOrder $sepaOrder) : string
    {
        $contentDate = date('Y-m-d\TH:i:s');
        $sum = sprintf('%.2F', $this->transactionTotal);
        $msgId = $sepaOrder->getMessageIdentification();
        $depositor = $sepaOrder->getClientName();

        $content = '    <GrpHdr>' . \PHP_EOL;
        $content .= "      <MsgId>$msgId</MsgId>" . \PHP_EOL;
        $content .= "      <CreDtTm>$contentDate</CreDtTm>" . \PHP_EOL;
        $content .= "      <NbOfTxs>$this->transactionQuantity </NbOfTxs>" . \PHP_EOL;
        $content .= "      <CtrlSum>$sum</CtrlSum>" . \PHP_EOL;
        $content .= "      <InitgPty>" . \PHP_EOL;
        $content .= "        <Nm>$depositor</Nm>" . \PHP_EOL;
        $content .= "      </InitgPty>" . \PHP_EOL;
        $content .= "    </GrpHdr>" . \PHP_EOL;

        return $content;
    }
}