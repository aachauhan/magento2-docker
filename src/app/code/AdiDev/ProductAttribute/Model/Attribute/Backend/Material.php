<?php
declare(strict_types = 1);

namespace AdiDev\ProductAttribute\Model\Attribute\Backend;

use Magento\Catalog\Model\Product;
use Magento\Eav\Model\Entity\Attribute\Backend\AbstractBackend;
use Magento\Framework\Exception\LocalizedException;

class Material extends AbstractBackend
{
    /**
    * @param Product @object
    * @throws LocalizedException
    */
    public function validate($object)
    {
        $value = $object->getData($this->getAttribute()->getAttributeCode());
        if(($object->getAttributeSetId() == 4) && ($value == 'fur')){
            throw new LocalizedException(__('Bottoms cannot be fur'));
        }
    }
}