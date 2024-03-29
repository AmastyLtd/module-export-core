<?php

declare(strict_types=1);

/**
 * @author Amasty Team
 * @copyright Copyright (c) Amasty (https://www.amasty.com)
 * @package Export Core for Magento 2 (System)
 */

namespace Amasty\ExportCore\Export\DataHandling\FieldModifier;

use Amasty\ExportCore\Api\FieldModifier\FieldModifierInterface;
use Amasty\ExportCore\Export\DataHandling\AbstractModifier;
use Amasty\ExportCore\Export\DataHandling\ModifierProvider;
use Magento\Store\Model\StoreManagerInterface;

class StoreCode2StoreId extends AbstractModifier implements FieldModifierInterface
{
    /**
     * @var array
     */
    private $storeCodeIdMapping;

    public function __construct(
        StoreManagerInterface $storeManager,
        $config
    ) {
        parent::__construct($config);
        $stores = $storeManager->getStores(true);
        foreach ($stores as $store) {
            $this->storeCodeIdMapping[$store->getCode()] = $store->getId();
        }
    }

    public function transform($value)
    {
        if (is_array($value)) {
            foreach ($value as &$storeCode) {
                $storeCode = $this->storeCodeIdMapping[$storeCode] ?? 0;
            }

            return $value;
        }

        return $this->storeCodeIdMapping[$value] ?? 0;
    }

    public function getGroup(): string
    {
        return ModifierProvider::CUSTOM_GROUP;
    }

    public function getLabel(): string
    {
        return __('Convert Store Code To Store Id')->getText();
    }
}
