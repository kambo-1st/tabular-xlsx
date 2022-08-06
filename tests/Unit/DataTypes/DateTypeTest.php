<?php

namespace Kambo\Tabular\XLSX\Test\Unit\DataTypes;

use Kambo\Tabular\XLSX\DataTypes\DateType;
use Kambo\Tabular\XLSX\DataTypes\InvalidDataType;
use Kambo\Tabular\XLSX\Format\Format;
use PHPUnit\Framework\TestCase;

final class DateTypeTest extends TestCase
{
    public function testCreate()
    {
        $boolType = DateType::create();
        $this->assertEquals(Format::createFromFormat('dd/mm/yyyy'), $boolType->toFormat());
    }

    public function testValidate()
    {
        $this->expectException(InvalidDataType::class);
        $this->expectExceptionMessage('Value "foo" is not type of DateType');

        $boolType = DateType::create();
        $boolType->validate('foo');
    }
}
