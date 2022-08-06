<?php

namespace Kambo\Tabular\XLSX\Writer\XLSX\Xl\Worksheets;

use Kambo\Tabular\XLSX\Headers;
use Kambo\Tabular\XLSX\Writer\FileOptions;
use Kambo\Tabular\XLSX\Writer\XLSX\AbstractPart;
use XMLWriter;
use SplFileInfo;
use DateTime;
use Kambo\Tabular\XLSX\DataTypes\BoolType;
use Kambo\Tabular\XLSX\DataTypes\DateType;
use Kambo\Tabular\XLSX\DataTypes\StringType;
use Kambo\Tabular\XLSX\DataTypes\NumberType;

final class Sheet extends AbstractPart
{
    private XMLWriter $xmlWriter;
    private int $rowCount = 0;
    private int $nonPersistedRows = 0;
    private Headers $headers;

    public function __construct(
        FileOptions $fileOptions,
        ?SplFileInfo $tempDirectory,
        Headers $headers,
    ) {
        parent::__construct($fileOptions, $tempDirectory);
        $this->headers = $headers;
        $this->generatePreamble();
    }

    protected function getDefaultPath(): string
    {
        return 'xl/worksheets';
    }

    protected function getDefaultFilename(): string
    {
        return 'sheet1.xml';
    }

    public function addData(mixed $data, bool $ignoreType = false)
    {
        $rowCount = ++$this->rowCount;
        $this->generateRow($data, $rowCount, $ignoreType);

        $this->nonPersistedRows++;

        if ($this->nonPersistedRows >= $this->fileOptions->toFlushRows() && $this->fileOptions->inMemory() !== true) {
            $this->xmlWriter->flush();
            $this->nonPersistedRows = 0;
        }
    }

    private function generatePreamble()
    {
        $this->xmlWriter = $this->getXMLWriter();
        $xw = $this->xmlWriter;

        $xw->startDocument('1.0', 'UTF-8', 'yes');
        $xw->startElement('worksheet');
        $xw->startAttribute('xmlns');
        $xw->text('http://schemas.openxmlformats.org/spreadsheetml/2006/main');
        $xw->endAttribute();
        $xw->startAttribute('xmlns:r');
        $xw->text('http://schemas.openxmlformats.org/officeDocument/2006/relationships');
        $xw->endAttribute();
        $xw->startAttribute('xmlns:mc');
        $xw->text('http://schemas.openxmlformats.org/markup-compatibility/2006');
        $xw->endAttribute();
        $xw->startAttribute('xmlns:x14ac');
        $xw->text('http://schemas.microsoft.com/office/spreadsheetml/2009/9/ac');
        $xw->endAttribute();
        $xw->startAttribute('xmlns:xr');
        $xw->text('http://schemas.microsoft.com/office/spreadsheetml/2014/revision');
        $xw->endAttribute();
        $xw->startAttribute('xmlns:xr2');
        $xw->text('http://schemas.microsoft.com/office/spreadsheetml/2015/revision2');
        $xw->endAttribute();
        $xw->startAttribute('xmlns:xr3');
        $xw->text('http://schemas.microsoft.com/office/spreadsheetml/2016/revision3');
        $xw->endAttribute();
        $xw->startAttribute('mc:Ignorable');
        $xw->text('x14ac xr xr2 xr3');
        $xw->endAttribute();
        $xw->startAttribute('xr:uid');
        $xw->text('{23E87883-0318-4168-A525-D73F9F9B2366}');
        $xw->endAttribute();
        $xw->startElement('dimension');
        $xw->startAttribute('ref');
        $xw->text('A1:C3');
        $xw->endAttribute();
        $xw->endElement();
        $xw->startElement('sheetViews');

        $xw->startElement('sheetView');
        $xw->startAttribute('tabSelected');
        $xw->text('1');
        $xw->endAttribute();
        $xw->startAttribute('workbookViewId');
        $xw->text('0');
        $xw->endAttribute();

        $xw->startElement('selection');
        $xw->startAttribute('activeCell');
        $xw->text('D8');
        $xw->endAttribute();
        $xw->startAttribute('sqref');
        $xw->text('D8');
        $xw->endAttribute();
        $xw->endElement();
        $xw->endElement();
        $xw->endElement();
        $xw->startElement('sheetFormatPr');

        $xw->startAttribute('defaultRowHeight');
        $xw->text('15');
        $xw->endAttribute();

        $xw->startAttribute('x14ac:dyDescent');
        $xw->text('0.25');
        $xw->endAttribute();

        $xw->endElement();
        $xw->startElement('sheetData');
    }

