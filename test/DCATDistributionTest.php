<?php

use PHPUnit\Framework\TestCase;
use DCAT_AP_DONL\DCATDistribution;


class DCATDistributionTest extends TestCase {

    public function testEmptyDistributionsDoNotValidate(): void
    {
        $distribution = new DCATDistribution();

        $this->assertFalse($distribution->validate()->validated());
    }

}
