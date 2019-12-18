<?php

declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Handler;

use Monolog\Handler\SlackWebhookHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use WShafer\PSR11MonoLog\Handler\SlackWebhookHandlerFactory;

/**
 * @covers \WShafer\PSR11MonoLog\Handler\SlackWebhookHandlerFactory
 */
class SlackWebhookHandlerFactoryTest extends TestCase
{
    public function testInvoke()
    {
        $options = [
            'webhookUrl' => 'webhook',
            'channel' => 'channel',
            'userName' => 'Monolog',
            'useAttachment' => false,
            'iconEmoji' => null,
            'useShortAttachment' => true,
            'includeContextAndExtra' => true,
            'level' => Logger::INFO,
            'bubble' => false,
            'excludeFields' => [],
        ];

        $factory = new SlackWebhookHandlerFactory();
        $handler = $factory($options);

        $this->assertInstanceOf(SlackWebhookHandler::class, $handler);
    }
}
