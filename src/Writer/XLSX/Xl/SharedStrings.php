<?php

namespace Kambo\Tabular\XLSX\Writer\XLSX\Xl;

use Kambo\Tabular\XLSX\Writer\XLSX\AbstractPart;

final class SharedStrings extends AbstractPart
{
    protected function getDefaultPath(): string
    {
        return 'xl';
    }

    protected function getDefaultFilename(): string
    {
        return 'sharedStrings.xml';
    }

    public function addData(mixed $data)
    {
    }

    public function generate()
    {
        $xw = $this->getXMLWriter();
        $xw->startDocument('1.0', 'UTF-8', 'yes');
        $xw->startElement('sst');
        $xw->startAttribute('xmlns');
        $xw->text('http://schemas.openxmlformats.org/spreadsheetml/2006/main');
        $xw->endAttribute();
        $xw->startAttribute('count');
        $xw->text('4');
        $xw->endAttribute();
        $xw->startAttribute('uniqueCount');
        $xw->text('2');
        $xw->endAttribute();
        $xw->startElement('si');

        $xw->startElement('t');
        $xw->text('xxx');
        $xw->endElement();
        $xw->endElement();
        $xw->startElement('si');

        $xw->startElement('t');
        $xw->text('xxx');
        $xw->endElement();
        $xw->endElement();
        $xw->endElement();
        return $this->finalizeXMLWriter($xw);
    }
}
