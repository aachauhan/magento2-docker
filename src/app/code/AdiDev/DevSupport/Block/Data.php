<?php

namespace AdiDev\DevSupport\Block;

use Magento\Framework\View\Element\Template;
use AdiDev\DevSupport\Api\ApiData;


class Data extends \Magento\Framework\View\Element\Template
{
    protected $apiData;


    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \AdiDev\DevSupport\Api\ApiData $apiData,
        array $data = []
    ) {
        $this->apiData = $apiData;
        parent::__construct($context, $data);
    }

    /**
     * Get API data
     *
     * @return array
     */
    public function getAPIData(): array
    {
        // call to the API
        return $this->apiData->execute();
    }


}