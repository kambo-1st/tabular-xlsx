<?php

namespace Kambo\Tabular\XLSX\Writer\XLSX\Rels;

use Kambo\Tabular\XLSX\Writer\XLSX\AbstractPart;

final class Rels extends AbstractPart
{
    protected function getDefaultPath(): string
    {
        return '_rels';
    }

    protected function getDefaultFilename(): string
    {
        return '.rels';
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
        $xw->text('http://schemas.openxmlformats.org/officeDocument/2006/relationships/extended-properties');
        $xw->endAttribute();
        $xw->startAttribute('Target');
        $xw->text('docProps/app.xml');
        $xw->endAttribute();
        $xw->endElement();

        $xw->startElement('Relationship');
        $xw->startAttribute('Id');
        $xw->text('rId2');
        $xw->endAttribute();
        $xw->startAttribute('Type');
        $xw->text('http://schemas.openxmlformats.org/package/2006/relationships/metadata/core-properties');
        $xw->endAttribute();
        $xw->startAttribute('Target');
        $xw->text('docProps/core.xml');
        $xw->endAttribute();
        $xw->endElement();

        $xw->startElement('Relationship');
        $xw->startAttribute('Id');
        $xw->text('rId1');
        $xw->endAttribute();
        $xw->startAttribute('Type');
        $xw->text('http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument');
        $xw->endAttribute();
        $xw->startAttribute('Target');
        $xw->text('xl/workbook.xml');
        $xw->endAttribute();

        $xw->endElement();

        $xw->endElement();

        return $this->finalizeXMLWriter($xw);
    }
}
