<?php

use PHPUnit\Framework\TestCase;
use DCAT_AP_DONL\DCATProperty;
use DCAT_AP_DONL\DCATURI;
use DCAT_AP_DONL\DCATLegalFoundation;


class DCATLegalFoundationTest extends TestCase {

    public function testDataRetrievalReturnsAKeyValueArray(): void
    {
        $lf = new DCATLegalFoundation();
        $lf->setReference(new DCATProperty('reference', 'referenceValue'));
        $lf->setUri(new DCATURI('uri', 'ssh://google.nl'));
        $lf->setLabel(new DCATProperty('label', 'labelValue'));

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
        $lf = new DCATLegalFoundation();
        $lf->setUri(new DCATURI('uri', 'ftp://google.nl'));
        $lf->setLabel(new DCATProperty('label', 'labelValue'));

        $this->assertEquals(['uri' => 'ftp://google.nl', 'label' => 'labelValue'], $lf->getData());
    }

    public function testFailsValidationIfOnePropertyIsInvalid(): void
    {
        $lf = new DCATLegalFoundation();
        $lf->setReference(new DCATProperty('reference', ''));
        $lf->setUri(new DCATURI('uri', 'ssh://google.nl'));
        $lf->setLabel(new DCATProperty('label', 'labelValue'));

        $this->assertFalse($lf->validate()->validated());
    }

    public function testValidatesWhenAllPropertiesArePresentAndValid(): void
    {
        $lf = new DCATLegalFoundation();
        $lf->setReference(new DCATProperty('reference', 'referenceValue'));
        $lf->setUri(new DCATURI('uri', 'ssh://google.nl'));
        $lf->setLabel(new DCATProperty('label', 'labelValue'));

        $this->assertTrue($lf->validate()->validated());
    }

}
