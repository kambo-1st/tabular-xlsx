<?php

namespace Kambo\Tabular\XLSX\XLSX;

use DateTimeImmutable;

final class XLSXProperties
{
    private string $creator = 'Tabular';
    private DateTimeImmutable $created;

    public function __construct()
    {
        $this->created = new DateTimeImmutable();
    }

    public static function createWithDefaultsValues()
    {
        return new self();
    }

    public function withCreated(DateTimeImmutable $created): self
    {
        $dolly = clone $this;
        $dolly->created = $created;

        return $dolly;
    }

    public function withCreator(string $creator): self
    {
        $dolly = clone $this;
        $dolly->creator = $creator;

        return $dolly;
    }

    public function toCreated(): DateTimeImmutable
    {
        return $this->created;
    }

    public function toCreator(): string
    {
        return $this->creator;
    }
}
