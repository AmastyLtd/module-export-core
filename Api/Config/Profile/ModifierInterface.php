<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) Amasty (https://www.amasty.com)
 * @package Export Core for Magento 2 (System)
 */

namespace Amasty\ExportCore\Api\Config\Profile;

interface ModifierInterface
{
    /**
     * @return string
     */
    public function getModifierClass(): string;

    /**
     * @param string $modifierClass
     *
     * @return void
     */
    public function setModifierClass(string $modifierClass);

    /**
     * @return \Amasty\ImportExportCore\Api\Config\ConfigClass\ArgumentInterface[]
     */
    public function getArguments(): ?array;

    /**
     * @param \Amasty\ImportExportCore\Api\Config\ConfigClass\ArgumentInterface[]|null $arguments
     *
     * @return void
     */
    public function setArguments(?array $arguments);
}
