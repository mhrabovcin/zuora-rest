<?php

namespace Zuora\Test\Http;

use Zuora\Http\Response;

class ResponseTest extends \PHPUnit_Framework_TestCase {

    protected function getTestOkResponse()
    {
        return "HTTP/1.1 200 OK\r\n"
              ."Date: Mon, 01 Apr 2013 01:39:16 GMT\r\n"
              ."Content-Length: 24768\r\n"
              ."Content-Type: application/json;charset=utf-8\r\n"
              ."Connection: close\r\n"
              ."Server: Apache-Coyote/1.1\r\n\r\n"
              .'{"success": true}';
    }

    protected function getTestCookieResponse()
    {
        return "HTTP/1.1 200 OK\r\n"
            ."Date: Mon, 01 Apr 2013 01:39:16 GMT\r\n"
            ."Content-Length: 24768\r\n"
            ."Content-Type: application/json;charset=utf-8\r\n"
            ."Connection: close\r\n"
            ."Set-Cookie: name=value\r\n"
            ."Set-Cookie: name2=value2\r\n"
            ."Server: Apache-Coyote/1.1\r\n\r\n"
            .'{"success": true}';
    }

    public function testResponseParser()
    {
        $response = Response::fromString($this->getTestOkResponse());
        $this->assertEquals($response->getCode(), 200);
        $this->assertEquals($response->getData(), '{"success": true}');
        $this->assertEquals($response->getCookies(), array());
    }

    public function testCookieParser()
    {
        $response = Response::fromString($this->getTestCookieResponse());
        $cookies = $response->getCookies();
        $this->assertEquals(count($cookies), 2);
        $this->assertArrayHasKey('name', $cookies);
        $this->assertEquals($cookies['name'], 'value');
        $this->assertArrayHasKey('name2', $cookies);
        $this->assertEquals($cookies['name2'], 'value2');
    }

    public function testErrorDetection()
    {
        $response = Response::fromString($this->getTestOkResponse());
        $this->assertFalse($response->isError());

        $response->setCode(400);
        $this->assertTrue($response->isError());

        $response = new Response();
        $this->assertTrue($response->isError());

        $response = new Response();
        // Curl timeout
        $response->setErrorCode(68);
        $this->assertTrue($response->isError());
    }
} 