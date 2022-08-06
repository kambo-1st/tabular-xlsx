<?php

namespace Kambo\Tabular\XLSX\Writer;

final class FileOptions
{
    public function __construct(
        private int $flushRows = 1,
        private bool $prettyPrint = false,
        private bool $memory = false,
    ) {
    }

    public static function create()
    {
        return new self();
    }

    public function toFlushRows(): int
    {
        return $this->flushRows;
    }

    public function toPrettyPrint(): bool
    {
        return $this->prettyPrint;
    }

    public function inMemory(): bool
    {
        return $this->memory;
    }

    public function withInMemory(bool $inMemory): self
    {
        $dolly = clone $this;

        $dolly->memory = $inMemory;

        return $dolly;
    }
}
