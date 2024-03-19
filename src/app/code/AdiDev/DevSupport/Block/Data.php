<?php

namespace AdiDev\DevSupport\Block;

use Magento\Framework\View\Element\Template;
use GuzzleHttp\Client;
use GuzzleHttp\ClientFactory;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ResponseFactory;
use Magento\Framework\Webapi\Rest\Request;

class Data extends \Magento\Framework\View\Element\Template
{
     /**
     * API request URL
     */
    const API_REQUEST_URI = 'https://official-joke-api.appspot.com/random_joke';


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
        $response = $this->doRequest(self::API_REQUEST_URI);
        $statusCode = $response->getStatusCode();
        $responseBody = $response->getBody();
        $responseContent = $responseBody->getContents();

        return json_decode($responseContent, true);

    }

    private function doRequest(
        string $uriEndpoint,
        array $params = [],
        string $requestMethod = Request::HTTP_METHOD_GET
    ) : Response {
        $client = $this->clientFactory->create(['config' => [
            'base_uri' => self::API_REQUEST_URI
        ]]);
        try{
            $response = $client->request(
                $requestMethod,
                $uriEndpoint,
                $params
            );
        } catch (GuzzleException $e) {
            /** @var Response $response */
            $response = $this->responseFactory->create([
                'status' => $exception->getCode(),
                'reason' => $exception->getMessage()
            ]);
        }
        return $response;
    }

    public function getTestFunction() {
        return "Hello World";
    }
}