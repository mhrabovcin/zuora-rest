<?php

namespace Zuora;

use Zuora\Exception\ApiException;
use Zuora\Exception\Exception;
use Zuora\Exception\ResponseException;
use Zuora\Http\Request;
use Zuora\Http\RequestInterface;
use Zuora\Object\Account;
use Zuora\Object\AccountSummary;
use Zuora\Object\CreditCard;
use Zuora\Object\HmacSignature;
use Zuora\Object\ImportStatus;
use Zuora\Object\Invoice;
use Zuora\Object\Payment;
use Zuora\Object\Product;
use Zuora\Object\Subscription;
use Zuora\Object\Usage;
use Zuora\Object\UsageUploadResult;

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
    public function __construct(Environment $environment, RequestInterface $request)
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
     * @param array $request_options
     *   Options passed to \Zuora\Http\Request
     *
     * @return static
     */
    public static function factory($options = [], $request_options = [])
    {
        return new static(Environment::factory($options), new Request($request_options));
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
     * @param array $files
     *   Files array that should be sent in request
     *
     * @return \Zuora\Response
     *
     * @throws \Zuora\Exception\ApiException
     * @throws \Zuora\Exception\ResponseException
     */
    public function request($path, $method = 'GET', $query = [], $data = [], $files = [])
    {
        $url = $this->getEnvironment()->getUrl($path);
        $headers = $this->getAuthHeaders();
        $response = $this->request->call($url, $method, $query, $data, $headers, $files);

        if ($response->isError()) {
            throw new ResponseException($response);
        }

        // Zuora specific when HTTP code is 200 but result isn't successful
        $data = $response->getData();
        if (isset($data['success']) && !$data['success']) {
            throw new ApiException($response);
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
        return [
            'apiAccessKeyId' => $this->environment->getUsername(),
            'apiSecretAccessKey' => $this->environment->getPassword(),
        ];
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
     *
     * @throws \Zuora\Exception\ApiException
     * @throws \Zuora\Exception\ResponseException
     */
    protected function getPaginatedObjects($path, $key, $classname, $query = [])
    {
        $objects = [];

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
     *
     * @throws \Zuora\Exception\ApiException
     * @throws \Zuora\Exception\ResponseException
     */
    public function getCatalog()
    {
        return $this->getPaginatedObjects('catalog/products', 'products', Product::class);
    }

    /**
     * Get Account
     *
     * @param string $id
     *   Zuora account id
     *
     * @return \Zuora\Object\Account
     *
     * @throws \Zuora\Exception\ApiException
     * @throws \Zuora\Exception\ResponseException
     */
    public function getAccount($id)
    {
        $response = $this->request('accounts/' . $id);
        return new Account($response->getData());
    }

    /**
     * Get Account Summary with recent 6 months data
     *
     * @param string $id
     *   Zuora account id
     *
     * @return \Zuora\Object\AccountSummary
     *
     * @throws \Zuora\Exception\ApiException
     * @throws \Zuora\Exception\ResponseException
     */
    public function getAccountSummary($id)
    {
        $response = $this->request('accounts/' . $id . '/summary');
        return new AccountSummary($response->getData());
    }

    /**
     * Retrieve account subscriptions
     *
     * @param string $id
     *   Zuora account id
     *
     * @return \Zuora\Object\Subscription[]
     *
     * @throws \Zuora\Exception\ApiException
     * @throws \Zuora\Exception\ResponseException
     */
    public function getAccountSubscriptions($id)
    {
        return $this->getPaginatedObjects('subscriptions/accounts/' . $id, 'subscriptions', Subscription::class);
    }

    /**
     * Retrieve account credit cards
     *
     * @param string $id
     *
     * @return \Zuora\Object\CreditCard[]
     *
     * @throws \Zuora\Exception\ApiException
     * @throws \Zuora\Exception\ResponseException
     */
    public function getCreditCards($id)
    {
        return $this->getPaginatedObjects(
            'payment-methods/credit-cards/accounts/' . $id,
            'creditCards',
            CreditCard::class,
            ['pageSize' => 50]
        );
    }

    /**
     * Retrieve all account invoices
     *
     * @param string $id
     *   Zuora account identifier
     *
     * @return \Zuora\Object\Invoice[]
     *
     * @throws \Zuora\Exception\ApiException
     * @throws \Zuora\Exception\ResponseException
     */
    public function getInvoices($id)
    {
        return $this->getPaginatedObjects(
            'transactions/invoices/accounts/' . $id,
            'invoices',
            Invoice::class,
            ['pageSize' => 50]
        );
    }

    /**
     * Retrieve all account payments
     *
     * @param string $id
     *   Zuora account identifier
     *
     * @return \Zuora\Object\Payment[]
     *
     * @throws \Zuora\Exception\ApiException
     * @throws \Zuora\Exception\ResponseException
     */
    public function getPayments($id)
    {
        return $this->getPaginatedObjects(
            'transactions/payments/accounts/' . $id,
            'payments',
            Payment::class,
            ['pageSize' => 50]
        );
    }

    /**
     * Subscription information
     *
     * @param string $id
     *
     * @return \Zuora\Object\Subscription
     *
     * @throws \Zuora\Exception\ApiException
     * @throws \Zuora\Exception\ResponseException
     */
    public function getSubscription($id)
    {
        $response = $this->request('subscriptions/' . $id);
        return new Subscription($response->getData());
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
     *
     * @throws \Zuora\Exception\ApiException
     * @throws \Zuora\Exception\ResponseException
     */
    public function getHmacSignatures($path, $method, $fields = [])
    {
        $data = [
            'uri' => $this->getEnvironment()->getUrl($path),
            'method' => $method
        ] + $fields;

        $response = $this->request('hmac-signatures', 'POST', [], $data);
        return new HmacSignature($response->getData());
    }

    /**
     * Upload usage data
     *
     * Zuora support max 4 MB per file.
     *
     * @param string $file
     *   Path to file
     *
     * @return \Zuora\Object\UsageUploadResult
     *
     * @throws \Zuora\Exception\ApiException
     * @throws \Zuora\Exception\Exception
     * @throws \Zuora\Exception\ResponseException
     */
    public function uploadUsage($file)
    {
        if (filesize($file) > 4 * 1024 * 1024) {
            throw new Exception("File is larger than 4 MB.");
        }

        $response = $this->request('usage', 'POST', [], [], ['file' => $file]);
        return new UsageUploadResult($response->getData());
    }

    /**
     * Check import status
     *
     * @param string $id
     *
     * @return \Zuora\Object\ImportStatus
     * @throws \Zuora\Exception\ApiException
     * @throws \Zuora\Exception\ResponseException
     */
    public function getUsageImportStatus($id)
    {
        $response = $this->request('usage/' . $id . '/status');
        return new ImportStatus($response->getData());
    }

    /**
     * Get usage data for account.
     *
     * @param string $id
     *
     * @return \Zuora\Object\Usage[]
     *
     * @throws \Zuora\Exception\ApiException
     * @throws \Zuora\Exception\ResponseException
     */
    public function getUsage($id)
    {
        return $this->getPaginatedObjects('usage/accounts/' . $id, 'usage', Usage::class);
    }
}
