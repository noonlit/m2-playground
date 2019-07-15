<?php

namespace BabaYaga\SalesRule\Model\Rule\Condition;

/**
 * Class Customer
 *
 * @package BabaYaga\SalesRule\Model\Rule\Condition
 */
class Customer extends \Magento\Rule\Model\Condition\AbstractCondition
{
    /**
     * @var \Magento\Config\Model\Config\Source\Yesno
     */
    protected $sourceYesno;

    /**
     * @var \Magento\Sales\Model\ResourceModel\Order\CollectionFactory
     */
    protected $orderCollectionFactory;

    /**
     * Customer constructor.
     *
     * @param \Magento\Rule\Model\Condition\Context                      $context
     * @param \Magento\Config\Model\Config\Source\Yesno                  $sourceYesno
     * @param \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory
     * @param array                                                      $data
     */
    public function __construct(
        \Magento\Rule\Model\Condition\Context $context,
        \Magento\Config\Model\Config\Source\Yesno $sourceYesno,
        \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);

        $this->sourceYesno = $sourceYesno;
        $this->orderCollectionFactory = $orderCollectionFactory;
    }

    /**
     * Load attribute options
     *
     * @return $this
     */
    public function loadAttributeOptions()
    {
        $this->setAttributeOption(
            [
                'customer_has_orders' => __('Customer has other orders?')
            ]
        );

        return $this;
    }

    /**
     * Get input type
     *
     * @return string
     */
    public function getInputType()
    {
        return 'select';
    }

    /**
     * Get value element type
     *
     * @return string
     */
    public function getValueElementType()
    {
        return 'select';
    }

    /**
     * Get value select options
     *
     * @return array|mixed
     */
    public function getValueSelectOptions()
    {
        return $this->sourceYesno->toOptionArray();
    }

    /**
     * Validate Customer First Order Rule Condition
     *
     * @param \Magento\Framework\Model\AbstractModel $model
     *
     * @return bool
     */
    public function validate(\Magento\Framework\Model\AbstractModel $model)
    {
        $customerId = $model->getCustomerId();

        $order = $this->orderCollectionFactory->create()
            ->addAttributeToSelect('customer_id')
            ->addFieldToFilter('customer_id', ['eq' => $customerId])
            ->getFirstItem();

        $customerHasOtherOrders = $order->getId() ? 1 : 0;

        $model->setData(
            'customer_has_orders',
            $customerHasOtherOrders
        );

        return parent::validate($model);
    }
}
