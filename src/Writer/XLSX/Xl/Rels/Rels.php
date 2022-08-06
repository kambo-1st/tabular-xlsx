<?php

namespace Kambo\Tabular\XLSX\Writer\XLSX\Xl\Rels;

use Kambo\Tabular\XLSX\Writer\XLSX\AbstractPart;

final class Rels extends AbstractPart
{
    protected function getDefaultPath(): string
    {
        return 'xl/_rels';
    }

    protected function getDefaultFilename(): string
    {
        return 'workbook.xml.rels';
    }

    public function addData(mixed $data)
    {
    }

    public function generate()
    {
        $xw = $this->getXMLWriter();
        $xw->startDocument('1.0', 'UTF-8', 'yes');

        $xw->startElement('Relationships');
        $xw->startAttribute('xmlns');
        $xw->text('http://schemas.openxmlformats.org/package/2006/relationships');
        $xw->endAttribute();

        $xw->startElement('Relationship');
        $xw->startAttribute('Id');
        $xw->text('rId3');
        $xw->endAttribute();
        $xw->startAttribute('Type');
        $xw->text('http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles');
        $xw->endAttribute();
        $xw->startAttribute('Target');
        $xw->text('styles.xml');
        $xw->endAttribute();
        $xw->endElement();

        $xw->startElement('Relationship');
        $xw->startAttribute('Id');
        $xw->text('rId1');
        $xw->endAttribute();
        $xw->startAttribute('Type');
        $xw->text('http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet');
        $xw->endAttribute();
        $xw->startAttribute('Target');
        $xw->text('worksheets/sheet1.xml');
        $xw->endAttribute();
        $xw->endElement();

        $xw->startElement('Relationship');
        $xw->startAttribute('Id');
        $xw->text('rId4');
        $xw->endAttribute();
        $xw->startAttribute('Type');
        $xw->text('http://schemas.openxmlformats.org/officeDocument/2006/relationships/sharedStrings');
        $xw->endAttribute();
        $xw->startAttribute('Target');
        $xw->text('sharedStrings.xml');
        $xw->endAttribute();
        $xw->endElement();

        $xw->endElement();
        return $this->finalizeXMLWriter($xw);
    }
}
