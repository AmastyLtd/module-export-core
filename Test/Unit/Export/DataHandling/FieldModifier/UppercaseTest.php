<?php

declare(strict_types=1);

/**
 * @author Amasty Team
 * @copyright Copyright (c) Amasty (https://www.amasty.com)
 * @package Export Core for Magento 2 (System)
 */

namespace Amasty\ExportCore\Test\Unit\Export\DataHandling\FieldModifier;

use Amasty\ExportCore\Export\DataHandling\FieldModifier\Uppercase;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Amasty\ExportCore\Export\DataHandling\FieldModifier\Uppercase
 */
class UppercaseTest extends TestCase
{
    /**
     * @param string $value
     * @param string $expectedResult
     * @testWith ["test", "TEST"]
     *           [" test", " TEST"]
     *           ["null", "NULL"]
     */
    public function testTransform(string $value, string $expectedResult)
    {
        $objectManager = new ObjectManager($this);
        $modifier = $objectManager->getObject(Uppercase::class);
        $this->assertSame($expectedResult, $modifier->transform($value));
    }
}
