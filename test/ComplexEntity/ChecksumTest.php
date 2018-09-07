<?php

use PHPUnit\Framework\TestCase;
use DCAT_AP_DONL\DCATProperty;
use DCAT_AP_DONL\ComplexEntities\Checksum;


class ChecksumTest extends TestCase {

    public function testDataRetrievalReturnsAKeyValueArray(): void
    {
        $checksum = new Checksum(
            new DCATProperty('hash', 'hashValue'),
            new DCATProperty('algorithm', 'algorithmValue')
        );

        $this->assertEquals(['hash' => 'hashValue', 'algorithm' => 'algorithmValue'], $checksum->getData());
    }

    public function testOnlyReturnsSetProperties(): void
    {
        $checksum = new Checksum(
            null,
            new DCATProperty('algorithm', 'algorithmValue')
        );

        $this->assertEquals(['algorithm' => 'algorithmValue'], $checksum->getData());
    }

    public function testFailsValidationIfOnePropertyIsInvalid(): void
    {
        $checksum = new Checksum(
            new DCATProperty('hash', ''),
            new DCATProperty('algorithm', 'algorithmValue')
        );

        $this->assertFalse($checksum->validate()->validated());
    }

    public function testValidatesWhenAllPropertiesArePresentAndValid(): void
    {
        $checksum = new Checksum(
            new DCATProperty('hash', 'hashValue'),
            new DCATProperty('algorithm', 'algorithmValue')
        );

        $this->assertTrue($checksum->validate()->validated());
    }

}
