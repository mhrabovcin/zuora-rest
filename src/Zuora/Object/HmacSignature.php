<?php

namespace Zuora\Object;


class HmacSignature extends Object {

    /**
     * @return mixed
     */
    public function getSignature()
    {
        return $this->signature;
    }

    /**
     * @return mixed
     */
    public function getSuccess()
    {
        return $this->success;
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }
} 