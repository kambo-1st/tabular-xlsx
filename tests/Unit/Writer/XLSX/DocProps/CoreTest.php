<?php

namespace Kambo\Tabular\XLSX\Test\Unit\Writer\XLSX\DocProps;

use Kambo\Tabular\XLSX\Writer\FileOptions;
use Kambo\Tabular\XLSX\Writer\XLSX\DocProps\Core;
use PHPUnit\Framework\TestCase;
use DateTimeImmutable;

final class CoreTest extends TestCase
{
    public function testGenerate(): void
    {
        $options = new FileOptions(memory:true, prettyPrint: true);
        $core    = new Core($options, null);
        $core->addCreator('Foo');
        $core->addCreated(new DateTimeImmutable('2000-01-01'));

        $this->assertXmlStringEqualsXmlString(
            <<< XML
<cp:coreProperties xmlns:cp="http://schemas.openxmlformats.org/package/2006/metadata/core-properties" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:dcmitype="http://purl.org/dc/dcmitype/" xmlns:dcterms="http://purl.org/dc/terms/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
  <dc:creator>Foo</dc:creator>
  <dcterms:created xsi:type="dcterms:W3CDTF">2000-01-01T00:00:00+00:00</dcterms:created>
</cp:coreProperties>
XML,
            $core->generate()
        );
    }
}
