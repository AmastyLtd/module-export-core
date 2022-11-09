<?php

namespace Amasty\ExportCore\Export\Config\Entity\Field;

use Amasty\ExportCore\Api\Config\Entity\Field\ActionInterface;
use Amasty\ImportExportCore\Api\Config\ConfigClass\ConfigClassInterface;

class Action implements ActionInterface
{
    /**
     * @var ConfigClassInterface
     */
    private $actionClass;

    public function getConfigClass()
    {
        return $this->actionClass;
    }

    public function setConfigClass($configClass): ActionInterface
    {
        $this->actionClass = $configClass;

        return $this;
    }
}
