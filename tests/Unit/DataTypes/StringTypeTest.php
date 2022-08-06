<?php

namespace Kambo\Tabular\XLSX\Test\Unit\DataTypes;

use Kambo\Tabular\XLSX\DataTypes\InvalidDataType;
use Kambo\Tabular\XLSX\DataTypes\StringType;
use Kambo\Tabular\XLSX\Format\Format;
use PHPUnit\Framework\TestCase;

final class StringTypeTest extends TestCase
{
    public function testCreate()
    {
        $boolType = StringType::create();
        $this->assertEquals(Format::createFromFormat('General'), $boolType->toFormat());
    }

    public function testValidate()
    {
        $this->expectException(InvalidDataType::class);
        $this->expectExceptionMessage(
            <<< MSG
Value "Array
(
    [0] => foo
)
" is not type of StringType
MSG
        );

        $boolType = StringType::create();
        $boolType->validate(['foo']);
    }
}
