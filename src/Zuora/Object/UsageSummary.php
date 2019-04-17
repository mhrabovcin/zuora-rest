<?php

namespace Zuora\Object;


class UsageSummary extends ZuoraObject {

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
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @return mixed
     */
    public function getUnitOfMeasure()
    {
        return $this->unitOfMeasure;
    }

} 