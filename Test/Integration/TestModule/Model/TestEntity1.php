<?php

declare(strict_types=1);

namespace Amasty\ExportCore\Test\Integration\TestModule\Model;

use Magento\Framework\Model\AbstractModel;

class TestEntity1 extends AbstractModel
{
    public const ID = 'id';
    public const TEXT_FIELD = 'text_field';
    public const DATE_FIELD = 'date_field';
    public const SELECT_FIELD = 'select_field';

    public function _construct()
    {
        parent::_construct();
        $this->_init(ResourceModel\TestEntity1::class);
        $this->setIdFieldName(self::ID);
    }
}
