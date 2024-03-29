<?php

declare(strict_types=1);

/**
 * @author Amasty Team
 * @copyright Copyright (c) Amasty (https://www.amasty.com)
 * @package Export Core for Magento 2 (System)
 */

namespace Amasty\ExportCore\Export\Filter;

use Amasty\ExportCore\Api\Filter\FilterConfigInterface;

class FilterConfig implements FilterConfigInterface
{
    /**
     * @var array
     */
    private $fileDestinationConfig = [];

    public function __construct(array $filterConfig)
    {
        foreach ($filterConfig as $config) {
            if (!isset($config['code'], $config['filterClass'])) {
                throw new \LogicException('Filter "' . $config['code'] . ' is not configured properly');
            }
            $this->fileDestinationConfig[$config['code']] = $config;
        }
    }

    public function get(string $type): array
    {
        if (!isset($this->fileDestinationConfig[$type])) {
            throw new \RuntimeException('Filter "' . $type . '" is not defined');
        }

        return $this->fileDestinationConfig[$type];
    }

    public function all(): array
    {
        return $this->fileDestinationConfig;
    }
}
