<?php

namespace Kambo\Tabular\XLSX;

use Kambo\Tabular\XLSX\DataTypes\DataType;
use InvalidArgumentException;

final class Header
{
    public function __construct(
        private DataType $type,
        private string $name,
        private bool $validate = true,
        private bool $showLabel = true
    ) {
        if (empty($name)) {
            throw new InvalidArgumentException('Name must not be empty');
        }
    }

    public static function create(
        DataType $type,
        string $name,
    ): self {
        return new self($type, $name);
    }

    public static function createWithHiddenLabel(
        DataType $type,
        string $name,
    ): self {
        return new self(type: $type, name: $name, showLabel: false);
    }

    public function toType(): DataType
    {
        return $this->type;
    }

    public function toName(): string
    {
        return $this->name;
    }

    public function showLabel(): bool
    {
        return $this->showLabel;
    }

    public function toValidate(): bool
    {
        return $this->validate;
    }
}
