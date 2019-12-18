<?php

declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Exception;

use Psr\Container\NotFoundExceptionInterface;
use OutOfBoundsException;

class UnknownServiceException extends OutOfBoundsException implements NotFoundExceptionInterface
{
}
