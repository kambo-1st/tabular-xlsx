<?php

require_once '../vendor/autoload.php';

use Kambo\Tabular\XLSX\Headers;
use Kambo\Tabular\XLSX\XLSX;
use Kambo\Tabular\XLSX\Header;
use Kambo\Tabular\XLSX\DataTypes\StringType;
use Kambo\Tabular\XLSX\DataTypes\NumberType;
use Kambo\Tabular\XLSX\DataTypes\BoolType;
use Kambo\Tabular\XLSX\DataTypes\DateType;

$xlsx = XLSX::createFromFileObject(new SplFileInfo('complexfile.xlsx'));

$xlsx->setHeaders(
    Headers::create()
        ->withHeader(Header::create(StringType::create(), 'Text type'))
        ->withHeader(Header::create(NumberType::create(), 'Number type'))
        ->withHeader(Header::create(BoolType::create(), 'Bool type'))
        ->withHeader(Header::create(DateType::create(), 'Date type'))
);

$xlsx->addRow(['hello', 42, false, new DateTimeImmutable('2000-01-01')]);

$xlsx->save();
