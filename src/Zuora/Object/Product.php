<?php
/**
 * Created by PhpStorm.
 * User: mhrabovcin
 * Date: 09/05/14
 * Time: 21:28
 */

namespace Zuora\Object;


class Product extends Object {

    public function getId()
    {
        return $this->id;
    }

    public function getSku()
    {
        return $this->sku;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getName()
    {
        return $this->name;
    }

    /**
     * @return ProductRatePlan[]
     */
    public function getRatePlans()
    {
        return $this->map('productRatePlans', '\Zuora\Object\ProductRatePlan');
    }
} 