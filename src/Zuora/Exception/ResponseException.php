<?php

namespace Zuora\Exception;

use Zuora\Http\Response;

class ResponseException extends Exception
{
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
    public function __construct(Response $response)
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

    /**
     * Create single line message from exception.
     *
     * @return string
     */
    public function getMessageFromResponse()
    {
        $response = $this->getResponse();
        $message = [];

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

    /**
     * Get exception data
     *
     * @return array
     */
    public function getData()
    {
        return $this->getResponse()->getData();
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        if ($message = $this->getMessageFromResponse()) {
            return $message;
        }
        return parent::__toString();
    }
}
