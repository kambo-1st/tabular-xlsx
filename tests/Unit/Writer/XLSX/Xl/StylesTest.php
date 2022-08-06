<?php

namespace Kambo\Tabular\XLSX\Test\Unit\Writer\XLSX\Xl;

use Kambo\Tabular\XLSX\DataTypes\BoolType;
use Kambo\Tabular\XLSX\DataTypes\DateType;
use Kambo\Tabular\XLSX\DataTypes\NumberType;
use Kambo\Tabular\XLSX\DataTypes\StringType;
use Kambo\Tabular\XLSX\Header;
use Kambo\Tabular\XLSX\Headers;
use Kambo\Tabular\XLSX\Writer\FileOptions;
use Kambo\Tabular\XLSX\Writer\XLSX\Xl\Styles;
use PHPUnit\Framework\TestCase;

final class StylesTest extends TestCase
{
    public function testGenerate(): void
    {
        $options = new FileOptions(memory:true, prettyPrint: true);
        $styles  = new Styles($options, null);

        $headers = Headers::create()
            ->withHeader(Header::create(StringType::create(), 'Text type'))
            ->withHeader(Header::create(NumberType::create(), 'Number type'))
            ->withHeader(Header::create(BoolType::create(), 'Bool type'))
            ->withHeader(Header::create(DateType::create(), 'Date type'));

        $styles->addData($headers);
        $this->assertXmlStringEqualsXmlString(
            <<< XML
<styleSheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:mc="http://schemas.openxmlformats.org/markup-compatibility/2006" xmlns:x14ac="http://schemas.microsoft.com/office/spreadsheetml/2009/9/ac" xmlns:x16r2="http://schemas.microsoft.com/office/spreadsheetml/2015/02/main" xmlns:xr="http://schemas.microsoft.com/office/spreadsheetml/2014/revision" mc:Ignorable="x14ac x16r2 xr">
  <numFmts count="1">
    <numFmt formatCode="dd/mm/yyyy" numFmtId="164"/>
  </numFmts>
  <fonts count="1" x14ac:knownFonts="1">
    <font>
      <sz val="11"/>
      <color theme="1"/>
      <name val="Calibri"/>
      <family val="2"/>
      <scheme val="minor"/>
    </font>
  </fonts>
  <fills count="2">
    <fill>
      <patternFill patternType="none"/>
    </fill>
    <fill>
      <patternFill patternType="gray125"/>
    </fill>
  </fills>
  <borders count="1">
    <border>
      <left/>
      <right/>
      <top/>
      <bottom/>
      <diagonal/>
    </border>
  </borders>
  <cellStyleXfs count="1">
    <xf borderId="0" fillId="0" fontId="0" numFmtId="0"/>
  </cellStyleXfs>
  <cellXfs count="3">
    <xf borderId="0" fillId="0" fontId="0" numFmtId="0" xfId="0"/>
    <xf applyNumberFormat="1" borderId="0" fillId="0" fontId="0" numFmtId="2" xfId="0"/>
    <xf applyNumberFormat="1" borderId="0" fillId="0" fontId="0" numFmtId="164" xfId="0"/>
  </cellXfs>
  <cellStyles count="1">
    <cellStyle builtinId="0" name="Normal" xfId="0"/>
  </cellStyles>
  <dxfs count="0"/>
  <tableStyles count="0" defaultPivotStyle="PivotStyleLight16" defaultTableStyle="TableStyleMedium2"/>
  <extLst>
    <ext xmlns:x14="http://schemas.microsoft.com/office/spreadsheetml/2009/9/main" uri="{EB79DEF2-80B8-43e5-95BD-54CBDDF9020C}">
      <x14:slicerStyles defaultSlicerStyle="SlicerStyleLight1"/>
    </ext>
    <ext xmlns:x15="http://schemas.microsoft.com/office/spreadsheetml/2010/11/main" uri="{9260A510-F301-46a8-8635-F512D64BE5F5}">
      <x15:timelineStyles defaultTimelineStyle="TimeSlicerStyleLight1"/>
    </ext>
  </extLst>
</styleSheet>
XML,
            $styles->generate()
        );
    }
}
