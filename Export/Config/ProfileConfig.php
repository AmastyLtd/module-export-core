<?php

declare(strict_types=1);

namespace Amasty\ExportCore\Export\Config;

use Amasty\ExportCore\Api\Config\Profile\FieldsConfigInterface;
use Amasty\ExportCore\Api\Config\ProfileConfigExtensionInterface;
use Amasty\ExportCore\Api\Config\ProfileConfigInterface;
use Amasty\ExportCore\Api\Config\ProfileConfigExtensionInterfaceFactory;
use Magento\Framework\DataObject;

class ProfileConfig extends DataObject implements ProfileConfigInterface
{
    public const ENTITY_CODE = 'entity_code';
    public const STRATEGY = 'strategy';
    public const FILENAME = 'filename';
    public const USE_MULTIPROCESS = 'use_multiprocess';
    public const MAX_JOBS = 'max_jobs';
    public const BATCH_SIZE = 'batch_size';
    public const TEMPLATE_TYPE = 'template_type';
    public const FILE_DESTINATION_TYPES = 'file_destination_types';
    public const POST_PROCESSORS = 'post_processors';
    public const FIELDS_CONFIG = 'fields_config';
    public const MODULE_TYPE = 'module_type';

    /**
     * @var ProfileConfigExtensionInterfaceFactory
     */
    private $extensionAttributesFactory;

    public function __construct(
        ProfileConfigExtensionInterfaceFactory $extensionAttributesFactory,
        array $data = []
    ) {
        parent::__construct($data);
        $this->extensionAttributesFactory = $extensionAttributesFactory;
    }

    public function initialize(): ProfileConfigInterface
    {
        return $this;
    }

    public function getStrategy(): ?string
    {
        return $this->getData(self::STRATEGY);
    }

    public function setStrategy(?string $strategy): ProfileConfigInterface
    {
        $this->setData(self::STRATEGY, $strategy);

        return $this;
    }

    public function getEntityCode(): string
    {
        return $this->getData(self::ENTITY_CODE);
    }

    public function setEntityCode(string $entityCode): ProfileConfigInterface
    {
        $this->setData(self::ENTITY_CODE, $entityCode);

        return $this;
    }

    public function getFilename(): ?string
    {
        return $this->getData(self::FILENAME);
    }

    public function setFilename(?string $filename): ProfileConfigInterface
    {
        $this->setData(self::FILENAME, $filename);

        return $this;
    }

    public function isUseMultiProcess(): ?bool
    {
        return $this->getData(self::USE_MULTIPROCESS) ?? false;
    }

    public function setIsUseMultiProcess(?bool $isUseMultiProcess): ProfileConfigInterface
    {
        $this->setData(self::USE_MULTIPROCESS, $isUseMultiProcess);

        return $this;
    }

    public function getMaxJobs(): ?int
    {
        return $this->getData(self::MAX_JOBS) ?? 1;
    }

    public function setMaxJobs(?int $maxJobs): ProfileConfigInterface
    {
        $this->setData(self::MAX_JOBS, $maxJobs);

        return $this;
    }

    public function getBatchSize(): ?int
    {
        return $this->getData(self::BATCH_SIZE);
    }

    public function setBatchSize(?int $batchSize): ProfileConfigInterface
    {
        $this->setData(self::BATCH_SIZE, $batchSize);

        return $this;
    }

    public function getTemplateType(): ?string
    {
        return $this->getData(self::TEMPLATE_TYPE);
    }

    public function setTemplateType(?string $templateType): ProfileConfigInterface
    {
        $this->setData(self::TEMPLATE_TYPE, $templateType);

        return $this;
    }

    public function getFileDestinationTypes(): ?array
    {
        return $this->getData(self::FILE_DESTINATION_TYPES);
    }

    public function setFileDestinationTypes(array $fileDestinationTypes): ProfileConfigInterface
    {
        $this->setData(self::FILE_DESTINATION_TYPES, $fileDestinationTypes);

        return $this;
    }

    public function getPostProcessors(): ?array
    {
        return $this->getData(self::POST_PROCESSORS);
    }

    public function setPostProcessors(array $postProcessors): ProfileConfigInterface
    {
        $this->setData(self::POST_PROCESSORS, $postProcessors);

        return $this;
    }

    public function getFieldsConfig(): ?FieldsConfigInterface
    {
        return $this->getData(self::FIELDS_CONFIG);
    }

    public function setFieldsConfig(?FieldsConfigInterface $fieldsConfig): ProfileConfigInterface
    {
        $this->setData(self::FIELDS_CONFIG, $fieldsConfig);

        return $this;
    }

    public function getModuleType(): ?string
    {
        return $this->getData(self::MODULE_TYPE);
    }

    public function setModuleType(?string $moduleType): ProfileConfigInterface
    {
        $this->setData(self::MODULE_TYPE, $moduleType);

        return $this;
    }

    public function getExtensionAttributes(): ProfileConfigExtensionInterface
    {
        if (null === $this->getData(self::EXTENSION_ATTRIBUTES_KEY)) {
            $this->setExtensionAttributes($this->extensionAttributesFactory->create());
        }

        return $this->getData(self::EXTENSION_ATTRIBUTES_KEY);
    }

    public function setExtensionAttributes(
        ProfileConfigExtensionInterface $extensionAttributes
    ): ProfileConfigInterface {
        $this->setData(self::EXTENSION_ATTRIBUTES_KEY, $extensionAttributes);

        return $this;
    }
}
