<?php

namespace Zuora\Test;

use Zuora\Client;
use Zuora\Http\RequestInterface;
use Zuora\Http\Response;

class ClientTest extends \Zuora\Test\Base {


    /**
     * Test cURL error
     *
     * @expectedException \Zuora\Exception\ResponseException
     */
    public function testClientErrorCurlResponse()
    {

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
     * @expectedException \Zuora\Exception\ResponseException
     */
    public function testClientApiErrorResponse() {
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
     * @expectedException \Zuora\Exception\ApiException
     */
    public function testClientLogicErrorResponse()
    {
        $environment = $this->getEnvironment();
        $error_response = new Response();
        $error_response->setCode(200)
            ->setData(array(
               'success' => false,
               'processId' => '3F7EA3FD706C7E7C',
               'reasons' => array(
                  array('code' => 53100020, 'message' => ' {com.zuora.constraints.either_or_both}',),
                  array('code' => 53100320, 'message' => "'termType' value should be one of: TERMED, EVERGREEN",)
               )
            ));

        $request = $this->createMock(RequestInterface::class);
        $request->expects($this->once())
           ->method('call')
           ->will($this->returnValue($error_response));

        $client = new Client($environment, $request);
        $client->request('test');

    }
} 