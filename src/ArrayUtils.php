<?php

namespace CaliforniaMountainSnake\UtilTraits;

trait ArrayUtils
{
    /**
     * Change values and keys in the given array recursively keeping the array order.
     *
     * @param array    $_array    The original array.
     * @param callable $_callback The callback function takes 2 parameters (key, value)
     *                            and returns an array [newKey, newValue] or null if nothing has been changed.
     *
     * @return void
     */
    protected function modify_array_recursive(array &$_array, callable $_callback): void
    {
        $keys = \array_keys($_array);
        foreach ($keys as $keyIndex => $key) {
            $value = &$_array[$key];
            if (\is_array($value)) {
                $this->modify_array_recursive($value, $_callback);
                continue;
            }

            $newKey = $key;
            $newValue = $value;
            $newPair = $_callback ($key, $value);
            if ($newPair !== null) {
                [$newKey, $newValue] = $newPair;
            }

            $keys[$keyIndex] = $newKey;
            $_array[$key] = $newValue;
        }

        $_array = \array_combine($keys, $_array);
    }

    /**
     * Get all keys of the multidimensional array.
     *
     * @param array $_arr
     *
     * @return array
     */
    public function array_keys_recursive(array &$_arr): array
    {
        $result = [];
        \array_walk_recursive($_arr, static function (&$value, &$key) use (&$result) {
            $result[$key] = $key;
        });

        return $result;
    }

    /**
     * Get all values of the multidimensional array.
     *
     * @param array $_arr
     *
     * @return array
     */
    public function array_values_recursive(array &$_arr): array
    {
        $result = [];
        \array_walk_recursive($_arr, static function (&$value, &$key) use (&$result) {
            $result[$key] = $value;
        });

        return $result;
    }

    /**
     * Recursive \implode().
     *
     * @param string $_glue
     * @param array  $_arr
     *
     * @return string
     */
    protected function implode_recursive(string $_glue, array $_arr): string
    {
        $result = '';

        foreach ($_arr as $key => $value) {
            if (\is_array($value)) {
                $result .= $key . $_glue . $this->implode_recursive($_glue, $value);
            } else {
                $result .= $key . $_glue . $value;
            }
        }

        return $result;
    }

    /**
     * Recursive \in_array().
     *
     * @see https://stackoverflow.com/questions/4128323/in-array-and-multidimensional-array
     *
     * @param       $_needle
     * @param array $_haystack
     * @param bool  $_strict
     *
     * @return bool
     */
    protected function in_array_recursive($_needle, array $_haystack, bool $_strict = false): bool
    {
        foreach ($_haystack as $item) {
            /** @noinspection TypeUnsafeComparisonInspection */
            /** @noinspection NotOptimalIfConditionsInspection */
            if (($_strict ? $item === $_needle : $item == $_needle)
                || (\is_array($item) && $this->in_array_recursive($_needle, $item, $_strict))
            ) {
                return true;
            }
        }

        return false;
    }

}
