<?php

namespace Zuora;

use Zuora\Exception\Exception;
use Zuora\Http\RequestInterface;

class Client
{
    /**
     * Holds environment information
     *
     * @var \Zuora\Environment
     */
    protected $environment;

    /**
     * HTTP request caller
     *
     * @var \Zuora\Http\RequestInterface
     */
    private $request;

    /**
     * Constructor
     *
     * @param \Zuora\Environment $environment
     * @param \Zuora\Http\RequestInterface $request
     */
    function __construct(Environment $environment, RequestInterface $request)
    {
        $this->environment = $environment;
        $this->request = $request;
    }

    /**
     * Initialize client from options array.
     *
     * @param array $options
     *   Options passed to \Zuora\Environment
     *
     * @return static
     */
    public static function factory($options = array())
    {
        return new static(Environment::factory($options), new \Zuora\Http\Request());
    }

    /**
     * Get current client environment
     *
     * @return \Zuora\Environment
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

    /**
     * Make API request
     *
     * @param string $path
     *   Path to method without http and api version prefix. I.e. 'connections'
     *
     * @param string $method
     *   HTTP method name - 'GET', 'POST', ...
     *
     * @param array $query
     *   URL query
     *
     * @param array $data
     *   POST data
     *
     * @return Response
     */
    public function request($path, $method = 'GET', $query = array(), $data = array(), $files = array())
    {
        $url = $this->getEnvironment()->getUrl($path);
        $headers = $this->getAuthHeaders();
        $response = $this->request->call($url, $method, $query, $data, $headers, $files);

        if ($response->isError()) {
            throw new \Zuora\Exception\ResponseException($response);
        }

        // Zuora specific when HTTP code is 200 but result isn't successful
        $data = $response->getData();
        if (isset($data['success']) && !$data['success']) {
            throw new \Zuora\Exception\ApiException($response);
        }

        return new Response($response, $this);
    }

    /**
     * Retrieve default request authentication headers.
     *
     * @return array
     */
    protected function getAuthHeaders()
    {
        return array(
           'apiAccessKeyId' => $this->environment->getUsername(),
           'apiSecretAccessKey' => $this->environment->getPassword(),
        );
    }

    /**
     * Query Zuora and retrieve all paginated results
     *
     * @param string $path
     *   Zuora API path
     *
     * @param string $key
     *   Result array key
     *
     * @param string $classname
     *   Class name to which should be results mapped
     *
     * @param array $query
     *   (Optional) Additional query params
     *
     * @return array
     */
    protected function getPaginatedObjects($path, $key, $classname, $query = array())
    {
        $objects = array();

        $response = $this->request($path, 'GET', $query);
        do {
            $objects = array_merge($objects, $response->map($key, $classname));
        } while ($response = $response->nextPage());

        return $objects;
    }

    /**
     * All products in catalog
     *
     * @return \Zuora\Object\Product[]
     */
    public function getCatalog()
    {
        return $this->getPaginatedObjects('catalog/products', 'products', '\Zuora\Object\Product');
    }

    /**
     * Get Account
     *
     * @param string $id
     *   Zuora account id
     *
     * @return \Zuora\Object\Account
     */
    public function getAccount($id)
    {
        $response = $this->request('accounts/' . $id);
        return new \Zuora\Object\Account($response->getData());
    }

    /**
     * Get Account Summary with recent 6 months data
     *
     * @param string $id
     *   Zuora account id
     *
     * @return \Zuora\Object\AccountSummary
     */
    public function getAccountSummary($id)
    {
        $response = $this->request('accounts/' . $id . '/summary');
        return new \Zuora\Object\AccountSummary($response->getData());
    }


    /**
     * Retrieve account subscriptions
     *
     * @param string $id
     *   Zuora account id
     *
     * @return \Zuora\Object\Subscription[]
     */
    public function getAccountSubscriptions($id)
    {
        return $this->getPaginatedObjects('subscriptions/accounts/' . $id, 'subscriptions', '\Zuora\Object\Subscription');
    }

    /**
     * Retrieve account credit cards
     *
     * @param string $id
     *
     * @return \Zuora\Object\CreditCard[]
     */
    public function getCreditCards($id)
    {
        return $this->getPaginatedObjects('payment-methods/credit-cards/accounts/' . $id, 'creditCards', '\Zuora\Object\CreditCard', array('pageSize' => 50));
    }

    /**
     * Retrieve all account invoices
     *
     * @param string $id
     *   Zuora account identifier
     *
     * @return \Zuora\Object\Invoice[]
     */
    public function getInvoices($id)
    {
        return $this->getPaginatedObjects('transactions/invoices/accounts/' . $id, 'invoices', '\Zuora\Object\Invoice', array('pageSize' => 50));
    }

    /**
     * Retrieve all account payments
     *
     * @param string $id
     *   Zuora account identifier
     *
     * @return \Zuora\Object\Payment[]
     */
    public function getPayments($id)
    {
        return $this->getPaginatedObjects('transactions/payments/accounts/' . $id, 'payments', '\Zuora\Object\Payment', array('pageSize' => 50));
    }

    /**
     * Subscription information
     *
     * @param string $id
     *
     * @return \Zuora\Object\Subscription
     */
    public function getSubscription($id)
    {
        $response = $this->request('subscriptions/' . $id);
        return new \Zuora\Object\Subscription($response->getData());
    }

    /**
     * Retrieve HMAC signature and token
     *
     * @param string $path
     *   Api valid path
     *
     * @param string $method
     *   HTTP valid method: GET, POST, PUT, DELETE, OPTIONS
     *
     * @param array $fields
     *   (Optional) Additional fields to sign
     *
     * @return \Zuora\Object\HmacSignature
     */
    public function getHmacSignatures($path, $method, $fields = array())
    {
        $data = array(
            'uri' => $this->getEnvironment()->getUrl($path),
            'method' => $method
        ) + $fields;

        $response = $this->request('hmac-signatures', 'POST', array(), $data);
        return new \Zuora\Object\HmacSignature($response->getData());
    }

    /**
     * Upload usage data
     *
     * Zuora support max 4 MB per file.
     *
     * @param string $file
     *   Path to file
     *
     * return \Zuora\Object\ImportStatus
     */
    public function uploadUsage($file)
    {
        if (filesize($file) > 4 * 1024 * 1024) {
            throw new Exception("File is larger than 4 MB.");
        }

        $response = $this->request('usage', 'POST', array(), array(), array('file' => $file));
        return new \Zuora\Object\UsageUploadResult($response->getData());
    }

    /**
     * Check import status
     *
     * @param string $id
     *
     * @return \Zuora\Object\ImportStatus
     */
    public function getUsageImportStatus($id) {
        $response = $this->request('usage/' . $id . '/status');
        return new \Zuora\Object\ImportStatus($response->getData());
    }

    /**
     * Get usage data for account.
     *
     * @param string $id
     *
     * @return \Zuora\Object\Usage[]
     */
    public function getUsage($id)
    {
        return $this->getPaginatedObjects('usage/accounts/' . $id, 'usage', '\Zuora\Object\Usage');
    }
}