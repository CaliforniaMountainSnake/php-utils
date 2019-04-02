<?php

namespace Tests\Unit;

use CaliforniaMountainSnake\UtilTraits\StringUtils;
use PHPUnit\Framework\TestCase;

class StringUtilsTest extends TestCase
{
    use StringUtils;

    /**
     * @covers StringUtils::getHumanReadableFileSize
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testGetHumanReadableFileSize(): void
    {
        $this->assertEquals('0.00 B', $this->getHumanReadableFileSize(0));
        $this->assertEquals('465 B', $this->getHumanReadableFileSize(465));
        $this->assertEquals('2.3 KB', $this->getHumanReadableFileSize(1024 * 2.3));
        $this->assertEquals('2 MB', $this->getHumanReadableFileSize(1024 * 1024 * 2));
    }

    /**
     * @covers StringUtils::getShortClassname
     * @throws \ReflectionException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testGetShortClassname(): void
    {
        $name = $this->getShortClassname($this);
        $this->assertEquals('StringUtilsTest', $name);
    }
}
