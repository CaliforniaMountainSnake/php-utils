<?php

namespace Tests\Feature;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Process\Process;

/**
 * IntegrationTest, designed for testing http queries.
 * Based on https://medium.com/@peter.lafferty/start-phps-built-in-web-server-from-phpunit-9571f38c5045.
 */
class IntegrationTestCase extends TestCase
{
    public const WEBSERVER_HOST = 'localhost';
    public const WEBSERVER_PORT = 18080;
    public const WEBSERVER_WAIT_TIME_MICROSECONDS = 100000;

    /**
     * @var Process
     */
    private static $webServerProcess;

    /**
     * @throws \Symfony\Component\Process\Exception\LogicException
     */
    public static function setUpBeforeClass()
    {
        self::$webServerProcess = new Process([
            'php',
            '-S',
            static::WEBSERVER_HOST . ':' . static::WEBSERVER_PORT,
            '-t',
            __DIR__
        ]);
        self::$webServerProcess->start();
        usleep(static::WEBSERVER_WAIT_TIME_MICROSECONDS); //wait for server to get going

        echo "\n#webserver deployed at " . static::WEBSERVER_HOST . ':' . static::WEBSERVER_PORT . "#\n";
    }

    /**
     * @throws \Symfony\Component\Process\Exception\LogicException
     */
    public static function tearDownAfterClass()
    {
        self::$webServerProcess->stop();
        echo "\n#webserver turned off#\n";
    }

    /**
     * @return string
     */
    public static function getWebserverRootUrl(): string
    {
        return 'http://' . static::WEBSERVER_HOST . ':' . static::WEBSERVER_PORT;
    }

    /**
     * @return string
     */
    public static function getRequestInfoUrl(): string
    {
        return static::getWebserverRootUrl() . '/show_request_info.php';
    }
}
