<?php
/**
 * Created by PhpStorm.
 * User: mhrabovcin
 * Date: 10/05/14
 * Time: 13:46
 */

namespace Zuora\Object;


class UsageSummary extends Object {

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