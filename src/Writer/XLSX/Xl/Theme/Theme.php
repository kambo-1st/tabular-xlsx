<?php

namespace Kambo\Tabular\XLSX\Writer\XLSX\Xl\Theme;

use Kambo\Tabular\XLSX\Writer\XLSX\AbstractPart;

final class Theme extends AbstractPart
{
    protected function getDefaultPath(): string
    {
        return 'xl/theme';
    }

    protected function getDefaultFilename(): string
    {
        return 'theme1.xml';
    }

    public function addData(mixed $data)
    {
    }

    public function generate()
    {
        $xw = $this->getXMLWriter();

        $xw->startDocument('1.0', 'UTF-8', 'yes');
        $xw->startElement('a:theme');
        $xw->startAttribute('xmlns:a');
        $xw->text('http://schemas.openxmlformats.org/drawingml/2006/main');
        $xw->endAttribute();
        $xw->startAttribute('xmlns:thm15');
        $xw->text('http://schemas.microsoft.com/office/thememl/2012/main');
        $xw->endAttribute();
        $xw->startAttribute('name');
        $xw->text('Office Theme');
        $xw->endAttribute();
        $xw->startElement('a:themeElements');

        $xw->startElement('a:clrScheme');
        $xw->startAttribute('name');
        $xw->text('Office');
        $xw->endAttribute();

        $xw->startElement('a:dk1');

        $xw->startElement('a:sysClr');
        $xw->startAttribute('val');
        $xw->text('windowText');
        $xw->endAttribute();
        $xw->startAttribute('lastClr');
        $xw->text('000000');
        $xw->endAttribute();
        $xw->endElement();
        $xw->endElement();
        $xw->startElement('a:lt1');

        $xw->startElement('a:sysClr');
        $xw->startAttribute('val');
        $xw->text('window');
        $xw->endAttribute();
        $xw->startAttribute('lastClr');
        $xw->text('FFFFFF');
        $xw->endAttribute();
        $xw->endElement();
        $xw->endElement();
        $xw->startElement('a:dk2');

        $xw->startElement('a:srgbClr');
        $xw->startAttribute('val');
        $xw->text('44546A');
        $xw->endAttribute();
        $xw->endElement();
        $xw->endElement();
        $xw->startElement('a:lt2');

        $xw->startElement('a:srgbClr');
        $xw->startAttribute('val');
        $xw->text('E7E6E6');
        $xw->endAttribute();
        $xw->endElement();
        $xw->endElement();
        $xw->startElement('a:accent1');

        $xw->startElement('a:srgbClr');
        $xw->startAttribute('val');
        $xw->text('4472C4');
        $xw->endAttribute();
        $xw->endElement();
        $xw->endElement();
        $xw->startElement('a:accent2');

        $xw->startElement('a:srgbClr');
        $xw->startAttribute('val');
        $xw->text('ED7D31');
        $xw->endAttribute();
        $xw->endElement();
        $xw->endElement();
        $xw->startElement('a:accent3');

        $xw->startElement('a:srgbClr');
        $xw->startAttribute('val');
        $xw->text('A5A5A5');
        $xw->endAttribute();
        $xw->endElement();
        $xw->endElement();
        $xw->startElement('a:accent4');

        $xw->startElement('a:srgbClr');
        $xw->startAttribute('val');
        $xw->text('FFC000');
        $xw->endAttribute();
        $xw->endElement();
        $xw->endElement();
        $xw->startElement('a:accent5');

        $xw->startElement('a:srgbClr');
        $xw->startAttribute('val');
        $xw->text('5B9BD5');
        $xw->endAttribute();
        $xw->endElement();
        $xw->endElement();
        $xw->startElement('a:accent6');

        $xw->startElement('a:srgbClr');
        $xw->startAttribute('val');
        $xw->text('70AD47');
        $xw->endAttribute();
        $xw->endElement();
        $xw->endElement();
        $xw->startElement('a:hlink');

        $xw->startElement('a:srgbClr');
        $xw->startAttribute('val');
        $xw->text('0563C1');
        $xw->endAttribute();
        $xw->endElement();
        $xw->endElement();
        $xw->startElement('a:folHlink');

        $xw->startElement('a:srgbClr');
        $xw->startAttribute('val');
        $xw->text('954F72');
        $xw->endAttribute();
        $xw->endElement();
        $xw->endElement();
        $xw->endElement();
        $xw->startElement('a:fontScheme');
        $xw->startAttribute('name');
        $xw->text('Office');
        $xw->endAttribute();

        $xw->startElement('a:majorFont');

        return $this->finalizeXMLWriter($xw);
    }
}
