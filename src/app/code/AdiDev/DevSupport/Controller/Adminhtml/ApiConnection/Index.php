<?php

namespace AdiDev\DevSupport\Controller\Adminhtml\ApiConnection;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\Controller\Result\Redirect;

class Index extends Action implements \Magento\Framework\App\Action\HttpGetActionInterface
{

    const MENU_ID = 'AdiDev_DevSupport::apiconnection';

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    protected $httpClientFactory;


    /**
     * Constructor
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        \Zend\Http\ClientFactory $httpClientFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->httpClientFactory = $httpClientFactory;
    }

    /**
     * Execute action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        try{
            $httpClient = $this->httpClientFactory->create();
            $httpClient->setUri('https://official-joke-api.appspot.com/random_joke');
            $httpClient->setMethod(\Zend\Http\Request::METHOD_GET);
            $response = $httpClient->send();

            if ($response->isSuccess()) {
                $apiData = json_decode($response->getBody(), true);
                $resultPage = $this->resultPageFactory->create();
                $resultPage->setActiveMenu(static::MENU_ID);
                $resultPage->getConfig()->getTitle()->prepend(__('API Connection'));
                return $resultPage;
            }
            else {
                $this->messageManager->addError(__('Failed to fetch data from the API.'));
            }

        }
        catch (\Exception $e) {
            $this->messageManager->addError(__('An error occurred while processing your request.'));

        }

        return $this->_redirect('*/*/');
    }
}