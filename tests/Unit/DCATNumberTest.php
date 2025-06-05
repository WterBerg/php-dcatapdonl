<?php

/**
 * This file is part of the wterberg/dcat-ap-donl package.
 *
 * This source file is subject to the license that is
 * bundled with this source code in the LICENSE.md file.
 */

namespace Tests\Unit;

use DCAT_AP_DONL\DCATNumber;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class DCATNumberTest extends TestCase
{
    public function testNonNumbersFailValidation(): void
    {
        $number = new DCATNumber('SomeString');

        $this->assertFalse($number->validate()->validated());
    }

    public function testNegativeNumbersAreNotAllowed(): void
    {
        $number = new DCATNumber(-1);

        $this->assertFalse($number->validate()->validated());
    }

    public function testZeroIsNotAllowed(): void
    {
        $number = new DCATNumber(0);

        $this->assertFalse($number->validate()->validated());
    }

    public function testPositiveNumbersAreValid(): void
    {
        $number = new DCATNumber(1);

        $this->assertTrue($number->validate()->validated());
    }
}
