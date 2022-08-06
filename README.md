# Tabular XLSX

[![Latest Version on Packagist](https://img.shields.io/packagist/v/kambo-1st/tabular-xlsx.svg?style=flat-square)](https://packagist.org/packages/kambo-1st/tabular-xlsx)
[![Total Downloads](https://img.shields.io/packagist/dt/kambo-1st/tabular-xlsx.svg?style=flat-square)](https://packagist.org/packages/kambo-1st/tabular-xlsx)

Tabular XLSX - an easy and effective way how to access XLSX data

## Installation

You can install the package via composer:

```bash
composer require kambo/tabular-xlsx
```

## Usage

```php
$xlsx = \Kambo\Tabular\XLSX\XLSX::createFromFileObject(new SplFileInfo('basicfile.xlsx'));

$xlsx->addRow(['hello', 'world']);

$xlsx->save();
```

## Testing

```bash
composer test
```

## Credits

- [Bohuslav Šimek](https://github.com/kambo-1st)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
