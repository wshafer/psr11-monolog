<?php

namespace WShafer\PSR11MonoLog;

interface ServiceManagerInterface
{
    public function get(string $type, array $options);
    public function has(string $type);
}