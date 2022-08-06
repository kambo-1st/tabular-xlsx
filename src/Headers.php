<?php

namespace Kambo\Tabular\XLSX;

use Kambo\Tabular\XLSX\DataTypes\DataType;
use Kambo\Tabular\XLSX\DataTypes\StringType;
use Kambo\Tabular\XLSX\DataTypes\NumberType;
use Kambo\Tabular\XLSX\DataTypes\DateType;
use RuntimeException;

use function reset;
use function count;

final class Headers
{
    /**
     * @param Header[] $headers
     * @param bool     $showHeader
     */
    public function __construct(
        private array $headers = [],
        private bool $showHeader = true
    ) {
    }

    public static function create(
        array $headers = [],
        bool $showHeader = true
    ) {
        return new self($headers, $showHeader);
    }

    public function withShowHeader(bool $showHeader): self
    {
        $dolly = clone $this;
        $dolly->showHeader = $showHeader;

        return $dolly;
    }

    public function toShowHeader(): bool
    {
        return $this->showHeader;
    }

    public function withHeader(Header $header): self
    {
        $dolly            = clone $this;
        $dolly->headers[] = $header;

        return $dolly;
    }

    public function toHeaders(): array
    {
        return $this->headers;
    }

    public function toTypeAtPos(int $pos): DataType
    {
        if (isset($this->headers[$pos])) {
            return $this->headers[$pos]->toType();
        }

        return new StringType();
    }

    public function toHeaderAtPos(int $pos): Header
    {
        if (isset($this->headers[$pos])) {
            return $this->headers[$pos];
        }

        throw new RuntimeException('Header does not exists');
    }

    public function toHeadersNames(): array
    {
        $names = [];
        foreach ($this->headers as $header) {
            $label = '';
            if ($header->showLabel()) {
                $label = $header->toName();
            }

            $names[] = $label;
        }

        return $names;
    }

    public function toCustomFormatCount(): int
    {
        $count = 0;
        foreach ($this->getFormatsUnique() as $format) {
            [, $format] = reset($format);
            if (!$format->toFormat()->isPredefined()) {
                $count++;
            }
        }

        return $count;
    }

    public function toFormatCount(): int
    {
        return count($this->getFormatsUnique());
    }

    public function toFormatPosFromHeaderPos(int $pos)
    {
        $poss = 0;
        foreach ($this->getFormatsUnique() as $formats) {
            foreach ($formats as [$columnPoss]) {
                if ($columnPoss === $pos) {
                    return $poss;
                }
            }

            $poss++;
        }

        return 0;
    }

    public function toFormats(): array
    {
        $out = [];
        $codesequence = 164;
        foreach ($this->getFormatsUnique() as $key => $format) {
            [, $format] = reset($format);
            $custom = true;
            if ($format->toFormat()->isPredefined()) {
                $finalCode = $format->toFormat()->toCode();
                $custom = false;
            } else {
                $finalCode = $codesequence;
                $codesequence++;
            }

            $out[] = [$custom, $finalCode, $format->toFormat(), $key === 'General' ? false : true];
        }

        return $out;
    }

    private function getFormatsUnique(): array
    {
        $preprocessed = ['General' => [[null, StringType::create()]]];
        foreach ($this->headers as $index => $header) {
            if ($header->toType() instanceof NumberType || $header->toType() instanceof DateType) {
                $preprocessed[$header->toType() . $header->toType()->toFormat()][$index] = [$index, $header->toType()];
            }
        }

        return $preprocessed;
    }

    public function areEmpty(): bool
    {
        return count($this->headers) === 0;
    }
}
