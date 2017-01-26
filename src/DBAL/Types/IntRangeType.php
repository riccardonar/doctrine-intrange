<?php
namespace riccardonar\Doctrine\DBAL\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\StringType;
use riccardonar\IntRange;

class IntRangeType extends StringType
{
    const INTRANGE = 'intrange';

    /**
     * @override
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return mixed|null
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return (null === $value) ? null : IntRange::toString($value);
    }

    /**
     * @override
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return mixed|IntRange
     * @throws ConversionException
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (null !== $value) {
            if (false == preg_match('/^(\[|\()(\d),(\d)(\]|\))$/', $value)) {
                throw ConversionException::conversionFailedFormat(
                    $value,
                    $this->getName(),
                    '(\[|\()(\d),(\d)(\]|\))$'
                );
            }

            $value = IntRange::fromString($value);
        }

        return $value;
    }

    /**
     * @override
     * @return string
     */
    public function getName()
    {
        return self::INTRANGE;
    }
}