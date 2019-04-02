<?php

namespace CaliforniaMountainSnake\UtilTraits\Curl;

trait CurlHttpMethods
{
    abstract protected function httpQuery(
        RequestMethodEnum $_method,
        string $_url,
        array $_params = [],
        array $_extra_options = []
    ): HttpResponse;
    
    /**
     * Execute GET query.
     * @param string $_url
     * @param array $_params
     * @param array $_extra_options
     * @return HttpResponse
     */
    protected function getQuery(string $_url, array $_params = [], array $_extra_options = []): HttpResponse
    {
        return $this->httpQuery(RequestMethodEnum::GET(), $_url, $_params, $_extra_options);
    }

    /**
     * Execute POST query.
     * @param string $_url
     * @param array $_params
     * @param array $_extra_options
     * @return HttpResponse
     */
    protected function postQuery(string $_url, array $_params = [], array $_extra_options = []): HttpResponse
    {
        return $this->httpQuery(RequestMethodEnum::POST(), $_url, $_params, $_extra_options);
    }

    /**
     * Execute PUT query.
     * @param string $_url
     * @param array $_params
     * @param array $_extra_options
     * @return HttpResponse
     */
    protected function putQuery(string $_url, array $_params = [], array $_extra_options = []): HttpResponse
    {
        return $this->httpQuery(RequestMethodEnum::PUT(), $_url, $_params, $_extra_options);
    }

    /**
     * Execute DELETE query.
     * @param string $_url
     * @param array $_params
     * @param array $_extra_options
     * @return HttpResponse
     */
    protected function deleteQuery(string $_url, array $_params = [], array $_extra_options = []): HttpResponse
    {
        return $this->httpQuery(RequestMethodEnum::DELETE(), $_url, $_params, $_extra_options);
    }
}
