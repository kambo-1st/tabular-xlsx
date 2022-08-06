<?php

declare(strict_types=1);

namespace Kambo\Tabular\XLSX\Test\Unit;

use Kambo\Tabular\XLSX\Headers;
use Kambo\Tabular\XLSX\Header;
use Kambo\Tabular\XLSX\DataTypes\StringType;
use Kambo\Tabular\XLSX\DataTypes\NumberType;
use Kambo\Tabular\XLSX\DataTypes\BoolType;
use Kambo\Tabular\XLSX\DataTypes\DateType;
use Kambo\Tabular\XLSX\Format\Format;
use PHPUnit\Framework\TestCase;

final class HeadersTest extends TestCase
{
    public function testShowHeader(): void
    {
        $this->assertTrue($this->getHeaders()->toShowHeader());
    }

    public function testToTypeAtPos(): void
    {
        $this->assertEquals(NumberType::create(), $this->getHeaders()->toTypeAtPos(1));
        $this->assertEquals(DateType::create(), $this->getHeaders()->toTypeAtPos(3));
    }

    public function testToHeadersNames(): void
    {
        $this->assertEquals(
            ['Text type', 'Number type', 'Bool type', 'Date type',],
            $this->getHeaders()->toHeadersNames()
        );
    }

    public function testToCustomFormatCount(): void
    {
        $this->assertEquals(1, $this->getHeaders()->toCustomFormatCount());
    }

    public function testToFormatCount(): void
    {
        $this->assertEquals(3, $this->getHeaders()->toFormatCount());
    }

    public function testToFormatPosFromHeaderPos(): void
    {
        $this->assertEquals(1, $this->getHeaders()->toFormatPosFromHeaderPos(1));
    }

    public function testToFormats(): void
    {
        $this->assertEquals(
            [
                [
                    false,
                    0,
                    Format::create(),
                    false,
                ],
                [
                    false,
                    2,
                    Format::createFromFormat('0.00'),
                    true,
                ],
                [
                    true,
                    164,
                    Format::createFromFormat('dd/mm/yyyy'),
                    true,
                ],
            ],
            $this->getHeaders()->toFormats()
        );
    }

    private function getHeaders(): Headers
    {
        $headers = Headers::create()
            ->withHeader(Header::create(StringType::create(), 'Text type'))
            ->withHeader(Header::create(NumberType::create(), 'Number type'))
            ->withHeader(Header::create(BoolType::create(), 'Bool type'))
            ->withHeader(Header::create(DateType::create(), 'Date type'));

        return $headers;
    }
}
