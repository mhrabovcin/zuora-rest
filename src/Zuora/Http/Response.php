<?php

namespace Zuora\Http;


class Response
{

    /**
     * HTTP Response code.
     *
     * @var int
     */
    protected $code;

    /**
     * HTTP Response data.
     *
     * @var array
     */
    protected $data;

    /**
     * CURL error code
     *
     * @var int
     */
    protected $error_code;

    /**
     * Response headers
     *
     * @var array
     */
    protected $headers = array();

    /**
     * Error message
     *
     * @var string
     */
    protected $error_message;

    /**
     * Response cookies.
     *
     * @var array
     */
    protected $cookies;

    /**
     * Set response code
     *
     * @param int $code
     *
     * @return Response
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return int
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set response data
     *
     * @param array $data
     *
     * @return Response
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param int $error_code
     *
     * @return $this
     */
    public function setErrorCode($error_code)
    {
        $this->error_code = $error_code;

        return $this;
    }

    /**
     * @return int
     */
    public function getErrorCode()
    {
        return $this->error_code;
    }

    /**
     * @param string $error_message
     */
    public function setErrorMessage($error_message)
    {
        $this->error_message = $error_message;

        return $this;
    }

    /**
     * @return string
     */
    public function getErrorMessage()
    {
        return $this->error_message;
    }

    /**
     * @param array $headers
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Retrieve list of cookies
     *
     * @return array
     */
    public function getCookies()
    {
        if (!isset($this->cookies)) {
            $this->cookies = array();
            foreach ($this->getHeaders() as $line) {
                if (preg_match('~^Set-Cookie:\s* (?<name>[^=]+)=(?<value>[^;]+).*$~', $line, $matches)) {
                    $this->cookies[$matches['name']] = $matches['value'];
                }
            }
        }

        return $this->cookies;
    }

    /**
     * Check if response is error
     *
     * @return bool
     */
    public function isError()
    {
        if (!empty($this->error_code)) {
            return true;
        }

        // Curl library error like timeout
        if (empty($this->code)) {
            return true;
        }

        // Api response error
        if ($this->code >= 400 && $this->code <= 600) {
            return true;
        }

        return false;
    }

    /**
     * Parse raw HTTP response string
     *
     * @param string $raw
     *   HTTP raw response
     *
     * @return \Zuora\Http\Response
     */
    public static function fromString($raw)
    {
        $response = new static();

        // Parse response to headers and body
        $pos = strrpos($raw, "\r\n\r\n");
        if (false !== $pos) {
            $headers = explode("\r\n", trim(substr($raw, 0, $pos)));
            if (preg_match('~^HTTP/1\.[01] (?<code>\d+).*$~i', $headers[0], $matches)) {
                array_shift($headers);
                $response->setCode($matches['code']);
            }
            $response->setHeaders($headers);
            $data = trim(substr($raw, $pos + 4));
            $response->setData($data);
        }

        return $response;
    }
} 