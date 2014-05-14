<?php

namespace Zuora\Object;


class SubscriptionRatePlan extends Object {

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
     * Get Subscription rate plan charges
     *
     * @return \Zuora\Object\SubscriptionRatePlanCharge[]
     */
    public function getRatePlanCharges()
    {
        return $this->map('ratePlanCharges', '\Zuora\Object\SubscriptionRatePlanCharge');
    }

    /**
     * @return mixed
     */
    public function getRatePlanName()
    {
        return $this->ratePlanName;
    }

} 