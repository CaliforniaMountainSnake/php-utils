<?php

namespace Tests\Feature\Tests;

use CaliforniaMountainSnake\UtilTraits\Curl\CurlUtils;
use CaliforniaMountainSnake\UtilTraits\Curl\RequestMethodEnum;
use Tests\Feature\IntegrationTestCase;

class CurlUtilsTest extends IntegrationTestCase
{
    use CurlUtils;

    /**
     * @covers CurlUtils::getQuery
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testGetQuery(): void
    {
        $param1_name  = 'param1';
        $param1_value = 'Юникод 1!';
        $response1    = $this->getQuery(self::getRequestInfoUrl(), [
            $param1_name => $param1_value
        ]);
        $info1        = $response1->jsonDecode();

        $this->assertEquals(200, $response1->getCode());
        $this->assertEquals('GET', $info1['SERVER']['REQUEST_METHOD']);
        $this->assertEquals($param1_value, $info1['GET'][$param1_name]);
    }

    /**
     * @covers CurlUtils::postQuery
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testPostQuery(): void
    {
        $param1_name  = 'param1';
        $param1_value = 'Юникод 1!';
        $response1    = $this->postQuery(self::getRequestInfoUrl(), [
            $param1_name => $param1_value
        ]);
        $info1        = $response1->jsonDecode();

        $this->assertEquals(200, $response1->getCode());
        $this->assertEquals('POST', $info1['SERVER']['REQUEST_METHOD']);
        $this->assertEquals($param1_value, $info1['POST'][$param1_name]);
    }

    /**
     * @covers CurlUtils::putQuery
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testPutQuery(): void
    {
        $param1_name  = 'param1';
        $param1_value = 'Юникод 1!';
        $response1    = $this->putQuery(self::getRequestInfoUrl(), [
            $param1_name => $param1_value
        ]);
        $info1        = $response1->jsonDecode();

        $this->assertEquals(200, $response1->getCode());
        $this->assertEquals('PUT', $info1['SERVER']['REQUEST_METHOD']);
    }

    /**
     * @covers CurlUtils::deleteQuery
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testDeleteQuery(): void
    {
        $param1_name  = 'param1';
        $param1_value = 'Юникод 1!';
        $response1    = $this->deleteQuery(self::getRequestInfoUrl(), [
            $param1_name => $param1_value
        ]);
        $info1        = $response1->jsonDecode();

        $this->assertEquals(200, $response1->getCode());
        $this->assertEquals('DELETE', $info1['SERVER']['REQUEST_METHOD']);
    }

    /**
     * @covers CurlUtils::httpQuery
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testHttpQuery(): void
    {
        $param1_name  = 'param1';
        $param1_value = 'Юникод 1!';
        $referer_1    = 'custom referer!';
        $user_agent_1 = 'custom user-agent!';

        $response1 = $this->httpQuery(RequestMethodEnum::POST(), self::getRequestInfoUrl(), [
            $param1_name => $param1_value
        ], [
            \CURLOPT_REFERER => $referer_1,
            \CURLOPT_USERAGENT => $user_agent_1,
        ]);
        $info1     = $response1->jsonDecode();

        $this->assertEquals(200, $response1->getCode());
        $this->assertEquals('POST', $info1['SERVER']['REQUEST_METHOD']);
        $this->assertEquals($param1_value, $info1['POST'][$param1_name]);
        $this->assertEquals($referer_1, $info1['SERVER']['HTTP_REFERER']);
        $this->assertEquals($user_agent_1, $info1['SERVER']['HTTP_USER_AGENT']);
    }
}
