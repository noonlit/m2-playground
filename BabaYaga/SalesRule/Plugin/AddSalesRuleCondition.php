<?php

namespace BabaYaga\SalesRule\Plugin;

use BabaYaga\SalesRule\Model\Rule\Condition\Customer;

/**
 * Class AddSalesRuleCondition
 *
 * @package BabaYaga\SalesRule\Plugin
 */
class AddSalesRuleCondition
{
    /**
     * Add own condition to the sales rule condition options.
     *
     * In theory, we could also use an observer for salesrule_rule_condition_combine,
     * but the technical guidelines say that we should not modify the values passed to an event.
     *
     * In which case my question is: why are you exposing the $additional object in the event???
     *
     *
     * @param \Magento\SalesRule\Model\Rule\Condition\Combine $subject
     * @param array                                           $conditions
     *
     * @return array
     */
    public function afterGetNewChildSelectOptions(
        \Magento\SalesRule\Model\Rule\Condition\Combine $subject,
        array $conditions
    ) : array
    {
        $conditions = array_merge_recursive(
            $conditions,
            [
                [
                    'value' => Customer::class,
                    'label' => __('Customer has other orders?'),
                ]
            ]
        );

        return $conditions;
    }
}
