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
        $sample_joke = [
            "type" => "general",
            "setup" => "What kind of award did the dentist receive?",
            "punchline" => "A little plaque.",
            "id" => 255
        ];
        return $sample_joke;
        //return $this->apiData->execute();
    }


}