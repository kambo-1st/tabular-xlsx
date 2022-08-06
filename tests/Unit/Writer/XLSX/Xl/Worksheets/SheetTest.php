<?php

namespace Kambo\Tabular\XLSX\Test\Unit\Writer\XLSX\Xl\Worksheets;

use Kambo\Tabular\XLSX\DataTypes\BoolType;
use Kambo\Tabular\XLSX\DataTypes\DateType;
use Kambo\Tabular\XLSX\DataTypes\NumberType;
use Kambo\Tabular\XLSX\DataTypes\StringType;
use Kambo\Tabular\XLSX\Header;
use Kambo\Tabular\XLSX\Headers;
use Kambo\Tabular\XLSX\Writer\FileOptions;
use Kambo\Tabular\XLSX\Writer\XLSX\Xl\Worksheets\Sheet;
use PHPUnit\Framework\TestCase;
use DateTimeImmutable;

final class SheetTest extends TestCase
{
    public function testGenerate(): void
    {
        $headers = Headers::create()
            ->withHeader(Header::create(StringType::create(), 'Text type'))
            ->withHeader(Header::create(NumberType::create(), 'Number type'))
            ->withHeader(Header::create(BoolType::create(), 'Bool type'))
            ->withHeader(Header::create(DateType::create(), 'Date type'));

        $options = new FileOptions(memory:true, prettyPrint: true);
        $sheet   = new Sheet($options, null, $headers);

        $sheet->addData(['hi', 42, true, new DateTimeImmutable('2000-01-01')]);

        $this->assertXmlStringEqualsXmlString(
            <<< XML
<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships" xmlns:mc="http://schemas.openxmlformats.org/markup-compatibility/2006" xmlns:x14ac="http://schemas.microsoft.com/office/spreadsheetml/2009/9/ac" xmlns:xr="http://schemas.microsoft.com/office/spreadsheetml/2014/revision" xmlns:xr2="http://schemas.microsoft.com/office/spreadsheetml/2015/revision2" xmlns:xr3="http://schemas.microsoft.com/office/spreadsheetml/2016/revision3" mc:Ignorable="x14ac xr xr2 xr3" xr:uid="{23E87883-0318-4168-A525-D73F9F9B2366}">
    <dimension ref="A1:C3"/>
    <sheetViews>
        <sheetView tabSelected="1" workbookViewId="0">
            <selection activeCell="D8" sqref="D8"/>
        </sheetView>
    </sheetViews>
    <sheetFormatPr defaultRowHeight="15" x14ac:dyDescent="0.25"/>
    <sheetData>
        <row r="1">
            <c r="A1" t="inlineStr">
                <is>
                    <t>hi</t>
                </is>
            </c>
            <c r="B1" t="n" s="1">
                <v>42</v>
            </c>
            <c r="C1" t="b">
                <v>1</v>
            </c>
            <c r="D1" t="n" s="2">
                <v>36526</v>
            </c>
        </row>
    </sheetData>
    <pageMargins left="0.7" right="0.7" top="0.75" bottom="0.75" header="0.3" footer="0.3"/>
    <pageSetup paperSize="9" orientation="portrait"/>
</worksheet>
XML,
            $sheet->generate()
        );
    }
}
