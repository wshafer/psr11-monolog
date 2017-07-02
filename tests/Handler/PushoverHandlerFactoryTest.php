<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Handler;

use Monolog\Handler\PushoverHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use WShafer\PSR11MonoLog\Handler\PushoverHandlerFactory;

class PushoverHandlerFactoryTest extends TestCase
{
    public function testInvoke()
    {
        $options = [
            'token' => 'sometokenhere',
            'users' => ['email1@test.com', 'email2@test.com'],
            'title' => 'Error Log',
            'level' => Logger::INFO,
            'bubble' => false,
            'useSSL' => false,
            'highPriorityLevel' => Logger::WARNING,
            'emergencyLevel' => Logger::ERROR,
            'retry' => '22',
            'expire' => '300',
        ];

        $factory = new PushoverHandlerFactory();
        $handler = $factory($options);

        $this->assertInstanceOf(PushoverHandler::class, $handler);
    }
}
