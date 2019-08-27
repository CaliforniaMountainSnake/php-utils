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
        $param1_name = 'param1';
        $param1_value = 'Юникод 1!';
        $response1 = $this->getQuery(self::getRequestInfoUrl(), [
            $param1_name => $param1_value
        ]);
        $info1 = $response1->jsonDecode();

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
        $param1_name = 'param1';
        $param1_value = 'Юникод 1!';
        $response1 = $this->postQuery(self::getRequestInfoUrl(), [
            $param1_name => $param1_value
        ]);
        $info1 = $response1->jsonDecode();

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
        $param1_name = 'param1';
        $param1_value = 'Юникод 1!';
        $response1 = $this->putQuery(self::getRequestInfoUrl(), [
            $param1_name => $param1_value
        ]);
        $info1 = $response1->jsonDecode();

        $this->assertEquals(200, $response1->getCode());
        $this->assertEquals('PUT', $info1['SERVER']['REQUEST_METHOD']);
    }

    /**
     * @covers CurlUtils::deleteQuery
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testDeleteQuery(): void
    {
        $param1_name = 'param1';
        $param1_value = 'Юникод 1!';
        $response1 = $this->deleteQuery(self::getRequestInfoUrl(), [
            $param1_name => $param1_value
        ]);
        $info1 = $response1->jsonDecode();

        $this->assertEquals(200, $response1->getCode());
        $this->assertEquals('DELETE', $info1['SERVER']['REQUEST_METHOD']);
    }

    /**
     * @covers CurlUtils::httpQuery
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testHttpQuery(): void
    {
        $param1_name = 'param1';
        $param1_value = 'Юникод 1!';
        $referer_1 = 'custom referer!';
        $user_agent_1 = 'custom user-agent!';

        $response1 = $this->httpQuery(RequestMethodEnum::POST(), self::getRequestInfoUrl(), [
            $param1_name => $param1_value
        ], [
            \CURLOPT_REFERER => $referer_1,
            \CURLOPT_USERAGENT => $user_agent_1,
        ]);
        $info1 = $response1->jsonDecode();

        $this->assertEquals(200, $response1->getCode());
        $this->assertEquals('POST', $info1['SERVER']['REQUEST_METHOD']);
        $this->assertEquals($param1_value, $info1['POST'][$param1_name]);
        $this->assertEquals($referer_1, $info1['SERVER']['HTTP_REFERER']);
        $this->assertEquals($user_agent_1, $info1['SERVER']['HTTP_USER_AGENT']);
    }

    /**
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testArraysPost(): void
    {
        $arrayName = 'some_array';
        $response1 = $this->postQuery(self::getRequestInfoUrl(), [
            $arrayName => [
                'key_1' => 'value_1',
                'key_2' => 'юникод',
                'key_3' => [
                    'key_31' => 'value_31',
                    'key_32' => 'value_32',
                ],
            ],
        ]);
        $info1 = $response1->jsonDecode();

        $this->assertEquals(200, $response1->getCode());
        $this->assertEquals('POST', $info1['SERVER']['REQUEST_METHOD']);
        $this->assertEquals('value_1', $info1['POST'][$arrayName]['key_1']);
        $this->assertEquals('value_32', $info1['POST'][$arrayName]['key_3']['key_32']);
    }

    /**
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testArraysGet(): void
    {
        $arrayName = 'some_array';
        $response1 = $this->getQuery(self::getRequestInfoUrl(), [
            $arrayName => [
                'key_1' => 'value_1',
                'key_2' => 'юникод',
                'key_3' => [
                    'key_31' => 'value_31',
                    'key_32' => 'value_32',
                ],
            ],
        ]);
        $info1 = $response1->jsonDecode();

        $this->assertEquals(200, $response1->getCode());
        $this->assertEquals('GET', $info1['SERVER']['REQUEST_METHOD']);
        $this->assertEquals('value_1', $info1['GET'][$arrayName]['key_1']);
        $this->assertEquals('value_32', $info1['GET'][$arrayName]['key_3']['key_32']);
    }

    /**
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testFiles(): void
    {
        $arrayName = 'some_array';
        $filenameFull = __FILE__;
        $filenameBase = \pathinfo($filenameFull, \PATHINFO_BASENAME);

        $response1 = $this->postQuery(self::getRequestInfoUrl(), [
            'key_file_1' => new \CURLFile($filenameFull),
            $arrayName => [
                'key_file_2' => new \CURLFile($filenameFull),
                'key_1' => 'value_1',
                'key_2' => 'юникод',
                'key_3' => [
                    'key_31' => 'value_31',
                    'key_32' => 'value_32',
                    'key_file_3' => new \CURLFile($filenameFull),
                ],
            ],
        ]);
        $info1 = $response1->jsonDecode();

        $this->assertEquals(200, $response1->getCode());
        $this->assertEquals('POST', $info1['SERVER']['REQUEST_METHOD']);
        $this->assertEquals('value_1', $info1['POST'][$arrayName]['key_1']);
        $this->assertEquals('value_32', $info1['POST'][$arrayName]['key_3']['key_32']);

        $this->assertEquals($filenameBase, $info1['FILES']['key_file_1']['name']);
        $this->assertEquals($filenameBase, $info1['FILES'][$arrayName]['name']['key_file_2']);
        $this->assertEquals($filenameBase, $info1['FILES'][$arrayName]['name']['key_3']['key_file_3']);
    }
}
