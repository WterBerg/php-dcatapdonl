<?php

use PHPUnit\Framework\TestCase;
use DCAT_AP_DONL\DCATNumber;


class DCATNumberTest extends TestCase {

    public function testNonNumbersFailValidation(): void
    {
        $number = new DCATNumber('Number', 'SomeString');

        $this->assertFalse($number->validate()->validated());
    }

    public function testNegativeNumbersAreNotAllowed(): void
    {
        $number = new DCATNumber('Number', -1);

        $this->assertFalse($number->validate()->validated());
    }

    public function testZeroIsNotAllowed(): void
    {
        $number = new DCATNumber('Number', 0);

        $this->assertFalse($number->validate()->validated());
    }

    public function testPositiveNumbersAreValid(): void
    {
        $number = new DCATNumber('Number', 1);

        $this->assertTrue($number->validate()->validated());
    }

}
