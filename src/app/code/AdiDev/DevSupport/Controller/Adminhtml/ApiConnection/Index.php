<?php

namespace AdiDev\DevSupport\Controller\Adminhtml\ApiConnection;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\Page;

class Index extends Action implements \Magento\Framework\App\Action\HttpGetActionInterface
{

    const MENU_ID = 'AdiDev_DevSupport::apiconnection';

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * Constructor
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Execute action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $httpClient = new \Zend\Http\Client();
        $httpClient->setUri('https://official-joke-api.appspot.com/random_joke');
        $httpClient->setMethod(\Zend\Http\Request::METHOD_GET);
        $response = $httpClient->send();

        if ($response->isSuccess()) {
            $apiData = json_decode($response->getBody(), true);
        }
        else {
            $this->messageManager->addError(__('Failed to fetch data from the API.'));
            $this->_redirect('*/*/');
        }


        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu(static::MENU_ID);
        $resultPage->getConfig()->getTitle()->prepend(__('API Connection'));

        return $resultPage;
    }
}
