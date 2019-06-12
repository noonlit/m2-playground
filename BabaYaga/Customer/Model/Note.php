<?php
namespace BabaYaga\Customer\Model;

use BabaYaga\Customer\Api\Data\CustomerNoteInterface;
use Magento\Framework\Model\AbstractModel;

class Note extends AbstractModel implements CustomerNoteInterface
{
    /**
     * Initialize resource.
     */
    protected function _construct()
    {
        $this->_init('BabaYaga\Customer\Model\ResourceModel\Note');
    }

    /**
     * @param string $text
     *
     * @return Note
     */
    public function setText(string $text)
    {
        return $this->setData(self::TEXT, $text);
    }

    /**
     * @return string
     */
    public function getText() : string
    {
        return $this->getData(self::TEXT);
    }
}
