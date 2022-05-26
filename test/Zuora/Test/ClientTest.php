<?php

namespace Zuora\Test;

use Zuora\Client;
use Zuora\Exception\ApiException;
use Zuora\Exception\ResponseException;
use Zuora\Http\RequestInterface;
use Zuora\Http\Response;

class ClientTest extends Base
{
    /**
     * Test cURL error
     */
    public function testClientErrorCurlResponse()
    {
        $this->expectException(ResponseException::class);

        $environment = $this->getEnvironment();
        $error_response = new Response();
        $error_response->setCode(0)
            ->setErrorCode(68)
            ->setErrorMessage("connection to host timed out");

        $request = $this->createMock(RequestInterface::class);
        $request->expects($this->once())
            ->method('call')
            ->will($this->returnValue($error_response));

        $client = new Client($environment, $request);
        $client->request('test');
    }

    /**
     * Test HTTP response error
     *
     *
     */
    public function testClientApiErrorResponse()
    {
        $this->expectException(ResponseException::class);

        $environment = $this->getEnvironment();
        $error_response = new Response();
        $error_response->setCode(400);

        $request = $this->createMock(RequestInterface::class);
        $request->expects($this->once())
           ->method('call')
           ->will($this->returnValue($error_response));

        $client = new Client($environment, $request);
        $client->request('test');
    }

    /**
     * Test zuora response error
     *
     *
     */
    public function testClientLogicErrorResponse()
    {
        $this->expectException(ApiException::class);

        $environment = $this->getEnvironment();
        $error_response = new Response();
        $error_response->setCode(200)
            ->setData([
               'success' => false,
               'processId' => '3F7EA3FD706C7E7C',
               'reasons' => [
                  ['code' => 53100020, 'message' => ' {com.zuora.constraints.either_or_both}',],
                  ['code' => 53100320, 'message' => "'termType' value should be one of: TERMED, EVERGREEN",]
               ]
            ]);

        $request = $this->createMock(RequestInterface::class);
        $request->expects($this->once())
           ->method('call')
           ->will($this->returnValue($error_response));

        $client = new Client($environment, $request);
        $client->request('test');
    }
}
