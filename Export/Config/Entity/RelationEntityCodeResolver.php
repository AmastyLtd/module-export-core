<?php
declare(strict_types=1);

namespace Amasty\ExportCore\Export\Config\Entity;

use Amasty\ExportCore\Export\Config\RelationConfigProvider;

class RelationEntityCodeResolver implements RelationEntityCodeResolverInterface
{
    /**
     * @var RelationConfigProvider
     */
    private $relationConfigProvider;

    /**
     * @var array [fieldConfigName => relationEntityCode]
     */
    private $fieldsConfigNameToEntityCode = [];

    public function __construct(
        RelationConfigProvider $relationConfigProvider
    ) {
        $this->relationConfigProvider = $relationConfigProvider;
    }

    public function resolve(string $fieldsConfigName, string $parentEntityCode): ?string
    {
        if (empty($this->fieldsConfigNameToEntityCode[$fieldsConfigName])) {
            $relations = $this->relationConfigProvider->get($parentEntityCode);
            foreach ($relations as $relation) {
                if ($fieldsConfigName === $relation->getSubEntityFieldName()) {
                    $this->fieldsConfigNameToEntityCode[$fieldsConfigName] = $relation->getChildEntityCode();
                    break;
                }
            }
        }

        return $this->fieldsConfigNameToEntityCode[$fieldsConfigName] ?? null;
    }
}
