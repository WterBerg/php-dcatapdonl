<?php

namespace DCAT_AP_DONL\Test;

use DCAT_AP_DONL\DCATBoolean;
use DCAT_AP_DONL\DCATContactPoint;
use DCAT_AP_DONL\DCATControlledVocabularyEntry;
use DCAT_AP_DONL\DCATDataset;
use DCAT_AP_DONL\DCATDateTime;
use DCAT_AP_DONL\DCATDistribution;
use DCAT_AP_DONL\DCATException;
use DCAT_AP_DONL\DCATLegalFoundation;
use DCAT_AP_DONL\DCATLiteral;
use DCAT_AP_DONL\DCATSpatial;
use DCAT_AP_DONL\DCATTemporal;
use DCAT_AP_DONL\DCATURI;
use PHPUnit\Framework\TestCase;

class DCATDatasetTest extends TestCase
{
    public function testEmptyDatasetsDoNotValidate(): void
    {
        $dataset = new DCATDataset();

        $this->assertFalse($dataset->validate()->validated());
    }

    public function testGettersArePresentAndFunctional(): void
    {
        try {
            $dataset = new DCATDataset();
            $dataset->setAccessRights(new DCATControlledVocabularyEntry('http://publications.europa.eu/resource/authority/access-right/PUBLIC', 'Overheid:Openbaarheidsniveau'));
            $dataset->setAuthority(new DCATControlledVocabularyEntry('http://standaarden.overheid.nl/owms/terms/Veere', 'DONL:Organization'));
            $dataset->setDatasetStatus(new DCATControlledVocabularyEntry('http://data.overheid.nl/status/beschikbaar', 'Overheid:DatasetStatus'));
            $dataset->setDatePlanned(new DCATDateTime('2018-12-31T23:59:59'));
            $dataset->setDescription(new DCATLiteral('bla bla bla'));
            $dataset->setFrequency(new DCATControlledVocabularyEntry('testFrequency', 'Overheid:Frequency'));
            $dataset->setIdentifier(new DCATURI('https://www.example.com/identifier'));
            $dataset->setLandingPage(new DCATURI('https://www.example.com/index.html'));
            $dataset->setLicense(new DCATControlledVocabularyEntry('http://creativecommons.org/publicdomain/mark/1.0/deed.nl', 'DONL:License'));
            $dataset->setMetadataLanguage(new DCATControlledVocabularyEntry('http://publications.europa.eu/resource/authority/language/NLD', 'DONL:Language'));
            $dataset->setModificationDate(new DCATDateTime('2018-01-01T12:30:59'));
            $dataset->setPublisher(new DCATControlledVocabularyEntry('http://standaarden.overheid.nl/owms/terms/Veere', 'DONL:Organization'));
            $dataset->setReleaseDate(new DCATDateTime('2018'));
            $dataset->setSourceCatalog(new DCATControlledVocabularyEntry('https://data.overheid.nl', 'DONL:Catalogs'));
            $dataset->setTitle(new DCATLiteral('myTitle'));
            $dataset->setVersion(new DCATLiteral('1.0'));
            $dataset->setHighValue(new DCATBoolean(DCATBoolean::TRUE));
            $dataset->setReferentieData(new DCATBoolean(DCATBoolean::TRUE));
            $dataset->setBasisRegister(new DCATBoolean(DCATBoolean::TRUE));
            $dataset->setNationalCoverage(new DCATBoolean(DCATBoolean::TRUE));

            $temporal = new DCATTemporal();
            $temporal->setLabel(new DCATLiteral('MyLabel'));
            $dataset->setTemporal($temporal);

            $legalFoundation = new DCATLegalFoundation();
            $legalFoundation->setLabel(new DCATLiteral('MyLaw'));
            $dataset->setLegalFoundation($legalFoundation);

            $contactPoint = new DCATContactPoint();
            $contactPoint->setFullName(new DCATLiteral('Willem ter Berg'));
            $dataset->setContactPoint($contactPoint);

            $this->assertEquals('http://publications.europa.eu/resource/authority/access-right/PUBLIC', $dataset->getAccessRights()->getData());
            $this->assertEquals('http://standaarden.overheid.nl/owms/terms/Veere', $dataset->getAuthority()->getData());
            $this->assertEquals('http://data.overheid.nl/status/beschikbaar', $dataset->getDatasetStatus()->getData());
            $this->assertEquals('2018-12-31T23:59:59', $dataset->getDatePlanned()->getData());
            $this->assertEquals('bla bla bla', $dataset->getDescription()->getData());
            $this->assertEquals('testFrequency', $dataset->getFrequency()->getData());
            $this->assertEquals('https://www.example.com/identifier', $dataset->getIdentifier()->getData());
            $this->assertEquals('https://www.example.com/index.html', $dataset->getLandingPage()->getData());
            $this->assertEquals('http://creativecommons.org/publicdomain/mark/1.0/deed.nl', $dataset->getLicense()->getData());
            $this->assertEquals('http://publications.europa.eu/resource/authority/language/NLD', $dataset->getMetadataLanguage()->getData());
            $this->assertEquals('2018-01-01T12:30:59', $dataset->getModificationDate()->getData());
            $this->assertEquals('http://standaarden.overheid.nl/owms/terms/Veere', $dataset->getPublisher()->getData());
            $this->assertEquals('2018', $dataset->getReleaseDate()->getData());
            $this->assertEquals('https://data.overheid.nl', $dataset->getSourceCatalog()->getData());
            $this->assertEquals('myTitle', $dataset->getTitle()->getData());
            $this->assertEquals('1.0', $dataset->getVersion()->getData());
            $this->assertEquals('true', $dataset->getHighValue()->getData());
            $this->assertEquals('true', $dataset->getReferentieData()->getData());
            $this->assertEquals('true', $dataset->getBasisRegister()->getData());
            $this->assertEquals('true', $dataset->getNationalCoverage()->getData());
            $this->assertEquals(['label' => 'MyLabel'], $dataset->getTemporal()->getData());
            $this->assertEquals(['label' => 'MyLaw'], $dataset->getLegalFoundation()->getData());
            $this->assertEquals(['fullName' => 'Willem ter Berg'], $dataset->getContactPoint()->getData());
        } catch (DCATException $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testGettersForMultivaluedPropertiesArePresentAndFunctional(): void
    {
        try {
            $dataset = new DCATDataset();
            $dataset->addAlternativeIdentifier(new DCATURI('https://myidentifier.com'));
            $dataset->addConformsTo(new DCATURI('https://mystandard.com'));
            $dataset->addDocumentation(new DCATURI('https://mydocumentation.com'));
            $dataset->addHasVersion(new DCATURI('https://another.dataset.info'));
            $dataset->addIsVersionOf(new DCATURI('https://another.dataset.info'));
            $dataset->addKeyword(new DCATLiteral('MyKeyword'));
            $dataset->addProvenance(new DCATURI('https://myprovenance.com'));
            $dataset->addSample(new DCATURI('https://sample.com/dataset'));
            $dataset->addSource(new DCATURI('https://source.com/dataset'));
            $dataset->addRelatedResource(new DCATURI('https://related-resource.com/dataset'));
            $dataset->addVersionNotes(new DCATLiteral('My version notes'));

            $dataset->addLanguage(new DCATControlledVocabularyEntry('http://publications.europa.eu/resource/authority/language/NLD', 'DONL:Language'));
            $dataset->addTheme(new DCATControlledVocabularyEntry('http://standaarden.overheid.nl/owms/terms/Gezin_en_kinderen', 'Overheid:Taxonomiebeleidsagenda'));
            $dataset->addDistribution(new DCATDistribution());
            $dataset->addSpatial(new DCATSpatial());

            $this->assertEquals([new DCATURI('https://myidentifier.com')], $dataset->getAlternativeIdentifier());
            $this->assertEquals([new DCATURI('https://mystandard.com')], $dataset->getConformsTo());
            $this->assertEquals([new DCATURI('https://mydocumentation.com')], $dataset->getDocumentation());
            $this->assertEquals([new DCATURI('https://another.dataset.info')], $dataset->getHasVersion());
            $this->assertEquals([new DCATURI('https://another.dataset.info')], $dataset->getIsVersionOf());
            $this->assertEquals([new DCATLiteral('MyKeyword')], $dataset->getKeyword());
            $this->assertEquals([new DCATURI('https://myprovenance.com')], $dataset->getProvenance());
            $this->assertEquals([new DCATURI('https://sample.com/dataset')], $dataset->getSample());
            $this->assertEquals([new DCATURI('https://source.com/dataset')], $dataset->getSource());
            $this->assertEquals([new DCATURI('https://related-resource.com/dataset')], $dataset->getRelatedResource());
            $this->assertEquals([new DCATLiteral('My version notes')], $dataset->getVersionNotes());

            $this->assertEquals([new DCATControlledVocabularyEntry('http://publications.europa.eu/resource/authority/language/NLD', 'DONL:Language')], $dataset->getLanguage());
            $this->assertEquals([new DCATControlledVocabularyEntry('http://standaarden.overheid.nl/owms/terms/Gezin_en_kinderen', 'Overheid:Taxonomiebeleidsagenda')], $dataset->getTheme());
            $this->assertEquals([new DCATDistribution()], $dataset->getDistributions());
            $this->assertEquals([new DCATSpatial()], $dataset->getSpatial());
        } catch (DCATException $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testChecksIfControlledVocabularyIsAcceptedForAccessRights(): void
    {
        try {
            $dataset = new DCATDataset();
            $dataset->setAccessRights(new DCATControlledVocabularyEntry('', 'UnknownVocabulary'));

            $this->fail();
        } catch (DCATException $e) {
            $this->assertEquals(
                sprintf(DCATControlledVocabularyEntry::VOCABULARY_ERROR_FORMAT, 'Overheid:Openbaarheidsniveau'),
                $e->getMessage()
            );
        }
    }

    public function testChecksIfControlledVocabularyIsAcceptedForAuthority(): void
    {
        try {
            $dataset = new DCATDataset();
            $dataset->setAuthority(new DCATControlledVocabularyEntry('', 'UnknownVocabulary'));

            $this->fail();
        } catch (DCATException $e) {
            $this->assertEquals(
                sprintf(DCATControlledVocabularyEntry::VOCABULARY_ERROR_FORMAT, 'DONL:Organization'),
                $e->getMessage()
            );
        }
    }

    public function testChecksIfControlledVocabularyIsAcceptedForDatasetStatus(): void
    {
        try {
            $dataset = new DCATDataset();
            $dataset->setDatasetStatus(new DCATControlledVocabularyEntry('', 'UnknownVocabulary'));

            $this->fail();
        } catch (DCATException $e) {
            $this->assertEquals(
                sprintf(DCATControlledVocabularyEntry::VOCABULARY_ERROR_FORMAT, 'Overheid:DatasetStatus'),
                $e->getMessage()
            );
        }
    }

    public function testChecksIfControlledVocabularyIsAcceptedForFrequency(): void
    {
        try {
            $dataset = new DCATDataset();
            $dataset->setFrequency(new DCATControlledVocabularyEntry('', 'UnknownVocabulary'));

            $this->fail();
        } catch (DCATException $e) {
            $this->assertEquals(
                sprintf(DCATControlledVocabularyEntry::VOCABULARY_ERROR_FORMAT, 'Overheid:Frequency'),
                $e->getMessage()
            );
        }
    }

    public function testChecksIfControlledVocabularyIsAcceptedForLicense(): void
    {
        try {
            $dataset = new DCATDataset();
            $dataset->setLicense(new DCATControlledVocabularyEntry('', 'UnknownVocabulary'));

            $this->fail();
        } catch (DCATException $e) {
            $this->assertEquals(
                sprintf(DCATControlledVocabularyEntry::VOCABULARY_ERROR_FORMAT, 'DONL:License'),
                $e->getMessage()
            );
        }
    }

    public function testChecksIfControlledVocabularyIsAcceptedForMetadataLanguage(): void
    {
        try {
            $dataset = new DCATDataset();
            $dataset->setMetadataLanguage(new DCATControlledVocabularyEntry('', 'UnknownVocabulary'));

            $this->fail();
        } catch (DCATException $e) {
            $this->assertEquals(
                sprintf(DCATControlledVocabularyEntry::VOCABULARY_ERROR_FORMAT, 'DONL:Language'),
                $e->getMessage()
            );
        }
    }

    public function testChecksIfControlledVocabularyIsAcceptedForPublisher(): void
    {
        try {
            $dataset = new DCATDataset();
            $dataset->setPublisher(new DCATControlledVocabularyEntry('', 'UnknownVocabulary'));

            $this->fail();
        } catch (DCATException $e) {
            $this->assertEquals(
                sprintf(DCATControlledVocabularyEntry::VOCABULARY_ERROR_FORMAT, 'DONL:Organization'),
                $e->getMessage()
            );
        }
    }

    public function testChecksIfControlledVocabularyIsAcceptedForSourceCatalog(): void
    {
        try {
            $dataset = new DCATDataset();
            $dataset->setSourceCatalog(new DCATControlledVocabularyEntry('', 'UnknownVocabulary'));

            $this->fail();
        } catch (DCATException $e) {
            $this->assertEquals(
                sprintf(DCATControlledVocabularyEntry::VOCABULARY_ERROR_FORMAT, 'DONL:Catalogs'),
                $e->getMessage()
            );
        }
    }

    public function testChecksIfControlledVocabularyIsAcceptedForLanguage(): void
    {
        try {
            $dataset = new DCATDataset();
            $dataset->addLanguage(new DCATControlledVocabularyEntry('', 'UnknownVocabulary'));

            $this->fail();
        } catch (DCATException $e) {
            $this->assertEquals(
                sprintf(DCATControlledVocabularyEntry::VOCABULARY_ERROR_FORMAT, 'DONL:Language'),
                $e->getMessage()
            );
        }
    }

    public function testChecksIfControlledVocabularyIsAcceptedForTheme(): void
    {
        try {
            $dataset = new DCATDataset();
            $dataset->addTheme(new DCATControlledVocabularyEntry('', 'UnknownVocabulary'));

            $this->fail();
        } catch (DCATException $e) {
            $this->assertEquals(
                sprintf(DCATControlledVocabularyEntry::VOCABULARY_ERROR_FORMAT, 'Overheid:Taxonomiebeleidsagenda'),
                $e->getMessage()
            );
        }
    }

    public function testGetAlternateIdentifierAlias(): void
    {
        $test_value = 'testValue';
        $dataset    = new DCATDataset();
        $dataset->addAlternateIdentifier(new DCATURI($test_value));

        $this->assertEquals($test_value, $dataset->getAlternativeIdentifier()[0]->getData());
        $this->assertEquals($test_value, $dataset->getAlternateIdentifier()[0]->getData());
    }
}
