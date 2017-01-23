<?php

namespace riccardonar\Doctrine\DBAL\Types\Tests;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Platforms\PostgreSqlPlatform;
use Doctrine\DBAL\Types\Type;
use riccardonar\Doctrine\DBAL\Types\IntRangeType;
use riccardonar\IntRange;

/**
 * Class IntRangeTypeTest
 * @package riccardonar\Doctrine\DBAL\Types\Tests
 */
class IntRangeTypeTest extends \PHPUnit_Framework_TestCase
{
    /** @var  AbstractPlatform */
    protected $platform;

    /** @var IntRangeType */
    protected $type;

    public function testConvertToDatabaseValue()
    {
        $range = new IntRange(2, 5);

        $this->assertEquals(
            '[2,5]',
            $this->type->convertToDatabaseValue($range, $this->platform)
        );
        $this->assertNull(
            $this->type->convertToDatabaseValue(null, $this->platform)
        );
    }

    public function testConvertToPHPValueInvalid()
    {
        $this->setExpectedException(
            'Doctrine\\DBAL\\Types\\ConversionException'
        );

        $this->type->convertToPHPValue('abcd', $this->platform);
    }

    public function testConvertToPHPValue()
    {
        $range = $this->type->convertToPHPValue('[2,5]', $this->platform);

        $this->assertEquals(2, $range->getStartInt());
        $this->assertEquals(5, $range->getEndInt());
        $this->assertNull(
            $this->type->convertToPHPValue(null, $this->platform)
        );
    }

    protected function setUp()
    {
        $this->platform = new PostgreSqlPlatform();
        $this->type = Type::getType('IntRange');
    }
}