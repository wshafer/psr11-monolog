<?php

declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Stub;

use Monolog\Formatter\ChromePHPFormatter;
use Monolog\Formatter\FormatterInterface;
use Monolog\Handler\FormattableHandlerInterface;
use Monolog\Handler\HandlerInterface;
use Monolog\Handler\ProcessableHandlerInterface;

class HandlerStub implements HandlerInterface, FormattableHandlerInterface, ProcessableHandlerInterface
{

    public function isHandling(array $record): bool
    {
        return true;
    }

    public function handle(array $record): bool
    {
        return true;
    }

    public function handleBatch(array $records): void
    {
        return;
    }

    public function close(): void
    {
        return;
    }

    public function setFormatter(FormatterInterface $formatter): HandlerInterface
    {
        return $this;
    }

    public function getFormatter(): FormatterInterface
    {
        return new ChromePHPFormatter();
    }

    public function pushProcessor(callable $callback): HandlerInterface
    {
        return $this;
    }

    public function popProcessor(): callable
    {
        return function () {
        };
    }
}
