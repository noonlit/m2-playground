<?php
namespace BabaYaga\Vendor\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

/**
 * Interface VendorInterface
 *
 * @package BabaYaga\Customer\Api\Data
 */
interface VendorInterface extends ExtensibleDataInterface
{
    const NAME = 'name';

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function setName(string $name);

    /**
     * @return string
     */
    public function getName() : string;
}
