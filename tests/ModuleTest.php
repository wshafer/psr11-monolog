<?php

namespace WShafer\PSR11MonoLog\Test;

use PHPUnit\Framework\TestCase;
use WShafer\PSR11MonoLog\Module;

class ModuleTest extends TestCase
{
    public function testGetConfig()
    {
        $module = new Module();

        $result = $module->getConfig();

        $this->assertTrue(is_array($result));
    }
}
