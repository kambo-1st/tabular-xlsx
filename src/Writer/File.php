<?php

namespace Kambo\Tabular\XLSX\Writer;

use SplFileInfo;
use RuntimeException;
use ZipArchive;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

use function is_null;
use function sys_get_temp_dir;
use function rtrim;
use function is_dir;
use function is_writable;
use function strpbrk;
use function sprintf;
use function uniqid;
use function mt_rand;
use function mkdir;
use function realpath;
use function substr;
use function strlen;

use const DIRECTORY_SEPARATOR;

class File
{
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
    public function createTempFolder(
        string $dir = null,
        string $prefix = 'tmp_',
        $mode = 0700,
        int $maxAttempts = 10
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

    public function compressDirectory(SplFileInfo $tempFolder, SplFileInfo $outputFile): void
    {
        $rootPath = realpath($tempFolder);

        $zip = new ZipArchive();
        $zip->open($outputFile, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        /** @var SplFileInfo[] $files */
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($rootPath),
            RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($files as $file) {
            // Skip directories (they would be added automatically)
            if (!$file->isDir()) {
                // Get real and relative path for current file
                $filePath     = $file->getRealPath();
                $relativePath = substr($filePath, strlen($rootPath) + 1);

                // Add current file to archive
                $zip->addFile($filePath, $relativePath);
            }
        }

        $result = $zip->close();

        if (!$result) {
            throw new RuntimeException('Compression error with: ' . $zip->getStatusString());
        }
    }
}