    private function generateFinish()
    {
        $xw = $this->xmlWriter;
        $xw->endElement();

        $xw->startElement('pageMargins');
        $xw->startAttribute('left');
        $xw->text('0.7');
        $xw->endAttribute();
        $xw->startAttribute('right');
        $xw->text('0.7');
        $xw->endAttribute();
        $xw->startAttribute('top');
        $xw->text('0.75');
        $xw->endAttribute();
        $xw->startAttribute('bottom');
        $xw->text('0.75');
        $xw->endAttribute();
        $xw->startAttribute('header');
        $xw->text('0.3');
        $xw->endAttribute();
        $xw->startAttribute('footer');
        $xw->text('0.3');
        $xw->endAttribute();
        $xw->endElement();
        $xw->startElement('pageSetup');

        $xw->startAttribute('paperSize');
        $xw->text('9');
        $xw->endAttribute();

        $xw->startAttribute('orientation');
        $xw->text('portrait');
        $xw->endAttribute();

        $xw->endElement();
        $xw->endElement();
    }

    public function generate()
    {
        $xw = $this->xmlWriter;

        $this->generateFinish();

        return $this->finalizeXMLWriter($xw);
    }

    private function generateRow(array $row, int $rowCount, bool $ignoreType = false): void
    {
        $xw = $this->xmlWriter;
        $xw->startElement('row');

        $xw->startAttribute('r');
        $xw->text($rowCount);
        $xw->endAttribute();

        $columnName = 'A';
        $position   = 0;
        foreach ($row as $column) {
            $this->renderCell($column, $columnName, $rowCount, $position, $ignoreType);
            $columnName++;
            $position++;
        }

        $xw->endElement();
    }

    public function renderCell($column, $columnName, $rowCount, $position, bool $ignoreType = false)
    {
        $type = $this->headers->toTypeAtPos($position);
        $xw   = $this->xmlWriter;

        if ($ignoreType) {
            $type = StringType::create();
        }

        $xw->startElement('c');
        $xw->startAttribute('r');
        $xw->text($columnName . $rowCount);
        $xw->endAttribute();

        if ($type instanceof StringType && $column instanceof DateTime) {
            $column = $column->format('Y-m-d H:i:s');
        }

        if ($this->headers->areEmpty() || $this->headers->toHeaderAtPos($position)->toValidate()) {
            $type->validate($column);
        }

        switch (true) {
            case $type instanceof StringType:
                $xw->startAttribute('t');
                $xw->text('inlineStr');
                $xw->endAttribute();

                $xw->startElement('is');
                $xw->startElement('t');

                $xw->text($column);

                $xw->endElement();
                $xw->endElement();

                break;
            case $type instanceof NumberType:
                $xw->startAttribute('t');
                $xw->text('n');
                $xw->endAttribute();

                $xw->startAttribute('s');
                $xw->text($this->headers->toFormatPosFromHeaderPos($position));
                $xw->endAttribute();

                $xw->startElement('v');
                $xw->text($column);
                $xw->endElement();

                break;
            case $type instanceof BoolType:
                $xw->startAttribute('t');
                $xw->text('b');
                $xw->endAttribute();

                $xw->startElement('v');
                $xw->text($column === true ? 1 : 0);
                $xw->endElement();

                break;
            case $type instanceof DateType:
                // Date is stored as a number and formatted as a date
                $xw->startAttribute('t');
                $xw->text('n');
                $xw->endAttribute();

                $xw->startAttribute('s');
                $xw->text($this->headers->toFormatPosFromHeaderPos($position));
                $xw->endAttribute();

                $xw->startElement('v');

                // Number of day from 1/1/1900.
                $column = 25569 + $column->getTimestamp() / 86400;

                $xw->text($column);
                $xw->endElement();

                break;
        }

        $xw->endElement();
    }
}
