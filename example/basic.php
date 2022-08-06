<?php

require_once '../vendor/autoload.php';

$xlsx = \Kambo\Tabular\XLSX\XLSX::createFromFileObject(new SplFileInfo('basicfile.xlsx'));

$xlsx->addRow(['hello', 'world']);

$xlsx->save();
