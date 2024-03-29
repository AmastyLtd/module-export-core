<?php

declare(strict_types=1);

/**
 * @author Amasty Team
 * @copyright Copyright (c) Amasty (https://www.amasty.com)
 * @package Export Core for Magento 2 (System)
 */

namespace Amasty\ExportCore\Test\Unit\Export\DataHandling\FieldModifier;

use Amasty\ExportCore\Export\DataHandling\FieldModifier\CapitalizeEachWord;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Amasty\ExportCore\Export\DataHandling\FieldModifier\CapitalizeEachWord
 */
class CapitalizeEachWordTest extends TestCase
{
    /**
     * @param string $value
     * @param string $expectedResult
     * @testWith ["test test", "Test Test"]
     *           ["", ""]
     *           ["123 123", "123 123"]
     */
    public function testTransform(string $value, string $expectedResult)
    {
        $objectManager = new ObjectManager($this);
        $modifier = $objectManager->getObject(CapitalizeEachWord::class);
        $this->assertSame($expectedResult, $modifier->transform($value));
    }
}
