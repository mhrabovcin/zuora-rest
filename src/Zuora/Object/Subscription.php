<?php

namespace Zuora\Object;

class Subscription extends ZuoraObject
{
    /**
     * @return mixed
     */
    public function getAccountId()
    {
        return $this->accountId;
    }

    /**
     * @return mixed
     */
    public function getAccountName()
    {
        return $this->accountName;
    }

    /**
     * @return mixed
     */
    public function getAccountNumber()
    {
        return $this->accountNumber;
    }

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
    public function getContractEffectiveDate()
    {
        return $this->contractEffectiveDate;
    }

    /**
     * @return mixed
     */
    public function getContractedMrr()
    {
        return $this->contractedMrr;
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
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Subscription rate plans
     *
     * @return \Zuora\Object\SubscriptionRatePlan[]
     */
    public function getRatePlans()
    {
        return $this->map('ratePlans', '\Zuora\Object\SubscriptionRatePlan');
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
    public function getSuccess()
    {
        return $this->success;
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

    /**
     * @return mixed
     */
    public function getTotalContractedValue()
    {
        return $this->totalContractedValue;
    }
}
