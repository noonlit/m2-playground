<?php

namespace BabaYaga\SalesRule\Service;

use Magento\SalesRule\Model\CouponGenerator;

/**
 * Class GenerateCouponCodes
 *
 * see https://www.atwix.com/magento-2/create-cart-price-rule-and-generate-coupon-codes-programmatically/
 */
class GenerateCouponCodes
{
    /**
     * Coupon Generator
     *
     * @var CouponGenerator
     */
    protected $couponGenerator;

    /**
     * GenerateCouponCodesService constructor
     *
     * @param CouponGenerator $couponGenerator
     */
    public function __construct(CouponGenerator $couponGenerator)
    {
        $this->couponGenerator = $couponGenerator;
    }

    /**
     * Generate coupon list for specified cart price rule
     *
     * @param int|null $qty
     * @param int|null $ruleId
     * @param array    $params
     *
     * @return void
     */
    public function execute(int $qty, int $ruleId, array $params = []): void
    {
        if (!$qty || !$ruleId) {
            return;
        }

        $params['rule_id'] = $ruleId;
        $params['qty'] = $qty;

        $this->couponGenerator->generateCodes($params);
    }
}
