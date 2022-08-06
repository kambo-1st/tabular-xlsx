<?php

namespace Kambo\Tabular\XLSX\Test\Unit\Writer\XLSX;

use Kambo\Tabular\XLSX\Writer\FileOptions;
use PHPUnit\Framework\TestCase;
use Kambo\Tabular\XLSX\Writer\XLSX\ContentTypes;

final class ContentTypesTest extends TestCase
{
    public function testGenerate(): void
    {
        $options      = new FileOptions(memory:true, prettyPrint: true);
        $contentTypes = new ContentTypes($options, null);

        $this->assertXmlStringEqualsXmlString(
            <<< XML
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">
    <Default Extension="bin" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.printerSettings"/>
    <Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>
    <Default Extension="xml" ContentType="application/xml"/>
    <Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/>
    <Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>
    <Override PartName="/xl/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml"/>
    <Override PartName="/xl/sharedStrings.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sharedStrings+xml"/>
    <Override PartName="/docProps/core.xml" ContentType="application/vnd.openxmlformats-package.core-properties+xml"/>
    <Override PartName="/docProps/app.xml" ContentType="application/vnd.openxmlformats-officedocument.extended-properties+xml"/>
</Types>
XML,
            $contentTypes->generate()
        );
    }
}
