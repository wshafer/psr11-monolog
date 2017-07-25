<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Stub;

use Monolog\Formatter\FormatterInterface;
use Monolog\Handler\HandlerInterface;

class HandlerStub implements HandlerInterface
{
    public function isHandling(array $record)
    {
        // TODO: Implement isHandling() method.
    }

    public function handle(array $record)
    {
        // TODO: Implement handle() method.
    }

    public function handleBatch(array $records)
    {
        // TODO: Implement handleBatch() method.
    }

    public function pushProcessor($callback)
    {
        // TODO: Implement pushProcessor() method.
    }

    public function popProcessor()
    {
        // TODO: Implement popProcessor() method.
    }

    public function setFormatter(FormatterInterface $formatter)
    {
        // TODO: Implement setFormatter() method.
    }

    public function getFormatter()
    {
        // TODO: Implement getFormatter() method.
    }
}
