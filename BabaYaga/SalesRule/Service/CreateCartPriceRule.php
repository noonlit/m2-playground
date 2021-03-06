<?php

namespace BabaYaga\SalesRule\Service;

use Magento\Backend\App\Area\FrontNameResolver as BackendFrontNameResolver;
use Magento\Customer\Model\ResourceModel\Group\Collection as CustomerGroupCollection;
use Magento\Customer\Model\ResourceModel\Group\CollectionFactory as CustomerGroupCollectionFactory;
use Magento\Framework\App\State as AppState;
use Magento\SalesRule\Api\Data\RuleInterface;
use Magento\SalesRule\Api\Data\RuleInterfaceFactory;
use Magento\SalesRule\Api\RuleRepositoryInterface;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class CreateCartPriceRuleService
 *
 * see https://www.atwix.com/magento-2/create-cart-price-rule-and-generate-coupon-codes-programmatically/
 */
class CreateCartPriceRule
{
    /**
     * The number of generated coupon codes
     */
    const COUPON_CODES_QTY = 10;

    /**
     * Coupon Code Length
     */
    const LENGTH = 10;

    /**
     * Coupon Code Prefix
     */
    const PREFIX = 'TEST-';

    /**
     * Generate Coupon Codes Service
     *
     * @var GenerateCouponCodes
     */
    protected $generateCouponCodesService;

    /**
     * Rule Repository
     *
     * @var RuleRepositoryInterface
     */
    protected $ruleRepository;

    /**
     * Store Manager
     *
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * Catalog Price Rule Factory
     *
     * @var RuleInterfaceFactory
     */
    protected $cartPriceRuleFactory;

    /**
     * Customer Group Collection Factory
     *
     * @var CustomerGroupCollectionFactory
     */
    protected $customerGroupCollectionFactory;

    /**
     * App State
     *
     * @var AppState
     */
    protected $appState;

    /**
     * CreateCartPriceRuleService constructor
     *
     * @param GenerateCouponCodes            $generateCouponCodesService
     * @param RuleRepositoryInterface        $ruleRepository
     * @param StoreManagerInterface          $storeManager
     * @param AppState                       $appState
     * @param RuleInterfaceFactory           $cartPriceRuleFactory
     * @param CustomerGroupCollectionFactory $customerGroupCollectionFactory
     */
    public function __construct(
        GenerateCouponCodes $generateCouponCodesService,
        RuleRepositoryInterface $ruleRepository,
        StoreManagerInterface $storeManager,
        AppState $appState,
        RuleInterfaceFactory $cartPriceRuleFactory,
        CustomerGroupCollectionFactory $customerGroupCollectionFactory
    ) {
        $this->generateCouponCodesService = $generateCouponCodesService;
        $this->ruleRepository = $ruleRepository;
        $this->storeManager = $storeManager;
        $this->appState = $appState;
        $this->cartPriceRuleFactory = $cartPriceRuleFactory;
        $this->customerGroupCollectionFactory = $customerGroupCollectionFactory;
    }

    /**
     * Create cart price rule and generate coupon codes
     *
     * @return void
     *
     * @throws \Exception
     */
    public function execute()
    {
        $customerGroupIds = $this->getAvailableCustomerGroupIds();
        $websiteIds = $this->getAvailableWebsiteIds();

        /** @var RuleInterface $cartPriceRule */
        $cartPriceRule = $this->cartPriceRuleFactory->create();

        // Set the required parameters.
        $cartPriceRule->setName('Sample Cart Price Rule');
        $cartPriceRule->setIsActive(true);
        $cartPriceRule->setCouponType(RuleInterface::COUPON_TYPE_SPECIFIC_COUPON);
        $cartPriceRule->setCustomerGroupIds($customerGroupIds);
        $cartPriceRule->setWebsiteIds($websiteIds);

        // Discount products by 1.
        $cartPriceRule->setSimpleAction(RuleInterface::DISCOUNT_ACTION_FIXED_AMOUNT);
        $cartPriceRule->setDiscountAmount(1);

        // Set the usage limit per customer.
        $cartPriceRule->setUsesPerCustomer(1);

        // Make the multiple coupon codes generation possible.
        $cartPriceRule->setUseAutoGeneration(true);

        // We need to set the area code due to the existent implementation of RuleRepository.
        // The specific area need to be emulated while running the RuleRepository::save method from CLI in order to
        // avoid the corresponding error ("Area code is not set").
        $savedCartPriceRule = $this->appState->emulateAreaCode(
            BackendFrontNameResolver::AREA_CODE,
            [$this->ruleRepository, 'save'],
            [$cartPriceRule]
        );

        // Generate and assign coupon codes to the newly created Cart Price Rule.
        $ruleId = (int) $savedCartPriceRule->getRuleId();
        $params = ['length' => self::LENGTH, 'prefix' => self::PREFIX];
        $this->generateCouponCodesService->execute(self::COUPON_CODES_QTY, $ruleId, $params);
    }

    /**
     * Get all available customer group IDs
     *
     * @return int[]
     */
    protected function getAvailableCustomerGroupIds()
    {
        /** @var CustomerGroupCollection $collection */
        $collection = $this->customerGroupCollectionFactory->create();
        $collection->addFieldToSelect('customer_group_id');
        $customerGroupIds = $collection->getAllIds();

        return $customerGroupIds;
    }

    /**
     * Get all available website IDs
     *
     * @return int[]
     */
    protected function getAvailableWebsiteIds()
    {
        $websiteIds = [];
        $websites = $this->storeManager->getWebsites();

        foreach ($websites as $website) {
            $websiteIds[] = $website->getId();
        }

        return $websiteIds;
    }
}
