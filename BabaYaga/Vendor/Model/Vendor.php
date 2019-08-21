<?php
namespace BabaYaga\Vendor\Model;

use BabaYaga\Vendor\Api\Data\VendorInterface;
use Magento\Framework\Model\AbstractModel;

class Vendor extends AbstractModel implements VendorInterface
{
    /**
     * Initialize resource.
     */
    protected function _construct()
    {
        $this->_init('BabaYaga\Vendor\Model\ResourceModel\Vendor');
    }

    /**
     * @param string $name
     *
     * @return Vendor
     */
    public function setName(string $name)
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->getData(self::NAME);
    }
}
