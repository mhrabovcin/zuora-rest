<?php

namespace Zuora\Test\Http;


use Zuora\Http\Request;

class RequestTest extends \Zuora\Test\Base {

    public function testRequestUrlHelpers()
    {
        $request = new Request();
        $this->assertEquals($this->invokeMethod($request, 'normalizeHttpMethod', array('get')), 'GET');

        $result = $this->invokeMethod($request, 'normalizeUrl', array('http://www.example.com'));
        $this->assertEquals($result[0], 'http://www.example.com');
        $this->assertEquals($result[1], null);

        // Test url with port
        $result = $this->invokeMethod($request, 'normalizeUrl', array('http://www.example.com:8080/index?q=1'));
        $this->assertEquals($result[0], 'http://www.example.com/index?q=1');
        $this->assertEquals($result[1], 8080);

        // Test url with provided query
        $result = $this->invokeMethod($request, 'normalizeUrl', array('http://www.example.com/index', array('q' => 1)));
        $this->assertEquals($result[0], 'http://www.example.com/index?q=1');
        $this->assertEquals($result[1], null);

        // Test query merging
        $result = $this->invokeMethod($request, 'normalizeUrl', array('http://www.example.com/index?a=1', array('q' => 1)));
        $this->assertEquals($result[0], 'http://www.example.com/index?a=1&q=1');
        $this->assertEquals($result[1], null);
    }

    public function testCurlOptions()
    {

        $url = 'http://www.example.com';
        $port = null;
        $method = 'GET';
        $data = array('data' => 'test');
        $headers = array('X-Custom' => 'value');
        $files = array('file' => '@/path/to/file');

        $request = new Request();
        $options = $this->invokeMethod($request, 'getCurlOptions', array($url));
        $this->assertEquals($options[CURLOPT_URL], $url);

        $port = 8000;
        $options = $this->invokeMethod($request, 'getCurlOptions', array($url, $port));
        $this->assertEquals($options[CURLOPT_PORT], $port);

        $options = $this->invokeMethod($request, 'getCurlOptions', array($url, $port, 'POST'));
        $this->assertEquals($options[CURLOPT_POST], 1);

        $options = $this->invokeMethod($request, 'getCurlOptions', array($url, $port, 'PUT'));
        $this->assertEquals($options[CURLOPT_CUSTOMREQUEST], 'PUT');

        $options = $this->invokeMethod($request, 'getCurlOptions', array($url, $port, 'DELETE'));
        $this->assertEquals($options[CURLOPT_CUSTOMREQUEST], 'DELETE');

        $options = $this->invokeMethod($request, 'getCurlOptions', array($url, $port, 'GET', $data));
        $this->assertEmpty($options[CURLOPT_POSTFIELDS]);

        $options = $this->invokeMethod($request, 'getCurlOptions', array($url, $port, 'POST', $data));
        $this->assertNotEmpty($options[CURLOPT_POSTFIELDS]);
        $this->assertContains('test', $options[CURLOPT_POSTFIELDS]);

        $options = $this->invokeMethod($request, 'getCurlOptions', array($url, $port, 'POST', $data, $headers));
        $this->assertEquals($options[CURLOPT_HTTPHEADER][0], 'X-Custom: value');

        $options = $this->invokeMethod($request, 'getCurlOptions', array($url, $port, 'POST', $data, $headers, $files));
        $this->assertInternalType('array', $options[CURLOPT_POSTFIELDS]);

        // Test custom curl options
        $request = new Request(array(
            'timeout' => 10,
            'ssl_verifypeer_skip' => true,
            'user_agent' => 'test'
        ));
        $options = $this->invokeMethod($request, 'getCurlOptions', array($url, $port, 'POST', $data));
        $this->assertEquals($options[CURLOPT_TIMEOUT], 10);
        $this->assertEquals($options[CURLOPT_USERAGENT], 'test');
        $this->assertEquals($options[CURLOPT_SSL_VERIFYHOST], false);
        $this->assertEquals($options[CURLOPT_SSL_VERIFYPEER], false);
    }

} 