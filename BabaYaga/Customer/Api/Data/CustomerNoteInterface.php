<?php
namespace BabaYaga\Customer\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

/**
 * Interface CustomerNoteInterface
 *
 * @package BabaYaga\Customer\Api\Data
 */
interface CustomerNoteInterface extends ExtensibleDataInterface
{
    const TEXT = 'text';

    /**
     * @param string $text
     *
     * @return mixed
     */
    public function setText(string $text);

    /**
     * @return string
     */
    public function getText() : string;
}
