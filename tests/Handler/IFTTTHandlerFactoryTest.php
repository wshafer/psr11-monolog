<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Handler;

use Monolog\Handler\IFTTTHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use WShafer\PSR11MonoLog\Handler\IFTTTHandlerFactory;

/**
 * @covers \WShafer\PSR11MonoLog\Handler\IFTTTHandlerFactory
 */
class IFTTTHandlerFactoryTest extends TestCase
{
    public function testInvoke()
    {
        $options = [
            'eventName' => 'event',
            'secretKey' => 'my-secret',
            'level'     => Logger::INFO,
            'bubble'    => false
        ];

        $factory = new IFTTTHandlerFactory();
        $handler = $factory($options);

        $this->assertInstanceOf(IFTTTHandler::class, $handler);
    }
}
