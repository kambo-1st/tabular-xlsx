<?php

declare(strict_types=1);

namespace Kambo\Tabular\XLSX\Test\E2E;

use Kambo\Tabular\XLSX\DataTypes\BoolType;
use Kambo\Tabular\XLSX\XLSX;
use Kambo\Tabular\XLSX\Header;
use Kambo\Tabular\XLSX\DataTypes\StringType;
use Kambo\Tabular\XLSX\DataTypes\NumberType;
use Kambo\Tabular\XLSX\DataTypes\DateType;
use Kambo\Tabular\XLSX\Headers;
use PHPUnit\Framework\TestCase;
use SplFileInfo;
use RuntimeException;
use DateTimeImmutable;

use function uniqid;
use function rand;
use function exec;
use function fopen;
use function explode;
use function fread;
use function filesize;
use function is_null;
use function sys_get_temp_dir;
use function rtrim;
use function is_dir;
use function is_writable;
use function strpbrk;
use function sprintf;
use function mt_rand;
use function mkdir;

use const DIRECTORY_SEPARATOR;

class FileContentTest extends TestCase
{
    public function testBasicFileContent(): void
    {
        $input = new SplFileInfo($this->getTempFolder() . DIRECTORY_SEPARATOR . 'basicfile.xlsx');
        $xlsx = XLSX::createFromFileObject($input);

        $xlsx->addRow(['hello', 'world']);
        $xlsx->addRow(['foo', 'bar']);
        $xlsx->addRow(['boom', 'toon']);

        $xlsx->save();

        $this->assertXLSXContent($input, ['hello,world', 'foo,bar', 'boom,toon','']);
    }

    public function testBasicFileContentWithHeader(): void
    {
        $input = new SplFileInfo($this->getTempFolder() . DIRECTORY_SEPARATOR . 'basicfile.xlsx');
        $xlsx = XLSX::createFromFileObject($input);
        $xlsx->setHeaders(
            Headers::create()
                ->withHeader(Header::create(StringType::create(), 'column 1'))
                ->withHeader(Header::create(StringType::create(), 'column 2'))
        );

        $xlsx->addRow(['hello', 'world']);
        $xlsx->addRow(['foo', 'bar']);
        $xlsx->addRow(['boom', 'toon']);

        $xlsx->save();

        $this->assertXLSXContent($input, ['"column 1","column 2"', 'hello,world', 'foo,bar', 'boom,toon','']);
    }

    public function testBasicFileContentWithHeaderSomeDisabled(): void
    {
        $input = new SplFileInfo($this->getTempFolder() . DIRECTORY_SEPARATOR . 'basicfile.xlsx');
        $xlsx = XLSX::createFromFileObject($input);
        $xlsx->setHeaders(
            Headers::create()
                ->withHeader(Header::createWithHiddenLabel(StringType::create(), 'column 1'))
                ->withHeader(Header::create(StringType::create(), 'column 2'))
        );

        $xlsx->addRow(['hello', 'world']);
        $xlsx->addRow(['foo', 'bar']);
        $xlsx->addRow(['boom', 'toon']);

        $xlsx->save();

        $this->assertXLSXContent($input, [',"column 2"', 'hello,world', 'foo,bar', 'boom,toon','']);
    }

    public function testBasicFileContentWithHeaderTypes(): void
    {
        $input = new SplFileInfo($this->getTempFolder() . DIRECTORY_SEPARATOR . 'basicfile.xlsx');
        $xlsx = XLSX::createFromFileObject($input);
        $xlsx->setHeaders(
            Headers::create()
                ->withHeader(Header::create(StringType::create(), 'string'))
                ->withHeader(Header::create(NumberType::create(), 'number'))
                ->withHeader(Header::create(BoolType::create(), 'bool'))
                ->withHeader(Header::create(DateType::create(), 'date'))
        );

        $xlsx->addRow(['hello', 88, true, new DateTimeImmutable('1988-01-01')]);
        $xlsx->addRow(['foo', 2, false, new DateTimeImmutable('2000-01-01')]);
        $xlsx->addRow(['boom', 42, true, new DateTimeImmutable('2021-12-31')]);

        $xlsx->save();

        $this->assertXLSXContent(
            $input,
            [
                'string,number,bool,date',
                'hello,88,TRUE,1988/01/01',
                'foo,2,FALSE,2000/01/01',
                'boom,42,TRUE,2021/12/31',
                ''
            ]
        );
    }

