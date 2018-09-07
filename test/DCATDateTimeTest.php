<?php

use PHPUnit\Framework\TestCase;
use DCAT_AP_DONL\DCATDateTime;


class DCATDateTimeTest extends TestCase {

    public function testFormatIsRetrievable(): void
    {
        $datetime = new DCATDateTime('DateTime', '2000-01-01T00:00:00', 'Y-m-dTH:i:s');

        $this->assertEquals('Y-m-dTH:i:s', $datetime->getFormat());
    }

    public function testFormatFallsBackToDefault(): void
    {
        $datetime = new DCATDateTime('DateTime', '2000-01-01T00:00:00');

        $this->assertEquals('Y-m-d\TH:i:s', $datetime->getFormat());
    }

    public function testValueIsValidAccordingToGivenFormat(): void
    {
        $datetime = new DCATDateTime('DateTime', '2000-01-01T00:00:00');

        $this->assertTrue($datetime->validate()->validated());
    }

    public function testValueFailsValidationWhenItDoesNotMatchTheFormat(): void
    {
        $datetime = new DCATDateTime('DateTime', '2000-01-01');

        $this->assertEquals(
            ['DateTime: value 2000-01-01 is not conform the given format Y-m-d\TH:i:s'],
            $datetime->validate()->getMessages()
        );
    }

}
