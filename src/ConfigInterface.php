<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog;

interface ConfigInterface
{
    public function getType() : string;
    public function getOptions();
}
