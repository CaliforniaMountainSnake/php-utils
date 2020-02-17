<?php

namespace CaliforniaMountainSnake\UtilTraits;

use DirectoryIterator;
use Exception;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RuntimeException;

/**
 * Helpful methods to work with files.
 */
trait FileUtils
{
    /**
     * Get the files form given directory, recursively.
     *
     * @param string $_dir               Target directory.
     * @param array  $_ignored_filenames The file basenames that will be ignored.
     *
     * @return array The array with absolute filenames, sorted using natsort().
     */
    protected function getDirectoryFilesRecursive(string $_dir, array $_ignored_filenames = []): array
    {
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($_dir));
        $files = [];
        foreach ($iterator as $file) {
            if (!$file->isFile() || (in_array($file->getFilename(), $_ignored_filenames, false))) {
                continue;
            }
            $files[] = $file->getPathname();
        }

        natsort($files);
        return $files;
    }

    /**
     * Get the files form given directory.
     *
     * @param string $_dir               Target directory.
     * @param array  $_ignored_filenames The file basenames that will be ignored.
     *
     * @return array The array with absolute filenames, sorted using natsort().
     */
    protected function getDirectoryFiles(string $_dir, array $_ignored_filenames = []): array
    {
        $iterator = new DirectoryIterator($_dir);
        $files = [];
        foreach ($iterator as $file) {
            if (!$file->isFile() || (in_array($file->getFilename(), $_ignored_filenames, false))) {
                continue;
            }

            $files[] = $file->getPathname();
        }

        natsort($files);
        return $files;
    }

    /**
     * Delete the given directory recursively.
     *
     * @param string $_dir
     *
     * @see https://stackoverflow.com/a/3349792/10452175
     */
    private function deleteDirectoryRecursively(string $_dir): void
    {
        $it = new RecursiveDirectoryIterator($_dir, RecursiveDirectoryIterator::SKIP_DOTS);
        $files = new RecursiveIteratorIterator($it,
            RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($files as $file) {
            if ($file->isDir()) {
                rmdir($file->getRealPath());
            } else {
                unlink($file->getRealPath());
            }
        }
        rmdir($_dir);
    }

    /**
     * Create a temp directory and run the callback.
     * The directory will be deleted recursively after callback execution.
     *
     * @param callable $_callback
     * @param null     $_dir
     * @param string   $_prefix
     * @param int      $_mode
     * @param int      $_max_attempts
     */
    private function runInTempDir(
        callable $_callback,
        $_dir = null,
        $_prefix = 'tmp_',
        $_mode = 0700,
        $_max_attempts = 1000
    ): void {
        $tempDir = $this->createTempDir($_dir, $_prefix, $_mode, $_max_attempts);
        $_callback ($tempDir);
        $this->deleteDirectoryRecursively($tempDir);
    }


    /**
     * Creates a random unique temporary directory, with specified parameters,
     * that does not already exist (like tempnam(), but for dirs).
     * Created dir will begin with the specified prefix, followed by random
     * numbers.
     *
     * @param string|null $dir         Base directory under which to create temp dir.
     *                                 If null, the default system temp dir (sys_get_temp_dir()) will be
     *                                 used.
     * @param string      $prefix      String with which to prefix created dirs.
     * @param int         $mode        Octal file permission mask for the newly-created dir.
     *                                 Should begin with a 0.
     * @param int         $maxAttempts Maximum attempts before giving up (to prevent
     *                                 endless loops).
     *
     * @return string|bool Full path to newly-created dir, or false on failure.
     * @see https://stackoverflow.com/a/30010928/10452175
     * @see https://php.net/manual/en/function.tempnam.php
     */
    private function createTempDir($dir = null, $prefix = 'tmp_', $mode = 0700, $maxAttempts = 1000)
    {
        /* Use the system temp dir by default. */
        if ($dir === null) {
            $dir = sys_get_temp_dir();
        }

        /* Trim trailing slashes from $dir. */
        $dir = rtrim($dir, DIRECTORY_SEPARATOR);

        /* If we don't have permission to create a directory, fail, otherwise we will
         * be stuck in an endless loop.
         */
        if (!is_dir($dir) || !is_writable($dir)) {
            return false;
        }

        /* Make sure characters in prefix are safe. */
        if (strpbrk($prefix, '\\/:*?"<>|') !== false) {
            return false;
        }

        /* Attempt to create a random directory until it works. Abort if we reach
         * $maxAttempts. Something screwy could be happening with the filesystem
         * and our loop could otherwise become endless.
         */
        $attempts = 0;
        try {
            do {
                $path = sprintf('%s%s%s%s', $dir, DIRECTORY_SEPARATOR, $prefix, random_int(100000, mt_getrandmax()));

            } while (
                !mkdir($path, $mode) && is_dir($path) && $attempts++ < $maxAttempts
            );
        } catch (Exception $e) {
            throw new RuntimeException($e->getMessage(), $e->getCode(), $e);
        }

        return $path;
    }
}
