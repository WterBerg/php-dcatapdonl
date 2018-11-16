<?php

use DCAT_AP_DONL\DCATDateTime;
use DCAT_AP_DONL\DCATLiteral;
use DCAT_AP_DONL\DCATTemporal;
use PHPUnit\Framework\TestCase;

class DCATTemporalTest extends TestCase
{
    public function testFailsWhenAllPropertiesAreNull(): void
    {
        $temporal = new DCATTemporal();

        $this->assertEquals(
            ['at least one property must be provided'],
            $temporal->validate()->getMessages()
        );
    }

    public function testIsValidWithOnlyOneProperty(): void
    {
        $temporal = new DCATTemporal();
        $temporal->setLabel(new DCATLiteral('MyLabel'));

        $this->assertTrue($temporal->validate()->validated());
    }

    public function testStartMustBeSmallerThanEnd(): void
    {
        $temporal = new DCATTemporal();
        $temporal->setStart(new DCATDateTime('2000-01-01T00:00:00'));
        $temporal->setEnd(new DCATDateTime('2001-01-01T00:00:00'));

        $this->assertTrue($temporal->validate()->validated());

        $temporal = new DCATTemporal();
        $temporal->setStart(new DCATDateTime('2001-01-01T00:00:00'));
        $temporal->setEnd(new DCATDateTime('2000-01-01T00:00:00'));

        $this->assertFalse($temporal->validate()->validated());

        $temporal->setStart(new DCATDateTime('2001-01-01T00:00:00'));
        $temporal->setEnd(new DCATDateTime('2001-01-01T00:00:00'));

        $this->assertFalse($temporal->validate()->validated());
    }

    public function testGettersArePresentAndFunctional(): void
    {
        $temporal = new DCATTemporal();
        $temporal->setStart(new DCATDateTime('2000-01-01T00:00:00'));
        $temporal->setEnd(new DCATDateTime('2001-01-01T00:00:00'));
        $temporal->setLabel(new DCATLiteral('MyLabel'));

        $this->assertEquals('2000-01-01T00:00:00', $temporal->getStart()->getData());
        $this->assertEquals('2001-01-01T00:00:00', $temporal->getEnd()->getData());
        $this->assertEquals('MyLabel', $temporal->getLabel()->getData());
    }
}
