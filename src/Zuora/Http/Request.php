<?php

// @TODO: Replace with Guzzle 3.x library?

namespace Zuora\Http;


class Request implements RequestInterface
{

    /**
     * cURL options that will be added to each request.
     *
     * @var array
     */
    protected $curl_options;

    /**
     * Constructor
     *
     * @param array $curl_options
     *   Additional request options
     *   - timeout : Request max time
     *   - ssl_verifypeer_skip : Skip ssl verification
     *   - user_agent : Override user-agent name
     */
    function __construct($curl_options = array())
    {
        // Add default options
        $this->curl_options = $curl_options + array(
            'timeout' => 5,
            'ssl_verifypeer_skip' => false,
            'user_agent' => 'Zuora PHP Client/0.1',
        );
    }

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
     *   Local files list that should be sent with request
     *
     * @return Response
     */
    public function call($url, $method = 'GET', $query = array(), $data = array(), $headers = array(), $files = array())
    {
        // Normalize HTTP method name
        $method = $this->normalizeHttpMethod($method);

        // Zuora API talks in JSON
        $headers += array(
            'Accept' => 'application/json',
        );

        // If sending files, app should be not json
        if (empty($files)) {
            $headers['Content-Type'] = 'application/json';
        }
        else {
            $files = array_map(function ($item) {
                return '@' . $item;
            }, $files);
        }

        // URL can contain port, make sure its processed correctly.
        list($url, $port) = $this->normalizeUrl($url, $query);

        $opts = $this->getCurlOptions($url, $port, $method, $data, $headers, $files);

        // Prepare curl channel.
        $ch = curl_init();
        curl_setopt_array($ch, $opts);
        $raw = curl_exec($ch);

        // Parse response
        $response = Response::fromString($raw);

        if ($data = $response->getData()) {
            $response->setData(json_decode($data, true));
        }

        // Add curl errors
        if (!$response->getCode()) {
            $response->setErrorCode(curl_errno($ch));
            $response->setErrorMessage(curl_error($ch));
        }

        // Close channel
        curl_close($ch);

        return $response;
    }

    /**
     * Generate cURL options array that can be set using curl_setopt_array
     *
     * @param string $url
     *   Requested url with query params
     *
     * @param int|null $port
     *   (Optional) Port number
     *
     * @param string $method
     *   (Optional) HTTP method
     *
     * @param array $data
     *   (Optional) Data array
     *
     * @param array $headers
     *   (Optional) Request headers
     *
     * @param array $files
     *   (Optional) Files to send
     */
    protected function getCurlOptions($url, $port = null, $method = 'GET', $data = array(), $headers = array(), $files = array())
    {
        // Default options for every CURL request
        $opts = array(
           CURLOPT_URL => $url,
           CURLOPT_RETURNTRANSFER => true,
           CURLOPT_TIMEOUT => $this->curl_options['timeout'],
           CURLOPT_HTTPHEADER => array(),
           CURLOPT_HEADER => true,
           CURLINFO_HEADER_OUT => true,
           CURLOPT_USERAGENT => $this->curl_options['user_agent'],
        );

        if (isset($port)) {
            $opts[CURLOPT_PORT] = $port;
        }

        if (!empty($files)) {
            $opts[CURLOPT_POSTFIELDS] = $files + $data;;
        }
        elseif (!empty($data) && $method != 'GET') {
            $opts[CURLOPT_POSTFIELDS] = json_encode($data);
        }

        // Add method specific cURL options
        if ($method == 'POST' && !is_array($opts[CURLOPT_POSTFIELDS])) {
            $opts[CURLOPT_POST] = 1;
        }
        elseif (in_array($method, array('DELETE', 'PUT'))) {
            $opts[CURLOPT_CUSTOMREQUEST] = $method;
        }

        // Add headers
        foreach ($headers as $name => $value) {
            $opts[CURLOPT_HTTPHEADER][] = $name . ': ' . $value;
        }

        // Optionally we can skip SSL verification
        if ($this->curl_options['ssl_verifypeer_skip']) {
            $opts[CURLOPT_SSL_VERIFYPEER] = false;
            $opts[CURLOPT_SSL_VERIFYHOST] = false;
        }

        return $opts;
    }

    /**
     * Normalize HTTP method to GET, POST, etc..
     *
     * @param string $method
     *
     * @return string
     */
    protected function normalizeHttpMethod($method)
    {
        return trim(strtoupper($method));
    }

    /**
     * Normalize URL to url and port number.
     *
     * @param string $url
     *   Base URL
     *
     * @param array $query
     *   Additional query options
     *
     * @return array
     *   Array where 0 key is normalized URL and 1 is port if was specified in URL
     */
    protected function normalizeUrl($url, $query = array())
    {
        // URL can contain port, make sure its processed correctly.
        $parsed_url = parse_url($url);

        // Build base URL without port
        $url = "{$parsed_url['scheme']}://{$parsed_url['host']}{$parsed_url['path']}";

        // If url string contained query options add query
        if (isset($parsed_url['query'])) {
            $url .= '?' . $parsed_url['query'];
        }

        // If additional query array was passed add to final URL
        if (!empty($query)) {
            $url .= strpos($url, '?') === false ? '?' : '&';
            $url .= http_build_query($query, null, '&');
        }

        return array($url, isset($parsed_url['port']) ? $parsed_url['port'] : NULL);
    }
}