<?php

namespace Zuora\Object;

class Product extends ZuoraObject
{
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
     * @return \Zuora\Object\ProductRatePlan[]
     */
    public function getRatePlans()
    {
        return $this->map('productRatePlans', ProductRatePlan::class);
    }
}
