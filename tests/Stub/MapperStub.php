<?php
declare(strict_types=1);

namespace WShafer\PSR11MonoLog\Test\Stub;

use WShafer\PSR11MonoLog\MapperAbstract;

class MapperStub extends MapperAbstract
{
    public function getFactoryClassName(string $type)
    {
        if (class_exists($type)) {
            return $type;
        }

        return null;
    }
}