    public function testCreateEmpty(): void
    {
        $input = new SplFileInfo($this->getTempFolder() . DIRECTORY_SEPARATOR . 'basicfile.xlsx');
        $xlsx = XLSX::createEmpty();

        $xlsx->addRow(['hello', 'world']);
        $xlsx->addRow(['foo', 'bar']);

        $xlsx->save($input);

        $this->assertXLSXContent($input, ['hello,world', 'foo,bar', '']);
    }

    protected function assertXLSXContent(SplFileInfo $xslxFile, array $content)
    {
        $filename = $this->getTempFolder() . DIRECTORY_SEPARATOR . uniqid((string)rand(), true) . '.csv';
        $inputFile = $xslxFile->getRealPath();

        exec('ssconvert ' . $inputFile . ' ' . $filename);

        $fp = @fopen($filename, 'r');

        if ($fp) {
            $array = explode("\n", fread($fp, filesize($filename)));
        } else {
            throw new RuntimeException('Cannot read file: ' . $filename);
        }

        $this->assertEquals($content, $array);
    }

    /**
     * Creates a random unique temporary directory, with specified parameters,
     * that does not already exist (like tempnam(), but for dirs).
     *
     * Created dir will begin with the specified prefix, followed by random
     * numbers.
     *
     * @link https://php.net/manual/en/function.tempnam.php
     *
     * @param string|null $dir Base directory under which to create temp dir.
     *     If null, the default system temp dir (sys_get_temp_dir()) will be
     *     used.
     * @param string $prefix String with which to prefix created dirs.
     * @param int $mode Octal file permission mask for the newly-created dir.
     *     Should begin with a 0.
     * @param int $maxAttempts Maximum attempts before giving up (to prevent
     *     endless loops).
     *
     * @return SplFileInfo Full path to newly-created dir
     */
    private function getTempFolder(
        $dir = null,
        $prefix = 'tmp_',
        $mode = 0700,
        $maxAttempts = 10
    ): SplFileInfo {
        /* Use the system temp dir by default. */
        if (is_null($dir)) {
            $dir = sys_get_temp_dir();
        }

        /* Trim trailing slashes from $dir. */
        $dir = rtrim($dir, DIRECTORY_SEPARATOR);

        /* If we don't have permission to create a directory, fail, otherwise we will
         * be stuck in an endless loop.
         */
        if (!is_dir($dir) || !is_writable($dir)) {
            throw new RuntimeException('Target directory is not writable, dir: ' . $dir);
        }

        /* Make sure characters in prefix are safe. */
        if (strpbrk($prefix, '\\/:*?"<>|') !== false) {
            throw new RuntimeException('Character in prefix are not safe, prefix: ' . $prefix);
        }

        /* Attempt to create a random directory until it works. Abort if we reach
         * $maxAttempts. Something screwy could be happening with the filesystem
         * and our loop could otherwise become endless.
         */
        for ($i = 0; $i < $maxAttempts; ++$i) {
            $path = sprintf(
                '%s%s%s%s',
                $dir,
                DIRECTORY_SEPARATOR,
                $prefix,
                uniqid((string)mt_rand(), true)
            );

            if (mkdir($path, $mode, true)) {
                return new SplFileInfo($path);
            }
        }

        throw new RuntimeException('Maximum number of attempts has been reached, prefix: ' . $i);
    }
}
