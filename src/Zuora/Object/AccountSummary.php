<?php
/**
 * Created by PhpStorm.
 * User: mhrabovcin
 * Date: 10/05/14
 * Time: 12:40
 */

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
} 