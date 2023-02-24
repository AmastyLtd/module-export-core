<?php

namespace Amasty\ExportCore\Export\Config\Entity;

interface RelationEntityCodeResolverInterface
{
    public function resolve(string $fieldsConfigName, string $parentEntityCode): ?string;
}
