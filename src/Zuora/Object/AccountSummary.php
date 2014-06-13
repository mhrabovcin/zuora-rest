<?php

namespace Zuora\Object;


class AccountSummary extends Account {

    protected function getAllowedKeys()
    {
        return array_merge(array('subscriptions', 'invoices', 'payments', 'usage'), parent::getAllowedKeys());
    }

    public function getSubscriptions()
    {
        return $this->map('subscriptions', '\Zuora\Object\SubscriptionSummary');
    }

    public function getUsage()
    {
        return $this->map('usage', '\Zuora\Object\UsageSummary');
    }

    public function getInvoices()
    {
        return $this->map('invoices', '\Zuora\Object\InvoiceSummary');
    }

    public function getPayments()
    {
        return $this->map('payments', '\Zuora\Object\PaymentSummary');
    }

    public function getDefaultPaymentMethod() {
        return new DefaultPaymentMethod($this->defaultPaymentMethod);
    }

} 