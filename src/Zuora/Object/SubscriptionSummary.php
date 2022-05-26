<?php

namespace Zuora\Object;

class SubscriptionSummary extends ZuoraObject
{
    /**
     * @return mixed
     */
    public function getAutoRenew()
    {
        return $this->autoRenew;
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
    public function getInitialTerm()
    {
        return $this->initialTerm;
    }

    /**
     * @return mixed
     */
    public function getRatePlans()
    {
        return $this->ratePlans;
    }

    /**
     * @return mixed
     */
    public function getRenewalTerm()
    {
        return $this->renewalTerm;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return mixed
     */
    public function getSubscriptionNumber()
    {
        return $this->subscriptionNumber;
    }

    /**
     * @return mixed
     */
    public function getSubscriptionStartDate()
    {
        return $this->subscriptionStartDate;
    }

    /**
     * @return mixed
     */
    public function getTermEndDate()
    {
        return $this->termEndDate;
    }

    /**
     * @return mixed
     */
    public function getTermStartDate()
    {
        return $this->termStartDate;
    }

    /**
     * @return mixed
     */
    public function getTermType()
    {
        return $this->termType;
    }
}
