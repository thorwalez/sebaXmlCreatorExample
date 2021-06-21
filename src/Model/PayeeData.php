<?php


namespace App\Model;


class PayeeData
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $iban;

    /**
     * @var string
     */
    private $bic;

    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name) : void
    {
        $this->name = $name;
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
}