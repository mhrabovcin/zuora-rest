<?php

namespace Zuora\Test;

use Zuora\Client;
use Zuora\Http\RequestInterface;
use Zuora\Http\Response;

class ResponseTest extends Base
{
    /**
     * Tests Response pagination and class mapping
     */
    public function testResponseMethods()
    {
        $environment = $this->getEnvironment();

        $response_data = [
            'success' => true,
            'creditCards' => [
                ['id' => md5(rand())],
            ],
            'nextPage' => $environment->getUrl('accounts') . '?page=2',
        ];

        $http_response = new Response();
        $http_response->setData($response_data)
            ->setCode(200)
            ->setHeaders([]);

        $next_response = new Response();
        $next_response->setCode(200)
            ->setHeaders([])
            ->setData(['nextPage' => $environment->getUrl('accounts') . '?page=3'] + $response_data);


        $request = $this->createMock(RequestInterface::class);
        $request->expects($this->once())
            ->method('call')
            ->with(
                $this->equalTo($environment->getUrl('accounts')),
                $this->equalTo('GET'),
                $this->equalTo(['page' => 2]),
                $this->anything(),
                $this->equalTo([
                    'apiAccessKeyId' => $environment->getUsername(),
                    'apiSecretAccessKey' => $environment->getPassword(),
                ])
            )
            ->will($this->returnValue($next_response));

        $client = new Client($environment, $request);

        $response = new \Zuora\Response($http_response, $client);

        $next = $response->nextPage();
        $this->assertEquals($next->getData(), $next_response->getData());

        $cards = $response->map('creditCards', '\Zuora\Object\CreditCard');
        $this->assertIsArray($cards);

        $response = new \Zuora\Response($http_response->setData([]), $client);
        $this->assertNull($response->nextPage());
    }
}
