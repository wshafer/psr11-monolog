<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Handler;

use Monolog\Handler\SlackHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use WShafer\PSR11MonoLog\Handler\SlackHandlerFactory;

/**
 * @covers \WShafer\PSR11MonoLog\Handler\SlackHandlerFactory
 */
class SlackHandlerFactoryTest extends TestCase
{
    public function testInvoke()
    {
        $options = [
            'token' => 'webhook',
            'channel' => 'channel',
            'userName' => 'Monolog',
            'useAttachment' => false,
            'iconEmoji' => null,
            'level' => Logger::INFO,
            'bubble' => false,
            'useShortAttachment' => true,
            'includeContextAndExtra' => true,
            'excludeFields' => [],
        ];

        $factory = new SlackHandlerFactory();
        $handler = $factory($options);

        $this->assertInstanceOf(SlackHandler::class, $handler);
    }
}
