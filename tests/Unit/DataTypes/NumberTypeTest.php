<?php

namespace Kambo\Tabular\XLSX\Test\Unit\DataTypes;

use Kambo\Tabular\XLSX\DataTypes\NumberType;
use Kambo\Tabular\XLSX\DataTypes\InvalidDataType;
use Kambo\Tabular\XLSX\Format\Format;
use PHPUnit\Framework\TestCase;

final class NumberTypeTest extends TestCase
{
    public function testCreate()
    {
        $boolType = NumberType::create();
        $this->assertEquals(Format::createFromFormat('0.00'), $boolType->toFormat());
    }

    public function testValidate()
    {
        $this->expectException(InvalidDataType::class);
        $this->expectExceptionMessage('Value "foo" is not type of NumberType');

        $boolType = NumberType::create();
        $boolType->validate('foo');
    }
}
