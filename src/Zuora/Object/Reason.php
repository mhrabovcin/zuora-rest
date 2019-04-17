<?php
/**
 * Created by PhpStorm.
 * User: mhrabovcin
 * Date: 10/05/14
 * Time: 19:36
 */

namespace Zuora\Object;


class Reason extends ZuoraObject {

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

} 