<?php

namespace Kambo\Tabular\XLSX\DataTypes;

use Kambo\Tabular\XLSX\Format\Format;
use ReflectionClass;

use function is_bool;

final class BoolType implements DataType
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
        if (!is_bool($value)) {
            throw InvalidDataType::create($this, $value);
        }
    }
}
