<?php

use PHPUnit\Framework\TestCase;
use DCAT_AP_DONL\DCATControlledVocabulary;
use DCAT_AP_DONL\DCATException;


class DCATControlledVocabularyTest extends TestCase {

    public function testExceptionThrownWhenRequestingNonExistentVocabulary(): void
    {
        try {
            DCATControlledVocabulary::getVocabulary('Test');
            $this->fail();
        } catch (DCATException $e) {
            $this->assertEquals('no vocabulary found with name Test', $e->getMessage());
        }
    }

    public function testAllowsRetrievalOfExistingVocabularies(): void
    {
        try {
            DCATControlledVocabulary::getVocabulary('ADMS:Changetype');
            DCATControlledVocabulary::getVocabulary('ADMS:Distributiestatus');
            DCATControlledVocabulary::getVocabulary('DONL:Catalogs');
            DCATControlledVocabulary::getVocabulary('DONL:Language');
            DCATControlledVocabulary::getVocabulary('DONL:Organization');
            DCATControlledVocabulary::getVocabulary('IANA:Mediatypes');
            DCATControlledVocabulary::getVocabulary('MDR:FiletypeNAL');
            DCATControlledVocabulary::getVocabulary('Overheid:DatasetStatus');
            DCATControlledVocabulary::getVocabulary('Overheid:Frequency');
            DCATControlledVocabulary::getVocabulary('Overheid:License');
            DCATControlledVocabulary::getVocabulary('Overheid:Openbaarheidsniveau');
            DCATControlledVocabulary::getVocabulary('Overheid:SpatialGemeente');
            DCATControlledVocabulary::getVocabulary('Overheid:SpatialKoninkrijksdeel');
            DCATControlledVocabulary::getVocabulary('Overheid:SpatialProvincie');
            DCATControlledVocabulary::getVocabulary('Overheid:SpatialScheme');
            DCATControlledVocabulary::getVocabulary('Overheid:SpatialWaterschap');
            DCATControlledVocabulary::getVocabulary('Overheid:Taxonomiebeleidsagenda');

            $this->assertTrue(true, 'No DCATException thrown');
        } catch (DCATException $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testNameAndSourceAreRetrievable(): void
    {
        try {
            $cv = DCATControlledVocabulary::getVocabulary('ADMS:Changetype');

            $this->assertEquals('ADMS:Changetype', $cv->getName());
            $this->assertEquals('https://waardelijsten.dcat-ap-donl.nl/adms_changetype.json', $cv->getSource());
        } catch (DCATException $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testFalseOnNonExistentEntrySearch(): void
    {
        try {
            $cv = DCATControlledVocabulary::getVocabulary('ADMS:Changetype');

            $this->assertFalse($cv->containsEntry(':nonExistent'));
        } catch (DCATException $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testTrueOnExistingEntrySearch(): void
    {
        try {
            $cv = DCATControlledVocabulary::getVocabulary('ADMS:Changetype');

            $this->assertTrue($cv->containsEntry(':created'));
        } catch (DCATException $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testCustomVocabulariesCanBeAdded(): void
    {
        try {
            DCATControlledVocabulary::addCustomVocabulary('TestVocabulary', ['a', 'b']);
            DCATControlledVocabulary::getVocabulary('TestVocabulary');

            $this->assertTrue(true);
        } catch (DCATException $e) {
            $this->fail();
        }
    }

    public function testCustomVocabulariesFunctionAsNormalVocabularies(): void
    {
        try {
            DCATControlledVocabulary::addCustomVocabulary('TestVocabulary2', ['a', 'b']);
            $vocabulary = DCATControlledVocabulary::getVocabulary('TestVocabulary2');

            $this->assertTrue($vocabulary->containsEntry('a'));
        } catch (DCATException $e) {
            $this->fail();
        }
    }

    public function testCantAddExistingVocabulary(): void
    {
        try {
            DCATControlledVocabulary::addCustomVocabulary('TestVocabulary3', ['a', 'b']);
            DCATControlledVocabulary::addCustomVocabulary('TestVocabulary3', ['a', 'b']);

            $this->fail();
        } catch (DCATException $e) {
            $this->assertEquals('a vocabulary with the given name is already defined', $e->getMessage());
        }
    }

}
