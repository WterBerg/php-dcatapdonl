<?php

namespace Tests\Unit;

use DCAT_AP_DONL\DCATControlledVocabulary;
use DCAT_AP_DONL\DCATException;
use PHPUnit\Framework\TestCase;

class DCATControlledVocabularyTest extends TestCase
{
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
            DCATControlledVocabulary::getVocabulary('DONL:License');
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
            $vocabulary = DCATControlledVocabulary::getVocabulary('TestVocabulary');

            $this->assertEquals('TestVocabulary', $vocabulary->getName());
            $this->assertEquals('custom', $vocabulary->getSource());
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
            $this->assertEquals('custom', $vocabulary->getSource());
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
            $this->assertEquals(
                DCATControlledVocabulary::DUPLICATE_VOCABULARY_ERROR,
                $e->getMessage())
            ;
        }
    }

    public function testCustomNameIsAccepted(): void
    {
        try {
            DCATControlledVocabulary::addCustomVocabulary('TestVocabulary4', []);
            $vocabulary = DCATControlledVocabulary::getVocabulary('TestVocabulary4');

            $this->assertEquals('TestVocabulary4', $vocabulary->getName());
        } catch (DCATException $e) {
            $this->fail();
        }
    }

    public function testCustomExternalVocabulariesCanBeAdded(): void
    {
        try {
            DCATControlledVocabulary::addCustomExternalVocabulary(
                'TestVocabulary5',
                'https://waardelijsten.dcat-ap-donl.nl/adms_changetype.json'
            );
            $vocabulary = DCATControlledVocabulary::getVocabulary('TestVocabulary5');

            $this->assertEquals('TestVocabulary5', $vocabulary->getName());
        } catch (DCATException $e) {
            $this->fail();
        }
    }

    public function testCustomExternalVocabulariesFailWhenTheyCannotBeLoaded(): void
    {
        try {
            DCATControlledVocabulary::addCustomExternalVocabulary(
                'TestVocabulary6',
                'https://waardelijsten.dcat-ap-donl.nl/does_not_exist.json'
            );

            $this->fail();
        } catch (DCATException $e) {
            $this->assertEquals(
                'failed to parse JSON for vocabulary https://waardelijsten.dcat-ap-donl.nl/does_not_exist.json',
                $e->getMessage()
            );
        }
    }

    public function testCustomExternalVocabulariesCannotBeAddedWithAUsedName(): void
    {
        try {
            DCATControlledVocabulary::addCustomExternalVocabulary('ADMS:Changetype', '');

            $this->fail();
        } catch (DCATException $e) {
            $this->assertEquals(
                DCATControlledVocabulary::DUPLICATE_VOCABULARY_ERROR,
                $e->getMessage()
            );
        }
    }
}
