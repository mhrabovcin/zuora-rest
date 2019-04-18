<?php

namespace Zuora\Test\Exception;

use PHPUnit\Framework\TestCase;
use Zuora\Exception\ResponseException;
use Zuora\Http\Response;

class ResponseExceptionTest extends TestCase
{

    public function testResponseException()
    {
        $response = new Response();
        $response->setData('test');
        $exception = new ResponseException($response);

        $this->assertEquals($response->getData(), $exception->getData());
        // Test default stack trace
        $this->assertContains('Stack trace', $exception->__toString());

        // HTTP code
        $response->setCode(400);
        $this->assertEquals($exception->__toString(), '400');
        $response->setCode(0);

        // cURL code
        $response->setErrorCode(68);
        $this->assertEquals($exception->__toString(), '(68)');
        $response->setErrorCode(0);

        // cURL message
        $response->setErrorMessage('remote host timed out');
        $this->assertContains($response->getErrorMessage(), $exception->__toString());

        $this->assertContains($response->getErrorMessage(), $exception->getMessageFromResponse());
    }
} 