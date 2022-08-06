<?php

namespace Kambo\Tabular\XLSX\Writer\XLSX\DocProps;

use Kambo\Tabular\XLSX\Writer\XLSX\AbstractPart;

final class App extends AbstractPart
{
    protected function getDefaultPath(): string
    {
        return 'docProps';
    }

    protected function getDefaultFilename(): string
    {
        return 'app.xml';
    }

    public function addData(mixed $data)
    {
    }

    public function generate()
    {
        $xw = $this->getXMLWriter();
        $xw->startDocument('1.0', 'UTF-8', 'yes');
        $xw->startElement('Properties');
        $xw->startAttribute('xmlns');
        $xw->text('http://schemas.openxmlformats.org/officeDocument/2006/extended-properties');
        $xw->endAttribute();
        $xw->startAttribute('xmlns:vt');
        $xw->text('http://schemas.openxmlformats.org/officeDocument/2006/docPropsVTypes');
        $xw->endAttribute();
        $xw->startElement('Application');
        $xw->text('Tabular');
        $xw->endElement();
        $xw->startElement('DocSecurity');
        $xw->text('0');
        $xw->endElement();
        $xw->startElement('ScaleCrop');
        $xw->text('false');
        $xw->endElement();
        $xw->startElement('HeadingPairs');

        $xw->startElement('vt:vector');
        $xw->startAttribute('size');
        $xw->text('2');
        $xw->endAttribute();
        $xw->startAttribute('baseType');
        $xw->text('variant');
        $xw->endAttribute();

        $xw->startElement('vt:variant');

        $xw->startElement('vt:lpstr');
        $xw->text('Worksheets');
        $xw->endElement();
        $xw->endElement();
        $xw->startElement('vt:variant');

        $xw->startElement('vt:i4');
        $xw->text('1');
        $xw->endElement();
        $xw->endElement();
        $xw->endElement();
        $xw->endElement();
        $xw->startElement('TitlesOfParts');

        $xw->startElement('vt:vector');
        $xw->startAttribute('size');
        $xw->text('1');
        $xw->endAttribute();
        $xw->startAttribute('baseType');
        $xw->text('lpstr');
        $xw->endAttribute();

        $xw->startElement('vt:lpstr');
        $xw->text('Sheet1');
        $xw->endElement();
        $xw->endElement();
        $xw->endElement();

        $xw->startElement('Company');
        $xw->text('');
        $xw->endElement();

        $xw->startElement('LinksUpToDate');
        $xw->text('false');
        $xw->endElement();

        $xw->startElement('SharedDoc');
        $xw->text('false');
        $xw->endElement();

        $xw->startElement('HyperlinksChanged');
        $xw->text('false');
        $xw->endElement();

        $xw->startElement('AppVersion');
        $xw->text('0.0.1');
        $xw->endElement();

        $xw->endElement();

        return $this->finalizeXMLWriter($xw);
    }
}
