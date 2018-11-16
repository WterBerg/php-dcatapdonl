<?php

use DCAT_AP_DONL\DCATDistribution;
use PHPUnit\Framework\TestCase;

class DCATDistributionTest extends TestCase
{
    public function testEmptyDistributionsDoNotValidate(): void
    {
        $distribution = new DCATDistribution();

        $this->assertFalse($distribution->validate()->validated());
    }
}
