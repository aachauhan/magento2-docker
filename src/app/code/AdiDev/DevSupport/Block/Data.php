<?php

namespace AdiDev\DevSupport\Block;

use Magento\Framework\View\Element\Template;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ResponseFactory;
use Magento\Framework\Webapi\Rest\Request;
use Magento\Framework\App\Response\Http;
use Magento\Framework\App\Response\HttpFactory;
use Magento\Framework\HTTP\Client\Curl;
use Magento\Framework\HTTP\ClientFactory;


class Data extends \Magento\Framework\View\Element\Template
{
     /**
     * API request URL
     */
    const API_REQUEST_URI = 'https://official-joke-api.appspot.com/random_joke';

    protected $httpClientFactory;

    /**
     * @var ResponseFactory
     */
    private $responseFactory;

    /**
     * @var ClientFactory
     */
    private $clientFactory;

    /**
     * @var Curl
     */
    private $curlClient;


    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        ClientFactory $httpClientFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->httpClientFactory = $httpClientFactory;
    }

    /**
     * Get API data
     *
     * @return array
     */
    public function getAPIData(): array
    {
        $httpClient = $this->httpClientFactory->create();
        $httpClient->setUri(self::API_REQUEST_URI);
        $httpClient->setMethod(\Zend\Http\Request::METHOD_GET);
        $response = $httpClient->request();
        $data = json_decode($response->getBody(), true);
        return $data;

    }
}