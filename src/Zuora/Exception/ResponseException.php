<?php

namespace Zuora\Exception;


use Zuora\Http\Response;

class ResponseException extends Exception {


    /**
     * Http response object.
     *
     * @var Response
     */
    protected $response;


    /**
     * Http reseponse exception.
     *
     * @param Response $response
     */
    function __construct(Response $response)
    {
        $this->response = $response;
    }

    /**
     * @return \Zuora\Http\Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    public function __toString()
    {
        $response = $this->getResponse();
        $message = array();

        if ($response->getCode()) {
            $message[] = $response->getCode();
        }

        if ($response->getErrorCode()) {
            $message[] = '(' . $response->getErrorCode() . ')';
        }

        if ($response->getErrorMessage()) {
            $message[] = $response->getErrorMessage();
        }

        if (!empty($message)) {
            return implode(' ', $message);
        }
        else {
            return parent::__toString();
        }
    }

    public function getData()
    {
        return $this->getResponse()->getData();
    }
}