<?php
/**
 * Created by PhpStorm.
 * User: mhrabovcin
 * Date: 09/05/14
 * Time: 22:09
 */

namespace Zuora\Object;


class ProductRatePlanCharge extends Object {

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
     * Name of the product rate-plan charge. (Not required to be unique.)
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * The type of charge. Possible value are: OneTime, Recurring, Usage.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Charge model which determines how charges are calculated.
     *
     * Charge models must be individually activated in Z-Billing administration.
     *
     * Possible values:
     * FlatFee, PerUnit, Overage, Volume, Tiered, TieredWithOverage, DiscountFixedAmount, DiscountPercentage
     *
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * A concise description of the charge model and prices, suitable for display to users.
     *
     * @return array
     */
    public function getPricingSummary()
    {
        return $this->pricingSummary;
    }

    /**
     * The bill cycle day (BCD) for the charge (1-31).
     *
     * The BCD determines which day of the month the customer is billed.
     * The BCD value in the account can override the BCD in this object.
     *
     * @return int
     */
    public function getBillingDay()
    {
        return $this->billingDay;
    }

    /**
     * The billing period for the charge. The start day of the billing period is also called the bill cycle day (BCD).
     *
     * Possible values:
     * Month, Quarter, Annual, Semi-Annual, Specific Months
     *
     * @return string
     */
    public function getBillingPeriod()
    {
        return $this->billingPeriod;
    }

    /**
     * Specifies the tax code for taxation rules; used by Z-Tax.
     *
     * @return string
     */
    public function getTaxCode()
    {
        return $this->taxCode;
    }

    /**
     * Specifies how to define taxation for the charge; used by Z-Tax.
     *
     * Possible values:
     * TaxExclusive, TaxInclusive
     *
     * @return string
     */
    public function getTaxMode()
    {
        return $this->taxMode;
    }

    /**
     * Specifies whether the charge is taxable; used by Z-Tax.
     *
     * @return bool
     */
    public function getTaxable()
    {
        return $this->taxable;
    }

} 