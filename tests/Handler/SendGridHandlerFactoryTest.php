<?php

declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Handler;

use Monolog\Handler\SendGridHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use WShafer\PSR11MonoLog\Handler\SendGridHandlerFactory;

/**
 * @covers \WShafer\PSR11MonoLog\Handler\SendGridHandlerFactory
 */
class SendGridHandlerFactoryTest extends TestCase
{
    public function testInvoke()
    {
        $options = [
            'apiUser' => 'some-user',
            'apiKey' => 'some-key',
            'from' => 'me@me.com',
            'to' => 'someone@here.com',
            'subject' => 'monolog',
            'level' => Logger::DEBUG,
            'bubble' => true,
        ];

        $factory = new SendGridHandlerFactory();
        $handler = $factory($options);

        $this->assertInstanceOf(SendGridHandler::class, $handler);
    }
}
