<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Handler;

use Monolog\Handler\CubeHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use WShafer\PSR11MonoLog\Handler\CubeHandlerFactory;

/**
 * @covers \WShafer\PSR11MonoLog\Handler\FleepHookHandlerFactory
 */
class CubeHandlerFactoryTest extends TestCase
{
    public function testInvoke()
    {
        $options = [
            'url'    => 'http://test.com:80',
            'level'  => Logger::INFO,
            'bubble' => false
        ];

        $factory = new CubeHandlerFactory();
        $handler = $factory($options);

        $this->assertInstanceOf(CubeHandler::class, $handler);
    }
}
