<?php

namespace Kambo\Tabular\XLSX\DataTypes;

use InvalidArgumentException;

use function sprintf;
use function print_r;

final class InvalidDataType extends InvalidArgumentException
{
    public static function create(DataType $type, mixed $value)
    {
        $message = sprintf('Value "%s" is not type of %s', print_r($value, true), $type);
        return new self($message);
    }
}
