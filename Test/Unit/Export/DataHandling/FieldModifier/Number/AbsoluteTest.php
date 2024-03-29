<?php

declare(strict_types=1);

/**
 * @author Amasty Team
 * @copyright Copyright (c) Amasty (https://www.amasty.com)
 * @package Export Core for Magento 2 (System)
 */

namespace Amasty\ExportCore\Test\Unit\Export\DataHandling\FieldModifier\Number;

use Amasty\ExportCore\Export\DataHandling\FieldModifier\Number\Absolute;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Amasty\ExportCore\Export\DataHandling\FieldModifier\Number\Absolute
 */
class AbsoluteTest extends TestCase
{
    /**
     * @param float $value
     * @param float $expectedResult
     * @testWith [-123, 123]
     *           [-0.52, 0.52]
     *           [-0, 0]
     */
    public function testTransform(float $value, float $expectedResult)
    {
        $objectManager = new ObjectManager($this);
        $modifier = $objectManager->getObject(Absolute::class);
        $this->assertSame($expectedResult, $modifier->transform($value));
    }
}
