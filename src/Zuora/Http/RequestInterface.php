<?php
/**
 * Created by PhpStorm.
 * User: mhrabovcin
 * Date: 09/05/14
 * Time: 15:51
 */

namespace Zuora\Http;


interface RequestInterface {

    /**
     * Make HTTP Request via cURL
     *
     * @param string $url
     *   Request full URL in format 'http://www.example.com/endpoint'
     * @param string $method
     *   HTTP method name
     * @param array $query
     *   URL Query data.
     * @param array $data
     *   HTTP Request data.
     * @param array $headers
     *   Optionally additional headers.
     *   Headers can be in format
     *     array(
     *      'X-Custom-Header' => 'Value',
     *     )
     * @param array $files
     *   Files array that should be sent in request
     *
     * @return Response
     */
    public function call($url, $method = 'GET', $query = array(), $data = array(), $headers = array(), $files = array());

} 