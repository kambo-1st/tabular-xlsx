<?php

namespace Kambo\Tabular\XLSX;

final class XLSXOptions
{
    public function __construct()
    {
    }

    public static function createWithDefaultsValues(): self
    {
        return new self();
    }
}
