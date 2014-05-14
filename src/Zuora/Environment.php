<?php

namespace Zuora;

class Environment {

    /**
     * Endpoint URL.
     *
     * @var string
     */
    protected $endpoint = 'https://apisandbox-api.zuora.com/rest';

    /**
     * @var string
     */
    protected $version = '1';

    /**
     * Username
     *
     * @var string
     */
    protected $username;

    /**
     * Password
     *
     * @var string
     */
    protected $password;

    /**
     * Create new environemnt.
     *
     * @param array $options
     *   array(
     *     'username' => 'email@example.com',
     *     'password' => 'secretpassword',
     *     'endpoint' => 'https://endpoint.com/rest',
     *     'version' => '1',
     *   )
     *
     * @return Environment
     */
    public static function factory($options) {
        $environment = new static();

        if (isset($options['endpoint'])) {
            $environment->setEndpoint($options['endpoint']);
        }

        if (isset($options['version'])) {
            $environment->setVersion($options['version']);
        }

        if (isset($options['username'])) {
            $environment->setUsername($options['username']);
        }

        if (isset($options['password'])) {
            $environment->setPassword($options['password']);
        }

        return $environment;
    }

    /**
     * @param string $endpoint
     */
    public function setEndpoint($endpoint)
    {
        $this->endpoint = $endpoint;
    }

    /**
     * @return string
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $version
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Retrieve full endpoint URL for specified path.
     *
     * @param string $path
     *
     * @return string
     */
    public function getUrl($path = '')
    {
        return $this->getEndpoint() . '/v' . $this->getVersion() . '/' . $path;
    }

} 