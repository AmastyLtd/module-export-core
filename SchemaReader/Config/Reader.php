<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) Amasty (https://www.amasty.com)
 * @package Export Core for Magento 2 (System)
 */

namespace Amasty\ExportCore\SchemaReader\Config;

class Reader extends \Amasty\ImportExportCore\Config\SchemaReader\Reader
{
    /**
     * List of id attributes for merge
     *
     * @var array
     */
    protected $_idAttributes = [
        '/config/entity' => 'code',
        '/config/entity/fieldsConfig/fields/field' => 'name',
        '/config/relation' => 'code'
    ];
}
