<?php

declare(strict_types=1);

namespace Kambo\Tabular\XLSX\Test\Unit\Format;

use Kambo\Tabular\XLSX\Format\Format;
use PHPUnit\Framework\TestCase;

final class FormatTest extends TestCase
{
    public function testCreateFromFormat(): void
    {
        $format = Format::createFromFormat(Format::FORMAT_PERCENTAGE_00);
        $this->assertEquals('0.00%', (string)$format);
    }

    public function testIsPredefinedTrue(): void
    {
        $format = Format::createFromFormat(Format::FORMAT_PERCENTAGE_00);
        $this->assertTrue($format->isPredefined());
    }

    public function testIsPredefinedFalse(): void
    {
        $format = Format::createFromFormat('test');
        $this->assertFalse($format->isPredefined());
    }

    public function testToCode(): void
    {
        $format = Format::createFromFormat(Format::FORMAT_PERCENTAGE_00);
        $this->assertEquals(10, $format->toCode());
    }

    public function testCreateFromCode(): void
    {
        $format = Format::createFromCode(49);
        $this->assertEquals('@', (string)$format);
    }
}
