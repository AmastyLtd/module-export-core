<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) Amasty (https://www.amasty.com)
 * @package Export Core for Magento 2 (System)
 */

namespace Amasty\ExportCore\Export\Config\Profile;

use Amasty\ExportCore\Api\Config\Profile\ModifierInterface;
use Magento\Framework\DataObject;

class Modifier extends DataObject implements ModifierInterface
{
    public const MODIFIER_CLASS = 'modifier_class';
    public const ARGUMENTS = 'arguments';

    public function getModifierClass(): string
    {
        return $this->getData(self::MODIFIER_CLASS);
    }

    public function setModifierClass(string $modifierClass)
    {
        $this->setData(self::MODIFIER_CLASS, $modifierClass);
    }

    public function getArguments(): ?array
    {
        return $this->getData(self::ARGUMENTS);
    }

    public function setArguments(?array $arguments)
    {
        $this->setData(self::ARGUMENTS, $arguments);
    }
}
