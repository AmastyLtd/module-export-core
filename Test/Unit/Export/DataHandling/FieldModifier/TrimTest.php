<?php
declare(strict_types=1);

namespace Amasty\ExportCore\Test\Unit\Export\DataHandling\FieldModifier;

use Amasty\ExportCore\Export\DataHandling\FieldModifier\Trim;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Amasty\ExportCore\Export\DataHandling\FieldModifier\Trim
 */
class TrimTest extends TestCase
{
    /**
     * @param string $value
     * @param string $expectedResult
     * @testWith ["    test ", "test"]
     *           ["test", "test"]
     *           ["test   ", "test"]
     */
    public function testTransform(string $value, string $expectedResult)
    {
        $objectManager = new ObjectManager($this);
        $modifier = $objectManager->getObject(Trim::class);
        $this->assertSame($expectedResult, $modifier->transform($value));
    }
}
