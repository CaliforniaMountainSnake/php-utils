<?php

namespace CaliforniaMountainSnake\UtilTraits\Curl;

class HttpResponse
{
    /**
     * @var string
     */
    protected $content;

    /**
     * @var int
     */
    protected $code;

    /**
     * HttpResponse constructor.
     * @param string $_content
     * @param int $_code
     */
    public function __construct(string $_content, int $_code)
    {
        $this->content = $_content;
        $this->code    = $_code;
    }

    public function __debugInfo()
    {
        return [
            'code' => $this->code,
            'content' => $this->content,
            'json_decoded_content' => \var_export($this->jsonDecode(), true),
        ];
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    public function jsonDecode(bool $_assoc = true, int $_depth = 512, int $_options = 0): ?array
    {
        $array = \json_decode($this->content, $_assoc, $_depth, $_options);
        if (\json_last_error() === \JSON_ERROR_NONE) {
            return $array;
        }

        return null;
    }
}
