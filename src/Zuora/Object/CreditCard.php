<?php

namespace Zuora\Object;

class CreditCard extends ZuoraObject
{
    /**
     * @return mixed
     */
    public function getCardHolderInfo()
    {
        return new CreditCardHolder($this->cardHolderInfo);
    }

    /**
     * @return mixed
     */
    public function getCardNumber()
    {
        return $this->cardNumber;
    }

    /**
     * @return mixed
     */
    public function getCardType()
    {
        return $this->cardType;
    }

    /**
     * @return mixed
     */
    public function isDefaultPaymentMethod()
    {
        return $this->defaultPaymentMethod;
    }

    /**
     * @return mixed
     */
    public function getExpirationMonth()
    {
        return $this->expirationMonth;
    }

    /**
     * @return mixed
     */
    public function getExpirationYear()
    {
        return $this->expirationYear;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
}
