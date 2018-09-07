<?php

use PHPUnit\Framework\TestCase;
use DCAT_AP_DONL\DCATProperty;
use DCAT_AP_DONL\DCATDateTime;
use DCAT_AP_DONL\ComplexEntities\Temporal;


class TemporalTest extends TestCase {

    public function testFailsWhenAllPropertiesAreNull(): void
    {
        $temporal = new Temporal(null, null, null);

        $this->assertFalse($temporal->validate()->validated());
    }

    public function testIsValidWithOnlyOneProperty(): void
    {
        $temporal = new Temporal(null, null, new DCATProperty('label', 'MyLabel'));

        $this->assertTrue($temporal->validate()->validated());
    }

    public function testStartMustBeSmallerThanEnd(): void
    {
        $temporal = new Temporal(
            new DCATDateTime('start', '2000-01-01T00:00:00'),
            new DCATDateTime('end', '2001-01-01T00:00:00')
        );

        $this->assertTrue($temporal->validate()->validated());

        $temporal = new Temporal(
            new DCATDateTime('start', '2001-01-01T00:00:00'),
            new DCATDateTime('end', '2000-01-01T00:00:00')
        );

        $this->assertFalse($temporal->validate()->validated());

        $temporal = new Temporal(
            new DCATDateTime('start', '2000-01-01T00:00:00'),
            new DCATDateTime('end', '2000-01-01T00:00:00')
        );

        $this->assertFalse($temporal->validate()->validated());
    }

}
