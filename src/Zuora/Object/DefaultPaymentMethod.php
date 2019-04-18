<?php

namespace Zuora\Object;

class DefaultPaymentMethod extends ZuoraObject
{

    /**
     * @return mixed
     */
    public function getCreditCardExpirationMonth()
    {
        return $this->creditCardExpirationMonth;
    }

    /**
     * @return mixed
     */
    public function getCreditCardExpirationYear()
    {
        return $this->creditCardExpirationYear;
    }

    /**
     * @return mixed
     */
    public function getCreditCardNumber()
    {
        return $this->creditCardNumber;
    }

    /**
     * @return mixed
     */
    public function getCreditCardType()
    {
        return $this->creditCardType;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getPaymentMethodType()
    {
        return $this->paymentMethodType;
    }
}
