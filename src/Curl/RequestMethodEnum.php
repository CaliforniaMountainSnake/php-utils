<?php

namespace CaliforniaMountainSnake\UtilTraits\Curl;

use MyCLabs\Enum\Enum;

class RequestMethodEnum extends Enum
{
    public const GET    = 'GET';
    public const POST   = 'POST';
    public const PUT    = 'PUT';
    public const DELETE = 'DELETE';

    //--------------------------------------------------------------------------
    // These methods are just for IDE autocomplete and not are mandatory.
    //--------------------------------------------------------------------------
    public static function GET(): self
    {
        return new self (self::GET);
    }

    public static function POST(): self
    {
        return new self (self::POST);
    }

    public static function PUT(): self
    {
        return new self (self::PUT);
    }

    public static function DELETE(): self
    {
        return new self (self::DELETE);
    }
}
