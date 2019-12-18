<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Stub;

use Monolog\Formatter\FormatterInterface;
use Monolog\Handler\FormattableHandlerInterface;
use Monolog\Handler\HandlerInterface;
use Monolog\Handler\ProcessableHandlerInterface;

class HandlerStub implements HandlerInterface, FormattableHandlerInterface, ProcessableHandlerInterface
{

    public function isHandling(array $record): bool
    {
        // TODO: Implement isHandling() method.
    }

    public function handle(array $record): bool
    {
        // TODO: Implement handle() method.
    }

    public function handleBatch(array $records): void
    {
        // TODO: Implement handleBatch() method.
    }

    public function close(): void
    {
        // TODO: Implement close() method.
    }

    public function setFormatter(FormatterInterface $formatter): HandlerInterface
    {
        return $this;
    }

    public function getFormatter(): FormatterInterface
    {
        // TODO: Implement getFormatter() method.
    }

    public function pushProcessor(callable $callback): HandlerInterface
    {
        return $this;
    }

    public function popProcessor(): callable
    {
        // TODO: Implement popProcessor() method.
    }
}
