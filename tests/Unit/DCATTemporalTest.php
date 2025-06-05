<?php

/**
 * This file is part of the wterberg/dcat-ap-donl package.
 *
 * This source file is subject to the license that is
 * bundled with this source code in the LICENSE.md file.
 */

namespace Tests\Unit;

use DCAT_AP_DONL\DCATDateTime;
use DCAT_AP_DONL\DCATLiteral;
use DCAT_AP_DONL\DCATTemporal;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
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

    public function testMessageIsGeneratedOnInvalidDateTimeFormats(): void
    {
        $temporal = new DCATTemporal();
        $temporal->setStart(new DCATDateTime('2000-01-01T00:00:00'));
        $temporal->setEnd(new DCATDateTime('test'));

        $validation_result = $temporal->validate();
        $last_message      = array_reverse($validation_result->getMessages())[0];

        $this->assertEquals(
            'failed to convert a temporal property into a DateTime object',
            $last_message
        );
    }
}
