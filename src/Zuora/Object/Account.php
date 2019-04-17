<?php

namespace Zuora\Object;


class Account extends ZuoraObject {

    function __construct($data = array())
    {
        $changed = $data['basicInfo'];

        foreach (array('metrics', 'billingAndPayment') as $key) {
            if (isset($data[$key])) {
                $changed[$key] = $data[$key];
            }
        }

        foreach ($this->getAllowedKeys() as $key) {
            $changed[$key] = $data[$key];
        }

        parent::__construct($changed);
    }

    /**
     * Which data key should be stored
     *
     * @return array
     */
    protected function getAllowedKeys()
    {
        return array('billToContact', 'soldToContact');
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
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * @return mixed
     */
    public function getCommunicationProfileId()
    {
        return $this->communicationProfileId;
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
    public function getCreditBalance()
    {
        return $this->creditBalance;
    }

    /**
     * @return mixed
     */
    public function getCrmId()
    {
        return $this->crmId;
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
    public function getInvoiceTemplateId()
    {
        return $this->invoiceTemplateId;
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
    public function getNotes()
    {
        return $this->notes;
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
    public function getTotalInvoiceBalance()
    {
        return $this->totalInvoiceBalance;
    }

    /**
     * @return mixed
     */
    public function getBillCycleDay()
    {
        return $this->billCycleDay;
    }

    /**
     * @return mixed
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @return mixed
     */
    public function getPaymentTerm()
    {
        return $this->paymentTerm;
    }

    public function getBillToContact()
    {
        return new \Zuora\Object\Contact($this->billToContact);
    }

    public function getSoldToContact()
    {
        return new \Zuora\Object\Contact($this->soldToContact);
    }


} 