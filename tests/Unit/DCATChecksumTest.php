<?php

namespace Tests\Unit;

use DCAT_AP_DONL\DCATChecksum;
use DCAT_AP_DONL\DCATLiteral;
use PHPUnit\Framework\TestCase;

class DCATChecksumTest extends TestCase
{
    public function testDataRetrievalReturnsAKeyValueArray(): void
    {
        $checksum = new DCATChecksum();
        $checksum->setHash(new DCATLiteral('hashValue'));
        $checksum->setAlgorithm(new DCATLiteral('algorithmValue'));

        $this->assertEquals(
            ['hash' => 'hashValue', 'algorithm' => 'algorithmValue'],
            $checksum->getData()
        );
    }

    public function testOnlyReturnsSetProperties(): void
    {
        $checksum = new DCATChecksum();
        $checksum->setAlgorithm(new DCATLiteral('algorithmValue'));

        $this->assertEquals(
            ['algorithm' => 'algorithmValue'],
            $checksum->getData()
        );
    }

    public function testFailsValidationIfOnePropertyIsInvalid(): void
    {
        $checksum = new DCATChecksum();
        $checksum->setHash(new DCATLiteral(''));
        $checksum->setAlgorithm(new DCATLiteral('algorithmValue'));

        $this->assertFalse($checksum->validate()->validated());
    }

    public function testValidatesWhenAllPropertiesArePresentAndValid(): void
    {
        $checksum = new DCATChecksum();
        $checksum->setHash(new DCATLiteral('hashValue'));
        $checksum->setAlgorithm(new DCATLiteral('algorithmValue'));

        $this->assertTrue($checksum->validate()->validated());
    }

    public function testSettersAndGettersWork(): void
    {
        $checksum = new DCATChecksum();
        $checksum->setHash(new DCATLiteral('hashValue'));
        $checksum->setAlgorithm(new DCATLiteral('algorithmValue'));

        $this->assertEquals('hashValue', $checksum->getHash()->getData());
        $this->assertEquals('algorithmValue', $checksum->getAlgorithm()->getData());
    }
}
