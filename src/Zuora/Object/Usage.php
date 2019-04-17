<?php


namespace Zuora\Object;


class Usage extends ZuoraObject {

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
    public function getChargeNumber()
    {
        return $this->chargeNumber;
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
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @return mixed
     */
    public function getSourceName()
    {
        return $this->sourceName;
    }

    /**
     * @return mixed
     */
    public function getStartDateTime()
    {
        return $this->startDateTime;
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
    public function getSubmissionDateTime()
    {
        return $this->submissionDateTime;
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
    public function getUnitOfMeasure()
    {
        return $this->unitOfMeasure;
    }

} 