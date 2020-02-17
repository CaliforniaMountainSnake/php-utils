<?php

namespace Tests\Unit;

use CaliforniaMountainSnake\UtilTraits\FileUtils;
use PHPUnit\Framework\TestCase;

class FileUtilsTest extends TestCase
{
    use FileUtils;

    /**
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @covers FileUtils::getDirectoryFilesRecursive
     */
    public function testGetDirectoryFilesRecursive(): void
    {
        $dir = realpath(__DIR__ . '/../files');
        $ignoredFiles = ['some_file.txt'];
        $files = array_values($this->getDirectoryFilesRecursive($dir, $ignoredFiles));

        $filesBasenames = array_map(static function ($value) {
            return basename($value);
        }, $files);

        $this->assertEquals([
            '2_test_file.txt',
            '10_another_test_file.file',
            'sub_dir_test_file.txt',
            'sub_dir_test_file_2.txt',
            'sub_sub_dir_file.txt',
        ], $filesBasenames);
    }

    /**
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @covers FileUtils::getDirectoryFiles
     */
    public function testGetDirectoryFiles(): void
    {
        $dir = realpath(__DIR__ . '/../files');
        $ignoredFiles = ['some_file.txt'];
        $files = array_values($this->getDirectoryFiles($dir, $ignoredFiles));

        $filesBasenames = array_map(static function ($value) {
            return basename($value);
        }, $files);

        $this->assertEquals([
            '2_test_file.txt',
            '10_another_test_file.file',
        ], $filesBasenames);
    }

    /**
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @covers FileUtils::runInTempDir
     * @covers FileUtils::createTempDir
     * @covers FileUtils::deleteDirectoryRecursively
     */
    public function testRunInTempDir(): void
    {
        $tempDirStored = null;
        $tempFileStored = null;
        $this->runInTempDir(function ($tempDir) use (&$tempDirStored, &$tempFileStored) {
            $this->assertFileExists($tempDir);
            $this->assertFileIsReadable($tempDir);
            $this->assertFileIsWritable($tempDir);

            $tempSubDir = $tempDir . '/subDir';
            $tempFile = $tempDir . '/subDir/tempFile.txt';
            $tempFileStored = $tempFile;
            $tempDirStored = $tempDir;

            mkdir($tempSubDir);
            $this->assertFileExists($tempSubDir);

            file_put_contents($tempFile, 'test data');
            $this->assertFileExists($tempFile);
        });

        $this->assertFileNotExists($tempDirStored);
        $this->assertFileNotExists($tempFileStored);
    }
}
