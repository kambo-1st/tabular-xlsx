<?php

namespace Kambo\Tabular\XLSX\Writer\XLSX\Xl;

use Kambo\Tabular\XLSX\Headers;
use Kambo\Tabular\XLSX\Writer\XLSX\AbstractPart;

final class Styles extends AbstractPart
{
    private Headers $header;

    protected function getDefaultPath(): string
    {
        return 'xl';
    }

    protected function getDefaultFilename(): string
    {
        return 'styles.xml';
    }

    public function addData(mixed $data)
    {
        $this->header = $data;
    }

    public function generate()
    {
        $xw = $this->getXMLWriter();

        $xw->startDocument('1.0', 'UTF-8', 'yes');
        $xw->startElement('styleSheet');
        $xw->startAttribute('xmlns');
        $xw->text('http://schemas.openxmlformats.org/spreadsheetml/2006/main');
        $xw->endAttribute();
        $xw->startAttribute('xmlns:mc');
        $xw->text('http://schemas.openxmlformats.org/markup-compatibility/2006');
        $xw->endAttribute();
        $xw->startAttribute('xmlns:x14ac');
        $xw->text('http://schemas.microsoft.com/office/spreadsheetml/2009/9/ac');
        $xw->endAttribute();
        $xw->startAttribute('xmlns:x16r2');
        $xw->text('http://schemas.microsoft.com/office/spreadsheetml/2015/02/main');
        $xw->endAttribute();
        $xw->startAttribute('xmlns:xr');
        $xw->text('http://schemas.microsoft.com/office/spreadsheetml/2014/revision');
        $xw->endAttribute();

        $xw->startAttribute('mc:Ignorable');
        $xw->text('x14ac x16r2 xr');
        $xw->endAttribute();

        /**  Formats */
        $xw->startElement('numFmts');

        $xw->startAttribute('count');
        $xw->text($this->header->toCustomFormatCount());
        $xw->endAttribute();

        foreach ($this->header->toFormats() as [$custom, $id, $code]) {
            if ($custom) {
                $xw->startElement('numFmt');
                $xw->startAttribute('numFmtId');
                $xw->text($id);
                $xw->endAttribute();
                $xw->startAttribute('formatCode');
                $xw->text($code);
                $xw->endAttribute();
                $xw->endElement();
            }
        }

        $xw->endElement();
        /**  Formats end */

        $xw->startElement('fonts');

        $xw->startAttribute('count');
        $xw->text('1');
        $xw->endAttribute();

        $xw->startAttribute('x14ac:knownFonts');
        $xw->text('1');
        $xw->endAttribute();

        $xw->startElement('font');
        $xw->startElement('sz');
        $xw->startAttribute('val');
        $xw->text('11');
        $xw->endAttribute();
        $xw->endElement();
        $xw->startElement('color');
        $xw->startAttribute('theme');
        $xw->text('1');
        $xw->endAttribute();
        $xw->endElement();
        $xw->startElement('name');
        $xw->startAttribute('val');
        $xw->text('Calibri');
        $xw->endAttribute();
        $xw->endElement();
        $xw->startElement('family');
        $xw->startAttribute('val');
        $xw->text('2');
        $xw->endAttribute();
        $xw->endElement();
        $xw->startElement('scheme');
        $xw->startAttribute('val');
        $xw->text('minor');
        $xw->endAttribute();
        $xw->endElement();
        $xw->endElement();
        $xw->endElement();
        $xw->startElement('fills');
        $xw->startAttribute('count');
        $xw->text('2');
        $xw->endAttribute();
        $xw->startElement('fill');
        $xw->startElement('patternFill');
        $xw->startAttribute('patternType');
        $xw->text('none');
        $xw->endAttribute();
        $xw->endElement();
        $xw->endElement();
        $xw->startElement('fill');
        $xw->startElement('patternFill');
        $xw->startAttribute('patternType');
        $xw->text('gray125');
        $xw->endAttribute();
        $xw->endElement();
        $xw->endElement();
        $xw->endElement();
        $xw->startElement('borders');
        $xw->startAttribute('count');
        $xw->text('1');
        $xw->endAttribute();
        $xw->startElement('border');
        $xw->startElement('left');
        $xw->endElement();
        $xw->startElement('right');
        $xw->endElement();
        $xw->startElement('top');
        $xw->endElement();
        $xw->startElement('bottom');
        $xw->endElement();
        $xw->startElement('diagonal');
        $xw->endElement();
        $xw->endElement();
        $xw->endElement();
        $xw->startElement('cellStyleXfs');
        $xw->startAttribute('count');
        $xw->text('1');
        $xw->endAttribute();
        $xw->startElement('xf');
        $xw->startAttribute('numFmtId');
        $xw->text('0');
        $xw->endAttribute();
        $xw->startAttribute('fontId');
        $xw->text('0');
        $xw->endAttribute();
        $xw->startAttribute('fillId');
        $xw->text('0');
        $xw->endAttribute();
        $xw->startAttribute('borderId');
        $xw->text('0');
        $xw->endAttribute();
        $xw->endElement();
        $xw->endElement();

        $xw->startElement('cellXfs');
        $xw->startAttribute('count');
        $xw->text($this->header->toFormatCount());
        $xw->endAttribute();

        foreach ($this->header->toFormats() as [$custom, $id, $code, $number]) {
            $xw->startElement('xf');
            $xw->startAttribute('numFmtId');
            $xw->text($id);
            $xw->endAttribute();
            $xw->startAttribute('fontId');
            $xw->text('0');
            $xw->endAttribute();
            $xw->startAttribute('fillId');
            $xw->text('0');
            $xw->endAttribute();
            $xw->startAttribute('borderId');
            $xw->text('0');
            $xw->endAttribute();
            $xw->startAttribute('xfId');
            $xw->text('0');
            $xw->endAttribute();
            if ($number) {
                $xw->startAttribute('applyNumberFormat');
                $xw->text('1');
                $xw->endAttribute();
            }

            $xw->endElement();
        }

        $xw->endElement();

        $xw->startElement('cellStyles');
        $xw->startAttribute('count');
        $xw->text('1');
        $xw->endAttribute();
        $xw->startElement('cellStyle');
        $xw->startAttribute('name');
        $xw->text('Normal');
        $xw->endAttribute();
        $xw->startAttribute('xfId');
        $xw->text('0');
        $xw->endAttribute();
        $xw->startAttribute('builtinId');
        $xw->text('0');
        $xw->endAttribute();
        $xw->endElement();
        $xw->endElement();
        $xw->startElement('dxfs');
        $xw->startAttribute('count');
        $xw->text('0');
        $xw->endAttribute();
        $xw->endElement();
        $xw->startElement('tableStyles');
        $xw->startAttribute('count');
        $xw->text('0');
        $xw->endAttribute();
        $xw->startAttribute('defaultTableStyle');
        $xw->text('TableStyleMedium2');
        $xw->endAttribute();
        $xw->startAttribute('defaultPivotStyle');
        $xw->text('PivotStyleLight16');
        $xw->endAttribute();
        $xw->endElement();
        $xw->startElement('extLst');
        $xw->startElement('ext');
        $xw->startAttribute('uri');
        $xw->text('{EB79DEF2-80B8-43e5-95BD-54CBDDF9020C}');
        $xw->endAttribute();

        $xw->startAttribute('xmlns:x14');
        $xw->text('http://schemas.microsoft.com/office/spreadsheetml/2009/9/main');
        $xw->endAttribute();

        $xw->startElement('x14:slicerStyles');
        $xw->startAttribute('defaultSlicerStyle');
        $xw->text('SlicerStyleLight1');
        $xw->endAttribute();
        $xw->endElement();
        $xw->endElement();

        $xw->startElement('ext');

        $xw->startAttribute('uri');
        $xw->text('{9260A510-F301-46a8-8635-F512D64BE5F5}');
        $xw->endAttribute();

        $xw->startAttribute('xmlns:x15');
        $xw->text('http://schemas.microsoft.com/office/spreadsheetml/2010/11/main');
        $xw->endAttribute();

        $xw->startElement('x15:timelineStyles');
        $xw->startAttribute('defaultTimelineStyle');
        $xw->text('TimeSlicerStyleLight1');
        $xw->endAttribute();

        $xw->endElement();
        $xw->endElement();
        $xw->endElement();
        $xw->endElement();

        return $this->finalizeXMLWriter($xw);
    }
}
