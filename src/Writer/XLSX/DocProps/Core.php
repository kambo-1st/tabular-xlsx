<?php

namespace Kambo\Tabular\XLSX\Writer\XLSX\DocProps;

use Kambo\Tabular\XLSX\Writer\XLSX\AbstractPart;
use DateTimeImmutable;
use DateTime;

final class Core extends AbstractPart
{
    private string $creator = 'Tabular';
    private ?DateTimeImmutable $created = null;

    protected function getDefaultPath(): string
    {
        return 'docProps';
    }

    protected function getDefaultFilename(): string
    {
        return 'core.xml';
    }

    public function addCreator(string $creator)
    {
        $this->creator = $creator;
    }

    public function addCreated(DateTimeImmutable $created)
    {
        $this->created = $created;
    }

    public function generate()
    {
        $xw = $this->getXMLWriter();
        $xw->startDocument('1.0', 'UTF-8', 'yes');
        $xw->startElement('cp:coreProperties');

        $xw->startAttribute('xmlns:cp');
        $xw->text('http://schemas.openxmlformats.org/package/2006/metadata/core-properties');
        $xw->endAttribute();

        $xw->startAttribute('xmlns:dc');
        $xw->text('http://purl.org/dc/elements/1.1/');
        $xw->endAttribute();

        $xw->startAttribute('xmlns:dcterms');
        $xw->text('http://purl.org/dc/terms/');
        $xw->endAttribute();

        $xw->startAttribute('xmlns:dcmitype');
        $xw->text('http://purl.org/dc/dcmitype/');
        $xw->endAttribute();

        $xw->startAttribute('xmlns:xsi');
        $xw->text('http://www.w3.org/2001/XMLSchema-instance');
        $xw->endAttribute();

        $xw->startElement('dc:creator');
        $xw->text($this->creator);
        $xw->endElement();

        $datetime = $this->created ?? new DateTimeImmutable();

        $xw->startElement('dcterms:created');
        $xw->startAttribute('xsi:type');
        $xw->text('dcterms:W3CDTF');
        $xw->endAttribute();
        $xw->text($datetime->format(DateTime::ATOM));
        $xw->endElement();

        $xw->endElement();
        return $this->finalizeXMLWriter($xw);
    }
}
