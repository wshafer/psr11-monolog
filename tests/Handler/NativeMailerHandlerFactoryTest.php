<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Handler;

use Monolog\Handler\NativeMailerHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use WShafer\PSR11MonoLog\Handler\NativeMailerHandlerFactory;

class NativeMailerHandlerFactoryTest extends TestCase
{
    public function testInvoke()
    {
        $options = [
            'to' => ['email1@test.com', 'email2@test.com'],
            'subject' => 'Error Log',
            'from' => 'sender@test.com',
            'level' => Logger::DEBUG,
            'bubble' => true,
            'maxColumnWidth' => 80,
        ];

        $factory = new NativeMailerHandlerFactory();
        $handler = $factory($options);

        $this->assertInstanceOf(NativeMailerHandler::class, $handler);
    }

    public function testInvokeStringTo()
    {
        $options = [
            'to' => 'email1@test.com',
            'subject' => 'Error Log',
            'from' => 'sender@test.com',
            'level' => Logger::DEBUG,
            'bubble' => true,
            'maxColumnWidth' => 80,
        ];

        $factory = new NativeMailerHandlerFactory();
        $handler = $factory($options);

        $this->assertInstanceOf(NativeMailerHandler::class, $handler);
    }
}
