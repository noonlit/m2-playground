<?php

namespace BabaYaga\SalesRule\Setup\Patch\Data;

use BabaYaga\SalesRule\Service\CreateCartPriceRule;
use Magento\Framework\Setup\Patch\DataPatchInterface;

/**
 * Class AddSalesRule
 *
 * see https://www.atwix.com/magento-2/create-cart-price-rule-and-generate-coupon-codes-programmatically/
 *
 * @package BabaYaga\SalesRule\Setup\Patch\Data
 */
class AddSalesRule implements DataPatchInterface
{
    /**
     * Create Cart Price Rule Service
     *
     * @var CreateCartPriceRule
     */
    private $createCartPriceRuleService;

    /**
     * InstallData constructor
     *
     * @param CreateCartPriceRule $createCartPriceRuleService
     */
    public function __construct(CreateCartPriceRule $createCartPriceRuleService)
    {
        $this->createCartPriceRuleService = $createCartPriceRuleService;
    }

    /**
     * @return DataPatchInterface|void
     * @throws \Exception
     */
    public function apply()
    {
        $this->createCartPriceRuleService->execute();
    }

    /**
     * @return array|string[]
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * @return array|string[]
     */
    public function getAliases()
    {
        return [];
    }
}
