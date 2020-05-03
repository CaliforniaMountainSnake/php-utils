<?php

namespace Tests\Unit;

use CaliforniaMountainSnake\UtilTraits\ArrayUtils;
use PHPUnit\Framework\TestCase;

class ArrayUtilsTest extends TestCase
{
    use ArrayUtils;

    /**
     * @covers ArrayUtils::array_values_recursive
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testArrayValuesRecursive(): void
    {
        $inputArray = [
            'zero value',
            3 => 'three value',
            'some associative key' => 'some associative value',
            [
                'some associative key' => 'some associative value',
            ],
        ];

        // Don't try to save keys.
        $this->assertEquals([
            0 => 'zero value',
            1 => 'three value',
            2 => 'some associative value',
            3 => 'some associative value',
        ], $this->array_values_recursive($inputArray, false));

        // Try to save keys (but is impossible if the array contains duplicate keys somewhere in nested arrays).
        $this->assertEquals([
            0 => 'zero value',
            3 => 'three value',
            'some associative key' => 'some associative value',
        ], $this->array_values_recursive($inputArray, true));
    }
}
