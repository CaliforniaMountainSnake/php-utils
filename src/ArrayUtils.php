<?php

namespace CaliforniaMountainSnake\UtilTraits;

trait ArrayUtils
{
    /**
     * Recursive \implode().
     *
     * @param string $_glue
     * @param array $_arr
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
     * (https://stackoverflow.com/questions/4128323/in-array-and-multidimensional-array).
     *
     * @param $_needle
     * @param array $_haystack
     * @param bool $_strict
     *
     * @return bool
     */
    protected function in_array_recursive($_needle, array $_haystack, bool $_strict = false): bool
    {
        foreach ($_haystack as $item) {
            /** @noinspection TypeUnsafeComparisonInspection */
            /** @noinspection NotOptimalIfConditionsInspection */
            if (($_strict ? $item === $_needle : $item == $_needle)
                || (\is_array($item) && $this->in_array_recursive($_needle, $item, $_strict))) {
                return true;
            }
        }

        return false;
    }

}
