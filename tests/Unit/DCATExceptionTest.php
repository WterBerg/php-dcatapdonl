<?php

namespace Tests\Unit;

use DCAT_AP_DONL\DCATException;
use PHPUnit\Framework\TestCase;

class DCATExceptionTest extends TestCase
{
    public function testIsDerivedOfExceptionClass(): void
    {
        $this->assertTrue(new DCATException() instanceof \Exception);
    }
}
