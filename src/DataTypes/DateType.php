<?php

namespace Kambo\Tabular\XLSX\DataTypes;

use Kambo\Tabular\XLSX\Format\Format;
use ReflectionClass;
use DateTimeInterface;

final class DateType implements DataType
{
    public function __construct(private Format $format)
    {
    }

    public static function create()
    {
        return new self(Format::createFromFormat(Format::FORMAT_DATE_DDMMYYYY));
    }

    public function toFormat(): Format
    {
        return $this->format;
    }

    public function __toString(): string
    {
        return (new ReflectionClass($this))->getShortName();
    }

    public function validate(mixed $value): void
    {
        if (!$value instanceof DateTimeInterface) {
            throw InvalidDataType::create($this, $value);
        }
    }
}
