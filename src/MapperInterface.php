<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog;

interface MapperInterface
{
    public function map(string $type);
}
