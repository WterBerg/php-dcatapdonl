<?php

use DCAT_AP_DONL\DCATLegalFoundation;
use DCAT_AP_DONL\DCATLiteral;
use DCAT_AP_DONL\DCATURI;
use PHPUnit\Framework\TestCase;

class DCATLegalFoundationTest extends TestCase
{
    public function testDataRetrievalReturnsAKeyValueArray(): void
    {
        $lf = new DCATLegalFoundation();
        $lf->setReference(new DCATLiteral('referenceValue'));
        $lf->setUri(new DCATURI('ssh://google.nl'));
        $lf->setLabel(new DCATLiteral('labelValue'));

        $this->assertEquals(
            [
                'reference' => 'referenceValue',
                'uri'       => 'ssh://google.nl',
                'label'     => 'labelValue',
            ],
            $lf->getData()
        );
    }

    public function testOnlyReturnsSetProperties(): void
    {
        $lf = new DCATLegalFoundation();
        $lf->setUri(new DCATURI('ftp://google.nl'));
        $lf->setLabel(new DCATLiteral('labelValue'));

        $this->assertEquals(['uri' => 'ftp://google.nl', 'label' => 'labelValue'], $lf->getData());
    }

    public function testFailsValidationIfOnePropertyIsInvalid(): void
    {
        $lf = new DCATLegalFoundation();
        $lf->setReference(new DCATLiteral(''));
        $lf->setUri(new DCATURI('ssh://google.nl'));
        $lf->setLabel(new DCATLiteral('labelValue'));

        $this->assertFalse($lf->validate()->validated());
    }

    public function testValidatesWhenAllPropertiesArePresentAndValid(): void
    {
        $lf = new DCATLegalFoundation();
        $lf->setReference(new DCATLiteral('referenceValue'));
        $lf->setUri(new DCATURI('ssh://google.nl'));
        $lf->setLabel(new DCATLiteral('labelValue'));

        $this->assertTrue($lf->validate()->validated());
    }

    public function testGettersArePresentAndFunctional(): void
    {
        $lf = new DCATLegalFoundation();
        $lf->setReference(new DCATLiteral('referenceValue'));
        $lf->setUri(new DCATURI('ssh://google.nl'));
        $lf->setLabel(new DCATLiteral('labelValue'));

        $this->assertEquals('referenceValue', $lf->getReference()->getData());
        $this->assertEquals('ssh://google.nl', $lf->getUri()->getData());
        $this->assertEquals('labelValue', $lf->getLabel()->getData());
    }
}
