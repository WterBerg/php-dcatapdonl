<?php

namespace Tests\Unit;

use DCAT_AP_DONL\DCATNumber;
use PHPUnit\Framework\TestCase;

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
