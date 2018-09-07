<?php

use PHPUnit\Framework\TestCase;
use DCAT_AP_DONL\DCATProperty;
use DCAT_AP_DONL\DCATURI;
use DCAT_AP_DONL\ComplexEntities\LegalFoundation;


class LegalFoundationTest extends TestCase {

    public function testDataRetrievalReturnsAKeyValueArray(): void
    {
        $lf = new LegalFoundation(
            new DCATProperty('reference', 'referenceValue'),
            new DCATURI('uri', 'ssh://google.nl'),
            new DCATProperty('label', 'labelValue')
        );

        $this->assertEquals(
            [
                'reference' => 'referenceValue',
                'uri' => 'ssh://google.nl',
                'label' => 'labelValue'
            ],
            $lf->getData()
        );
    }

    public function testOnlyReturnsSetProperties(): void
    {
        $lf = new LegalFoundation(
            null,
            new DCATURI('uri', 'ftp://google.nl'),
            new DCATProperty('label', 'labelValue')
        );

        $this->assertEquals(['uri' => 'ftp://google.nl', 'label' => 'labelValue'], $lf->getData());
    }

    public function testFailsValidationIfOnePropertyIsInvalid(): void
    {
        $lf = new LegalFoundation(
            new DCATProperty('reference', ''),
            new DCATURI('uri', 'https://uri.tk'),
            new DCATProperty('label', 'labelValue')
        );

        $this->assertFalse($lf->validate()->validated());
    }

    public function testValidatesWhenAllPropertiesArePresentAndValid(): void
    {
        $lf = new LegalFoundation(
            new DCATProperty('reference', 'referenceValue'),
            new DCATURI('uri', 'https://uri.com'),
            new DCATProperty('label', 'labelValue')
        );

        $this->assertTrue($lf->validate()->validated());
    }

}
