<?php

namespace Kambo\Tabular\XLSX\Writer\XLSX;

/**
 * List content types for all files types + extensions
 */
final class ContentTypes extends AbstractPart
{
    protected function getDefaultPath(): string
    {
        return '';
    }

    protected function getDefaultFilename(): string
    {
        return '[Content_Types].xml';
    }

    public function addData(mixed $data)
    {
    }

    public function generate(): ?string
    {
        $xw = $this->getXMLWriter();

        $xw->startDocument('1.0', 'UTF-8', 'yes');
        $xw->startElement('Types');
        $xw->startAttribute('xmlns');
        $xw->text('http://schemas.openxmlformats.org/package/2006/content-types');
        $xw->endAttribute();

        $xw->startElement('Default');
        $xw->startAttribute('Extension');
        $xw->text('bin');
        $xw->endAttribute();
        $xw->startAttribute('ContentType');
        $xw->text('application/vnd.openxmlformats-officedocument.spreadsheetml.printerSettings');
        $xw->endAttribute();
        $xw->endElement();

        $xw->startElement('Default');
        $xw->startAttribute('Extension');
        $xw->text('rels');
        $xw->endAttribute();
        $xw->startAttribute('ContentType');
        $xw->text('application/vnd.openxmlformats-package.relationships+xml');
        $xw->endAttribute();
        $xw->endElement();

        $xw->startElement('Default');
        $xw->startAttribute('Extension');
        $xw->text('xml');
        $xw->endAttribute();
        $xw->startAttribute('ContentType');
        $xw->text('application/xml');
        $xw->endAttribute();
        $xw->endElement();

        $xw->startElement('Override');
        $xw->startAttribute('PartName');
        $xw->text('/xl/workbook.xml');
        $xw->endAttribute();
        $xw->startAttribute('ContentType');
        $xw->text('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml');
        $xw->endAttribute();
        $xw->endElement();

        $xw->startElement('Override');
        $xw->startAttribute('PartName');
        $xw->text('/xl/worksheets/sheet1.xml');
        $xw->endAttribute();
        $xw->startAttribute('ContentType');
        $xw->text('application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml');
        $xw->endAttribute();
        $xw->endElement();

        $xw->startElement('Override');
        $xw->startAttribute('PartName');
        $xw->text('/xl/styles.xml');
        $xw->endAttribute();
        $xw->startAttribute('ContentType');
        $xw->text('application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml');
        $xw->endAttribute();
        $xw->endElement();

        $xw->startElement('Override');
        $xw->startAttribute('PartName');
        $xw->text('/xl/sharedStrings.xml');
        $xw->endAttribute();
        $xw->startAttribute('ContentType');
        $xw->text('application/vnd.openxmlformats-officedocument.spreadsheetml.sharedStrings+xml');
        $xw->endAttribute();
        $xw->endElement();

        $xw->startElement('Override');
        $xw->startAttribute('PartName');
        $xw->text('/docProps/core.xml');
        $xw->endAttribute();
        $xw->startAttribute('ContentType');
        $xw->text('application/vnd.openxmlformats-package.core-properties+xml');
        $xw->endAttribute();
        $xw->endElement();

        $xw->startElement('Override');
        $xw->startAttribute('PartName');
        $xw->text('/docProps/app.xml');
        $xw->endAttribute();
        $xw->startAttribute('ContentType');
        $xw->text('application/vnd.openxmlformats-officedocument.extended-properties+xml');
        $xw->endAttribute();
        $xw->endElement();

        $xw->endElement();

        return $this->finalizeXMLWriter($xw);
    }
}
