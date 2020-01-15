<?php

namespace CaliforniaMountainSnake\UtilTraits\UtilsClasses;

use CaliforniaMountainSnake\UtilTraits\ArrayUtils;
use CaliforniaMountainSnake\UtilTraits\ProcessUtils;
use CaliforniaMountainSnake\UtilTraits\StringUtils;

/**
 * Sometimes you just need to have an object that can do all needed work without creating the own class.
 */
class Utils
{
    use ArrayUtils;
    use ProcessUtils;
    use StringUtils;
}
