<?php

namespace Kambo\Tabular\XLSX\DataTypes;

use Kambo\Tabular\XLSX\Format\Format;

interface DataType
{
    public function toFormat(): Format;
    public function __toString(): string;
    public function validate(mixed $value): void;
}
