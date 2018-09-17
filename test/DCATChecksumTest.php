<?php

use PHPUnit\Framework\TestCase;
use DCAT_AP_DONL\DCATProperty;
use DCAT_AP_DONL\DCATChecksum;


class DCATChecksumTest extends TestCase {

    public function testDataRetrievalReturnsAKeyValueArray(): void
    {
        $checksum = new DCATChecksum();
        $checksum->setHash(new DCATProperty('hash', 'hashValue'));
        $checksum->setAlgorithm(new DCATProperty('algorithm', 'algorithmValue'));

        $this->assertEquals(['hash' => 'hashValue', 'algorithm' => 'algorithmValue'], $checksum->getData());
    }

    public function testOnlyReturnsSetProperties(): void
    {
        $checksum = new DCATChecksum();
        $checksum->setAlgorithm(new DCATProperty('algorithm', 'algorithmValue'));

        $this->assertEquals(['algorithm' => 'algorithmValue'], $checksum->getData());
    }

    public function testFailsValidationIfOnePropertyIsInvalid(): void
    {
        $checksum = new DCATChecksum();
        $checksum->setHash(new DCATProperty('hash', ''));
        $checksum->setAlgorithm(new DCATProperty('algorithm', 'algorithmValue'));

        $this->assertFalse($checksum->validate()->validated());
    }

    public function testValidatesWhenAllPropertiesArePresentAndValid(): void
    {
        $checksum = new DCATChecksum();
        $checksum->setHash(new DCATProperty('hash', 'hashValue'));
        $checksum->setAlgorithm(new DCATProperty('algorithm', 'algorithmValue'));

        $this->assertTrue($checksum->validate()->validated());
    }

    public function testSettersAndGettersWork(): void
    {
        $checksum = new DCATChecksum();
        $checksum->setHash(new DCATProperty('hash', 'hashValue'));
        $checksum->setAlgorithm(new DCATProperty('algorithm', 'algorithmValue'));

        $this->assertEquals('hashValue', $checksum->getHash()->getData());
        $this->assertEquals('algorithmValue', $checksum->getAlgorithm()->getData());
    }

}
