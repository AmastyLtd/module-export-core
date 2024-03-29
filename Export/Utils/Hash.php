<?php

declare(strict_types=1);

/**
 * @author Amasty Team
 * @copyright Copyright (c) Amasty (https://www.amasty.com)
 * @package Export Core for Magento 2 (System)
 */

namespace Amasty\ExportCore\Export\Utils;

use Magento\Framework\Encryption\Encryptor;

class Hash
{
    /**
     * @var Encryptor
     */
    private $encryptor;

    public function __construct(Encryptor $encryptor)
    {
        $this->encryptor = $encryptor;
    }

    public function hash($data): string
    {
        return (string)$this->encryptor->hash($data, Encryptor::HASH_VERSION_MD5);
    }
}
