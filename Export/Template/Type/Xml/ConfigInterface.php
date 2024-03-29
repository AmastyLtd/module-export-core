<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) Amasty (https://www.amasty.com)
 * @package Export Core for Magento 2 (System)
 */

namespace Amasty\ExportCore\Export\Template\Type\Xml;

interface ConfigInterface
{
    /**
     * @return string
     */
    public function getHeader(): ?string;

    /**
     * @param string|null $header
     *
     * @return \Amasty\ExportCore\Export\Template\Type\Xml\ConfigInterface
     */
    public function setHeader(?string $header): ConfigInterface;

    /**
     * @return string|null
     */
    public function getItem(): ?string;

    /**
     * @param string|null $item
     *
     * @return \Amasty\ExportCore\Export\Template\Type\Xml\ConfigInterface
     */
    public function setItem(?string $item): ConfigInterface;

    /**
     * @return string|null
     */
    public function getFooter(): ?string;

    /**
     * @param string|null $footer
     *
     * @return \Amasty\ExportCore\Export\Template\Type\Xml\ConfigInterface
     */
    public function setFooter(?string $footer): ConfigInterface;

    /**
     * @return string|null
     */
    public function getXslTemplate(): ?string;

    /**
     * @param string|null $xslTemplate
     *
     * @return \Amasty\ExportCore\Export\Template\Type\Xml\ConfigInterface
     */
    public function setXslTemplate(?string $xslTemplate): ConfigInterface;
}
