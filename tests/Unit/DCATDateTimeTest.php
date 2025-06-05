<?php

/**
 * This file is part of the wterberg/dcat-ap-donl package.
 *
 * This source file is subject to the license that is
 * bundled with this source code in the LICENSE.md file.
 */

namespace Tests\Unit;

use DCAT_AP_DONL\DCATDateTime;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class DCATDateTimeTest extends TestCase
{
    public function testFormatIsRetrievable(): void
    {
        $datetime = new DCATDateTime('2000-01-01T00:00:00', 'Y-m-dTH:i:s');

        $this->assertEquals('Y-m-dTH:i:s', $datetime->getFormat());
    }

    public function testFormatFallsBackToDefault(): void
    {
        $datetime = new DCATDateTime('2000-01-01T00:00:00');

        $this->assertEquals('Y-m-d\TH:i:s', $datetime->getFormat());
    }

    public function testValueIsValidAccordingToGivenFormat(): void
    {
        $datetime = new DCATDateTime('2000-01-01T00:00:00');

        $this->assertTrue($datetime->validate()->validated());
    }

    public function testValueFailsValidationWhenItDoesNotMatchTheFormat(): void
    {
        $datetime = new DCATDateTime('2000-01-01');

        $this->assertEquals(
            ['value 2000-01-01 is not conform the given format Y-m-d\TH:i:s'],
            $datetime->validate()->getMessages()
        );
    }
}
