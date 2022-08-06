<?php

namespace Kambo\Tabular\XLSX\Test\Unit\DataTypes;

use PHPUnit\Framework\TestCase;
use Kambo\Tabular\XLSX\DataTypes\BoolType;
use Kambo\Tabular\XLSX\Format\Format;
use Kambo\Tabular\XLSX\DataTypes\InvalidDataType;

final class BoolTypeTest extends TestCase
{
    public function testCreate()
    {
        $boolType = BoolType::create();
        $this->assertEquals(Format::create(), $boolType->toFormat());
    }

    public function testValidate()
    {
        $this->expectException(InvalidDataType::class);
        $this->expectExceptionMessage('Value "foo" is not type of BoolType');

        $boolType = BoolType::create();
        $boolType->validate('foo');
    }
}
