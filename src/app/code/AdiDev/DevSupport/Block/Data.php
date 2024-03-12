<?php

namespace AdiDev\DevSupport\Block;

use Magento\Framework\View\Element\Template;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\ClientFactory;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ResponseFactory;
use Magento\Framework\Webapi\Rest\Request;


class Data extends \Magento\Framework\View\Element\Template
{
     /**
     * API request URL
     */
    const API_REQUEST_URI = 'https://official-joke-api.appspot.com/';

    /**
     * API request endpoint
     */
    const API_REQUEST_ENDPOINT = 'random_joke/';

    /**
     * @var ResponseFactory
     */
    private $responseFactory;

    /**
     * @var ClientFactory
     */
    private $clientFactory;


    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        ClientFactory $clientFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->clientFactory = $clientFactory;
    }

    /**
     * Get API data
     *
     * @return array
     */
    public function getAPIData(): array
    {
        $response = $this->doRequest(static::API_REQUEST_URI . API_REQUEST_ENDPOINT);
        $status = $response->getStatusCode();
        $responseBody = $response->getBody();
        $responseContent = $responseBody->getContents();
        $data = json_decode($responseContent, true);
        return $data;

    }

    private function doRequest(
        string $uri,
        array $params = [],
        string $requestMethod = Request::HTTP_METHOD_GET
        ): Response {

        $client = $this->clientFactory->create(
            [
                'config' => [
                    'base_uri' => $uri,
                    'timeout' => 30,
                    'allow_redirects' => false,
                ],
            ]
        );
        
        try {
            $response = $client->request(
                $requestMethod,
                $uri,
                $params
            );
        } catch (GuzzleException $e) {
            $response = $this->responseFactory->create([
                'status' => $exception->getCode(),
                'reason' => $exception->getMessage()
            ]);
        }

        return $response;
    }
}