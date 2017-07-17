<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Handler;

use Monolog\Handler\CouchDBHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use WShafer\PSR11MonoLog\Handler\CouchDBHandlerFactory;

/**
 * @covers \WShafer\PSR11MonoLog\Handler\CouchDBHandlerFactory
 */
class CouchDBHandlerFactoryTest extends TestCase
{
    public function testInvoke()
    {
        $options = [
            'host'     => 'localhost',
            'port'     => 5984,
            'dbname'   => 'db',
            'username' => 'someuser',
            'password' => 'somepass',
            'level'    => Logger::INFO,
            'bubble'   => false
        ];

        $factory = new CouchDBHandlerFactory();
        $handler = $factory($options);

        $this->assertInstanceOf(CouchDBHandler::class, $handler);
    }
}
