<?php

declare(strict_types=1);

/**
 * @author Amasty Team
 * @copyright Copyright (c) Amasty (https://www.amasty.com)
 * @package Export Core for Magento 2 (System)
 */

namespace Amasty\ExportCore\Export\SubEntity;

use Amasty\ExportCore\Api\Config\Entity\SubEntityCollectorInterface;
use Amasty\ExportCore\Api\Config\Relation\RelationInterface;
use Magento\Framework\ObjectManagerInterface;

class CollectorFactory
{
    public const BUILT_IN_RELATIONS = [
        RelationInterface::TYPE_ONE_TO_MANY => Collector\OneToMany::class,
        RelationInterface::TYPE_MANY_TO_MANY => Collector\ManyToMany::class,
    ];

    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    public function __construct(ObjectManagerInterface $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    public function create(RelationInterface $config): SubEntityCollectorInterface
    {
        $type = $config->getType();

        $class = self::BUILT_IN_RELATIONS[$type] ?? $type;
        if (!is_subclass_of($class, SubEntityCollectorInterface::class)) {
            throw new \LogicException(sprintf(
                'Wrong collector class name: %s. Expected subclass of %s',
                $class,
                SubEntityCollectorInterface::class
            ));
        }

        return $this->objectManager->create($class, ['config' => $config]);
    }
}
