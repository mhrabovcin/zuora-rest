<?php

namespace Zuora\Object;


class InvoiceItem extends ZuoraObject {

    /**
     * @return mixed
     */
    public function getChargeAmount()
    {
        return $this->chargeAmount;
    }

    /**
     * @return mixed
     */
    public function getChargeDescription()
    {
        return $this->chargeDescription;
    }

    /**
     * @return mixed
     */
    public function getChargeId()
    {
        return $this->chargeId;
    }

    /**
     * @return mixed
     */
    public function getChargeName()
    {
        return $this->chargeName;
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
    public function getProductName()
    {
        return $this->productName;
    }

    /**
     * @return mixed
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @return mixed
     */
    public function getServiceEndDate()
    {
        return $this->serviceEndDate;
    }

    /**
     * @return mixed
     */
    public function getServiceStartDate()
    {
        return $this->serviceStartDate;
    }

    /**
     * @return mixed
     */
    public function getSubscriptionId()
    {
        return $this->subscriptionId;
    }

    /**
     * @return mixed
     */
    public function getSubscriptionName()
    {
        return $this->subscriptionName;
    }

    /**
     * @return mixed
     */
    public function getTaxAmount()
    {
        return $this->taxAmount;
    }

    /**
     * @return mixed
     */
    public function getUnitOfMeasure()
    {
        return $this->unitOfMeasure;
    }

} 