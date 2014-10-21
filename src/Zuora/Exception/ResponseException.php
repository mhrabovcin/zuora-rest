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
     * Http response exception.
     *
     * @param Response $response
     */
    function __construct(Response $response)
    {
        $this->response = $response;
        parent::__construct($this->getMessageFromResponse());
    }

    /**
     * @return \Zuora\Http\Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    public function getMessageFromResponse()
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

        return implode(' ', $message);
    }

    public function __toString()
    {
        if ($message = $this->getMessageFromResponse()) {
            return $message;
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