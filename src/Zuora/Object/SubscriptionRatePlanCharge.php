<?php

namespace Zuora\Object;


class SubscriptionRatePlanCharge extends ZuoraObject {

    /**
     * @return mixed
     */
    public function getBillingDay()
    {
        return $this->billingDay;
    }

    /**
     * @return mixed
     */
    public function getBillingPeriod()
    {
        return $this->billingPeriod;
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
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getPricingSummary()
    {
        return $this->pricingSummary;
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
    public function getType()
    {
        return $this->type;
    }

} 