<?php

namespace Kambo\Tabular\XLSX\DataTypes;

use Kambo\Tabular\XLSX\Format\Format;
use ReflectionClass;
use Stringable;

use function is_string;
use function is_numeric;

final class StringType implements DataType
{
    public static function create()
    {
        return new self();
    }

    public function toFormat(): Format
    {
        return Format::create();
    }

    public function __toString(): string
    {
        return (new ReflectionClass($this))->getShortName();
    }

    public function validate(mixed $value): void
    {
        if (!is_string($value) && !is_numeric($value) && !$value instanceof Stringable) {
            throw InvalidDataType::create($this, $value);
        }
    }
}
