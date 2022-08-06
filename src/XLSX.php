<?php

namespace Kambo\Tabular\XLSX;

use SplFileInfo;
use RuntimeException;
use Kambo\Tabular\XLSX\Writer\File;
use Kambo\Tabular\XLSX\Writer\FileOptions;
use Kambo\Tabular\XLSX\Writer\XLSX\Xl\Worksheets\Sheet;
use Kambo\Tabular\XLSX\XLSX\XLSXProperties;

final class XLSX
{
    private ?SplFileInfo $outputFile = null;
    private XLSXOptions $options;
    private File $file;
    private ?SplFileInfo $tempFolder = null;
    private XLSXProperties $XLSXProperties;
    private Headers $headers;

    private ?Sheet $sheet = null;

    private function __construct(
        ?SplFileInfo $outputFile = null,
        ?XLSXOptions $options = null,
        ?File $file = null
    ) {
        $this->outputFile = $outputFile;

        if ($options === null) {
            $options = XLSXOptions::createWithDefaultsValues();
        }

        if ($file === null) {
            $file = new File();
        }

        $this->options = $options;
        $this->file    = $file;
        $this->headers = Headers::create()->withShowHeader(false);

        $this->XLSXProperties = XLSXProperties::createWithDefaultsValues();
    }

    public static function createEmpty(
        ?XLSXOptions $options = null,
        ?File $file = null
    ) {
        return new self(null, $options, $file);
    }

    public static function createFromFileObject(
        SplFileInfo $outputFile,
        ?XLSXOptions $options = null,
        ?File $file = null
    ) {
        return new self($outputFile, $options, $file);
    }

    public function setHeaders(Headers $headers): void
    {
        $this->headers = $headers;
    }

    public function addProperties(XLSXProperties $XLSXProperties): void
    {
        $this->XLSXProperties = $XLSXProperties;
    }

    public function addRow(array $array): void
    {
        $this->getSheet()->addData($array);
    }

    public function save(?SplFileInfo $outputFile = null): void
    {
        if ($this->outputFile === null && $outputFile === null) {
            throw new RuntimeException('Output file must be provided');
        }

        $outputFile = $outputFile ?? $this->outputFile;

        $temp = $this->getTempFolder();

        $files   = [];
        $files[] = new Writer\XLSX\ContentTypes(FileOptions::create(), $temp);
        $files[] = new Writer\XLSX\DocProps\App(FileOptions::create(), $temp);

        $core = new Writer\XLSX\DocProps\Core(FileOptions::create(), $temp);
        $core->addCreated($this->XLSXProperties->toCreated());
        $core->addCreator($this->XLSXProperties->toCreator());
        $files[] = $core;

        $files[] = new Writer\XLSX\Rels\Rels(FileOptions::create(), $temp);
        $files[] = new Writer\XLSX\Xl\Rels\Rels(FileOptions::create(), $temp);
        $files[] = new Writer\XLSX\Xl\SharedStrings(FileOptions::create(), $temp);
        $files[] = new Writer\XLSX\Xl\Workbook(FileOptions::create(), $temp);

        $styles = new Writer\XLSX\Xl\Styles(FileOptions::create(), $temp);
        $styles->addData($this->headers);
        $files[] = $styles;

        $files[] = $this->sheet;

        foreach ($files as $file) {
            $file->generate();
        }

        $this->file->compressDirectory($temp, $outputFile);
    }

    private function getTempFolder(): SplFileInfo
    {
        if ($this->tempFolder === null) {
            $this->tempFolder = $this->file->createTempFolder(null, 'tabular');
        }

        return $this->tempFolder;
    }

    private function getSheet(): Sheet
    {
        if ($this->sheet === null) {
            $temp        = $this->getTempFolder();
            $options     = FileOptions::create();
            $this->sheet = new Sheet($options, $temp, $this->headers);
            if ($this->headers->toShowHeader()) {
                $this->sheet->addData($this->headers->toHeadersNames(), true);
            }
        }

        return $this->sheet;
    }
}
