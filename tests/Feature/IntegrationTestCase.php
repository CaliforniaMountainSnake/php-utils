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
            self::WEBSERVER_HOST . ':' . self::WEBSERVER_PORT,
            '-t',
            \dirname(__FILE__)
        ]);
        self::$webServerProcess->start();
        usleep(100000); //wait for server to get going

        echo "\n#webserver deployed at " . self::WEBSERVER_HOST . ':' . self::WEBSERVER_PORT . "#\n";
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
        return 'http://' . self::WEBSERVER_HOST . ':' . self::WEBSERVER_PORT;
    }

    /**
     * @return string
     */
    public static function getRequestInfoUrl(): string
    {
        return self::getWebserverRootUrl() . '/show_request_info.php';
    }
}
