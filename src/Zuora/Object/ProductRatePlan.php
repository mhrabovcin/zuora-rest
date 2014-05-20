<?php

namespace Zuora\Object;


class ProductRatePlan extends Object {

    /**
     * Zuora id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Rate plan name, up to 50 characters
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Rate plan description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Rate plan status
     *
     * @return string {Active, Expired, NotStarted}
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * First date the rate plan is active (i.e., available to be subscribed to), as yyyy-mm-dd.
     * Before this date, the status is NotStarted.
     *
     * @return string yyyy-mm-dd
     */
    public function getEffectiveStartDate()
    {
        return $this->effectiveStartDate;
    }

    /**
     * Final date the rate plan is active, as yyyy-mm-dd. After this date, the rate plan status is Expired.
     *
     * @return string yyyy-mm-dd
     */
    public function getEffectiveEndDate()
    {
        return $this->effectiveEndDate;
    }

    /**
     * Get all rate plan charges
     *
     * @return ProductRatePlanCharge[]
     */
    public function getRatePlanCharges()
    {
        return $this->map('productRatePlanCharges', '\Zuora\Object\ProductRatePlanCharge');
    }
} 