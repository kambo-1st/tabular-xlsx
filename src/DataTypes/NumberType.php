<?php

namespace Kambo\Tabular\XLSX\DataTypes;

use Kambo\Tabular\XLSX\Format\Format;
use ReflectionClass;

use function is_numeric;

final class NumberType implements DataType
{
    public function __construct(private Format $format)
    {
    }

    public static function create(Format $format = null)
    {
        return new self(Format::createFromFormat(Format::FORMAT_NUMBER_00));
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
        if (!is_numeric($value)) {
            throw InvalidDataType::create($this, $value);
        }
    }
}
