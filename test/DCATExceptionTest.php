<?php

use PHPUnit\Framework\TestCase;
use DCAT_AP_DONL\DCATException;


class DCATExceptionTest extends TestCase {

    public function testIsDerivedOfExceptionClass(): void
    {
        $this->assertTrue(new DCATException() instanceof \Exception);
    }

}
