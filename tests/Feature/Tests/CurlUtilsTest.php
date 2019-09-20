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
        $get_params = [
            'get_param_1' => 'Юникод 1!',
            'get_param_2' => 'Юникод 2!',
        ];

        $response = $this->getQuery(self::getRequestInfoUrl(), $get_params);
        $responseArr = $response->jsonDecode();

        $this->assertEquals($get_params, $responseArr['GET']);
        $this->assertEquals(200, $response->getCode());
        $this->assertEquals('GET', $responseArr['SERVER']['REQUEST_METHOD']);
    }

    /**
     * @covers CurlUtils::postQuery
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testPostQuery(): void
    {
        $get_params = [
            'get_param_1' => 'Юникод 1!',
            'get_param_2' => 'Юникод 2!',
        ];
        $post_params = [
            'post_param_1' => 'Юникод 1!',
            'post_param_2' => 'Юникод 2!',
        ];

        $response = $this->postQuery(self::getRequestInfoUrl($get_params), $post_params);
        $responseArr = $response->jsonDecode();

        $this->assertEquals($get_params, $responseArr['GET']);
        $this->assertEquals($post_params, $responseArr['POST']);
        $this->assertEquals(200, $response->getCode());
        $this->assertEquals('POST', $responseArr['SERVER']['REQUEST_METHOD']);
    }

    /**
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testPostJsonQuery(): void
    {
        $get_params = [
            'get_param_1' => 'Юникод 1!',
            'get_param_2' => 'Юникод 2!',
        ];
        $post_params = [
            'post_param_1' => 'Юникод 1!',
            'post_param_2' => 'Юникод 2!',
        ];

        $response = $this->postJson(self::getRequestInfoUrl($get_params), $post_params);
        $responseArr = $response->jsonDecode();

        $this->assertEquals($get_params, $responseArr['GET']);
        $this->assertEquals($post_params, $responseArr['INPUT_DATA_JSON_DECODED']);
        $this->assertEquals(200, $response->getCode());
        $this->assertEquals('POST', $responseArr['SERVER']['REQUEST_METHOD']);
    }

    /**
     * @covers CurlUtils::putQuery
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testPutQuery(): void
    {
        $get_params = [
            'get_param_1' => 'Юникод 1!',
            'get_param_2' => 'Юникод 2!',
        ];
        $put_params = [
            'put_param_1' => 'Юникод 1!',
            'put_param_2' => 'Юникод 2!',
        ];

        $response = $this->putQuery(self::getRequestInfoUrl($get_params), $put_params);
        $responseArr = $response->jsonDecode();

        $this->assertEquals($get_params, $responseArr['GET']);
        $this->assertEquals($put_params, $responseArr['PUT']);
        $this->assertEquals(200, $response->getCode());
        $this->assertEquals('PUT', $responseArr['SERVER']['REQUEST_METHOD']);
    }

    /**
     * @covers CurlUtils::deleteQuery
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testDeleteQuery(): void
    {
        $get_params = [
            'get_param_1' => 'Юникод 1!',
            'get_param_2' => 'Юникод 2!',
        ];
        $delete_params = [
            'put_param_1' => 'Юникод 1!',
            'put_param_2' => 'Юникод 2!',
        ];

        $response = $this->deleteQuery(self::getRequestInfoUrl($get_params), $delete_params);
        $responseArr = $response->jsonDecode();

        $this->assertEquals($get_params, $responseArr['GET']);
        $this->assertEquals($delete_params, $responseArr['DELETE']);
        $this->assertEquals(200, $response->getCode());
        $this->assertEquals('DELETE', $responseArr['SERVER']['REQUEST_METHOD']);
    }

    /**
     * @covers CurlUtils::patchQuery
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testPatchQuery(): void
    {
        $get_params = [
            'get_param_1' => 'Юникод 1!',
            'get_param_2' => 'Юникод 2!',
        ];
        $patch_params = [
            'put_param_1' => 'Юникод 1!',
            'put_param_2' => 'Юникод 2!',
        ];

        $response = $this->patchQuery(self::getRequestInfoUrl($get_params), $patch_params);
        $responseArr = $response->jsonDecode();

        $this->assertEquals($get_params, $responseArr['GET']);
        $this->assertEquals($patch_params, $responseArr['PATCH']);
        $this->assertEquals(200, $response->getCode());
        $this->assertEquals('PATCH', $responseArr['SERVER']['REQUEST_METHOD']);
    }

    /**
     * @covers CurlUtils::optionsQuery
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testOptionsQuery(): void
    {
        $get_params = [
            'get_param_1' => 'Юникод 1!',
            'get_param_2' => 'Юникод 2!',
        ];
        $options_params = [
            'put_param_1' => 'Юникод 1!',
            'put_param_2' => 'Юникод 2!',
        ];

        $response = $this->optionsQuery(self::getRequestInfoUrl($get_params), $options_params);
        $responseArr = $response->jsonDecode();

        $this->assertEquals($get_params, $responseArr['GET']);
        $this->assertEquals($options_params, $responseArr['OPTIONS']);
        $this->assertEquals(200, $response->getCode());
        $this->assertEquals('OPTIONS', $responseArr['SERVER']['REQUEST_METHOD']);
    }

    /**
     * @covers CurlUtils::httpQuery
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testHeaders(): void
    {
        $referer = 'custom referer!';
        $user_agent = 'custom user-agent!';
        $get_params = [
            'get_param_1' => 'Юникод 1!',
            'get_param_2' => 'Юникод 2!',
        ];
        $post_params = [
            'post_param_1' => 'Юникод 1!',
            'post_param_2' => 'Юникод 2!',
        ];

        $response = $this->httpQuery(RequestMethodEnum::POST(), self::getRequestInfoUrl($get_params),
            $post_params, [
                \CURLOPT_REFERER => $referer,
                \CURLOPT_USERAGENT => $user_agent,
            ]);
        $responseArr = $response->jsonDecode();

        $this->assertEquals($referer, $responseArr['SERVER']['HTTP_REFERER']);
        $this->assertEquals($user_agent, $responseArr['SERVER']['HTTP_USER_AGENT']);
        $this->assertEquals($get_params, $responseArr['GET']);
        $this->assertEquals($post_params, $responseArr['POST']);
        $this->assertEquals(200, $response->getCode());
        $this->assertEquals('POST', $responseArr['SERVER']['REQUEST_METHOD']);
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
