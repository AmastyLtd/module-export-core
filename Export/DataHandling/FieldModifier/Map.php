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

class Map extends AbstractModifier implements FieldModifierInterface
{
    public const MAP = 'map';

    public const DEFAULT_SETTINGS = [
        self::MAP => []
    ];

    /** @var array */
    protected $config;

    public function __construct($config)
    {
        parent::__construct($config);
        $this->config = array_merge(self::DEFAULT_SETTINGS, $config);
    }

    public function transform($value): string
    {
        return $this->config[self::MAP][$value] ?? $value;
    }

    public function getGroup(): string
    {
        return ModifierProvider::CUSTOM_GROUP;
    }

    public function getLabel(): string
    {
        return __('Map')->getText();
    }
}
