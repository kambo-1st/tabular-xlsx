<?php

namespace Kambo\Tabular\XLSX\Writer\XLSX;

use Kambo\Tabular\XLSX\Writer\FileOptions;
use SplFileInfo;
use XMLWriter;

use function file_exists;
use function mkdir;

abstract class AbstractPart
{
    public function __construct(
        protected FileOptions $fileOptions,
        protected ?SplFileInfo $tempDirectory,
    ) {
    }

    protected function getXMLWriter(): XMLWriter
    {
        $XMLWriter = new XMLWriter();

        if ($this->fileOptions->inMemory()) {
            $XMLWriter->openMemory();
            if ($this->fileOptions->toPrettyPrint()) {
                $XMLWriter->setIndent(true);
                $XMLWriter->setIndentString('    ');
            }

            return $XMLWriter;
        }

        if (!file_exists($this->tempDirectory . '/' . $this->getDefaultPath())) {
            mkdir($this->tempDirectory . '/' . $this->getDefaultPath(), 0777, true);
        }

        $XMLWriter->openURI($this->tempDirectory . '/' . $this->getDefaultPath() . '/' . $this->getDefaultFilename());

        if ($this->fileOptions->toPrettyPrint()) {
            $XMLWriter->setIndent(true);
            $XMLWriter->setIndentString('    ');
        }

        return $XMLWriter;
    }

    protected function finalizeXMLWriter(XMLWriter $XMLWriter): ?string
    {
        if ($this->fileOptions->inMemory()) {
            return $XMLWriter->outputMemory();
        }

        $XMLWriter->flush();

        return null;
    }

    abstract protected function getDefaultPath(): string;
    abstract protected function getDefaultFilename(): string;
}
