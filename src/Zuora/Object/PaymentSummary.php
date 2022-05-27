<?php

namespace Zuora\Object;

class PaymentSummary extends ZuoraObject
{
    /**
     * @return mixed
     */
    public function getEffectiveDate()
    {
        return $this->effectiveDate;
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
    public function getPaidInvoices()
    {
        // TODO: Move to own class?
        return $this->paidInvoices;
    }

    /**
     * @return mixed
     */
    public function getPaymentNumber()
    {
        return $this->paymentNumber;
    }

    /**
     * @return mixed
     */
    public function getPaymentType()
    {
        return $this->paymentType;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }
}
