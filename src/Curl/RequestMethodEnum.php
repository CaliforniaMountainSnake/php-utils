<?php

namespace CaliforniaMountainSnake\UtilTraits\Curl;

use MyCLabs\Enum\Enum;

class RequestMethodEnum extends Enum
{
    public const GET = 'GET';
    public const POST = 'POST';
    public const PUT = 'PUT';
    public const DELETE = 'DELETE';
    public const PATCH = 'PATCH';
    public const OPTIONS = 'OPTIONS';

    //--------------------------------------------------------------------------
    // These methods are just for IDE autocomplete and not are mandatory.
    //--------------------------------------------------------------------------
    /**
     * @return static
     */
    public static function GET(): self
    {
        return new static (static::GET);
    }

    /**
     * @return static
     */
    public static function POST(): self
    {
        return new static (static::POST);
    }

    /**
     * @return static
     */
    public static function PUT(): self
    {
        return new static (static::PUT);
    }

    /**
     * @return static
     */
    public static function DELETE(): self
    {
        return new static (static::DELETE);
    }

    /**
     * @return static
     */
    public static function PATCH(): self
    {
        return new static (static::PATCH);
    }

    /**
     * @return static
     */
    public static function OPTIONS(): self
    {
        return new static (static::OPTIONS);
    }
}
