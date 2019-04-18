<?php

namespace Zuora;

use Zuora\Object\ZuoraObject;

class Response
{
    /**
     * @var \Zuora\Http\Response
     */
    protected $response;

    /**
     * @var \Zuora\Client
     */
    protected $client;

    /**
     * Constructor
     *
     * @param \Zuora\Http\Response $response
     *   HTTP response object
     *
     * @param \Zuora\Client $client
     *   Initialized client class
     */
    public function __construct(\Zuora\Http\Response $response, Client $client)
    {
        $this->response = $response;
        $this->client = $client;
    }

    /**
     * Retrieve raw response data.
     *
     * @return array
     */
    public function getData()
    {
        return $this->response->getData();
    }

    /**
     * Map current result set to specific class
     *
     * @param string $entity
     *   Name of entity in result array.
     *
     * @param string $classname
     *   Name of class
     *
     * @return array
     *   Mapped to objects optionally by key.
     */
    public function map($entity, $classname)
    {
        $data = $this->response->getData();
        $object = new ZuoraObject($data);
        return $object->map($entity, $classname);
    }

    /**
     * For paged response fetch next result
     *
     * @return \Zuora\Response|null
     *
     * @throws \Zuora\Exception\ApiException
     * @throws \Zuora\Exception\ResponseException
     */
    public function nextPage()
    {

        $data = $this->response->getData();

        if (isset($data['nextPage'])) {
            if (false !== strpos($data['nextPage'], $this->client->getEnvironment()->getUrl(''))) {
                $url = substr($data['nextPage'], strlen($this->client->getEnvironment()->getUrl('')));
                $url = parse_url($url);
                $path = $url['path'];
                parse_str($url['query'], $query);
                return $this->client->request($path, 'GET', $query);
            }
        }

        return null;
    }
}
