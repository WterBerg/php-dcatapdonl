<?php

use PHPUnit\Framework\TestCase;
use DCAT_AP_DONL\DCATDataset;
use DCAT_AP_DONL\DCATContactPoint;
use DCAT_AP_DONL\DCATLegalFoundation;
use DCAT_AP_DONL\DCATTemporal;
use DCAT_AP_DONL\DCATDistribution;
use DCAT_AP_DONL\DCATSpatial;
use DCAT_AP_DONL\DCATProperty;
use DCAT_AP_DONL\DCATDateTime;
use DCAT_AP_DONL\DCATURI;
use DCAT_AP_DONL\DCATBoolean;
use DCAT_AP_DONL\DCATControlledVocabularyEntry;
use DCAT_AP_DONL\DCATException;


class DCATDatasetTest extends TestCase {

    public function testEmptyDatasetsDoNotValidate(): void
    {
        $dataset = new DCATDataset();

        $this->assertFalse($dataset->validate()->validated());
    }

    public function testGettersArePresentAndFunctional(): void
    {
        try {
            $dataset = new DCATDataset();
            $dataset->setAccessRights(new DCATControlledVocabularyEntry('accessRights', 'http://publications.europa.eu/resource/authority/access-right/PUBLIC', 'Overheid:Openbaarheidsniveau'));
            $dataset->setAuthority(new DCATControlledVocabularyEntry('authority', 'http://standaarden.overheid.nl/owms/terms/Veere', 'DONL:Organization'));
            $dataset->setDatasetStatus(new DCATControlledVocabularyEntry('datasetStatus', 'http://data.overheid.nl/status/beschikbaar', 'Overheid:DatasetStatus'));
            $dataset->setDatePlanned(new DCATDateTime('datePlanned', '2018-12-31T23:59:59'));
            $dataset->setDescription(new DCATProperty('description', 'bla bla bla'));
            $dataset->setFrequency(new DCATControlledVocabularyEntry('frequency', 'testFrequency', 'Overheid:Frequency'));
            $dataset->setIdentifier(new DCATURI('identifier', 'https://www.example.com/identifier'));
            $dataset->setLandingPage(new DCATURI('landingPage', 'https://www.example.com/index.html'));
            $dataset->setLicense(new DCATControlledVocabularyEntry('license', 'http://creativecommons.org/publicdomain/mark/1.0/deed.nl', 'Overheid:License'));
            $dataset->setMetadataLanguage(new DCATControlledVocabularyEntry('metadataLanguage', 'http://publications.europa.eu/resource/authority/language/NLD', 'DONL:Language'));
            $dataset->setModificationDate(new DCATDateTime('modified', '2018-01-01T12:30:59'));
            $dataset->setPublisher(new DCATControlledVocabularyEntry('publisher', 'http://standaarden.overheid.nl/owms/terms/Veere', 'DONL:Organization'));
            $dataset->setReleaseDate(new DCATDateTime('releaseDate', '2018'));
            $dataset->setSourceCatalog(new DCATControlledVocabularyEntry('sourceCatalog', 'https://data.overheid.nl', 'DONL:Catalogs'));
            $dataset->setTitle(new DCATProperty('title', 'myTitle'));
            $dataset->setVersion(new DCATProperty('version', '1.0'));
            $dataset->setHighValue(new DCATBoolean('highValue', DCATBoolean::TRUE));
            $dataset->setReferentieData(new DCATBoolean('referentieData', DCATBoolean::TRUE));
            $dataset->setBasisRegister(new DCATBoolean('basisRegister', DCATBoolean::TRUE));

            $temporal = new DCATTemporal();
            $temporal->setLabel(new DCATProperty('label', 'MyLabel'));
            $dataset->setTemporal($temporal);

            $legalFoundation = new DCATLegalFoundation();
            $legalFoundation->setLabel(new DCATProperty('label', 'MyLaw'));
            $dataset->setLegalFoundation($legalFoundation);

            $contactPoint = new DCATContactPoint();
            $contactPoint->setFullName(new DCATProperty('fullName', 'Willem ter Berg'));
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
            $this->assertEquals('True', $dataset->getHighValue()->getData());
            $this->assertEquals('True', $dataset->getReferentieData()->getData());
            $this->assertEquals('True', $dataset->getBasisRegister()->getData());
            $this->assertEquals(['Label' => 'MyLabel'], $dataset->getTemporal()->getData());
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
            $dataset->addAlternativeIdentifier(new DCATURI('alternateIdentifier', 'https://myidentifier.com'));
            $dataset->addConformsTo(new DCATURI('conformsTo', 'https://mystandard.com'));
            $dataset->addDocumentation(new DCATURI('documentation', 'https://mydocumentation.com'));
            $dataset->addHasVersion(new DCATURI('hasVersion', 'https://another.dataset.info'));
            $dataset->addIsVersionOf(new DCATURI('isVersionOf', 'https://another.dataset.info'));
            $dataset->addKeyword(new DCATProperty('keyword', 'MyKeyword'));
            $dataset->addProvenance(new DCATURI('provenance', 'https://myprovenance.com'));
            $dataset->addSample(new DCATURI('sample', 'https://sample.com/dataset'));
            $dataset->addSource(new DCATURI('source', 'https://source.com/dataset'));
            $dataset->addRelatedResource(new DCATURI('relatedResource', 'https://related-resource.com/dataset'));
            $dataset->addVersionNotes(new DCATProperty('versionNotes', 'My version notes'));

            $dataset->addLanguage(new DCATControlledVocabularyEntry('language', 'http://publications.europa.eu/resource/authority/language/NLD', 'DONL:Language'));
            $dataset->addTheme(new DCATControlledVocabularyEntry('theme', 'http://standaarden.overheid.nl/owms/terms/Gezin_en_kinderen', 'Overheid:Taxonomiebeleidsagenda'));
            $dataset->addDistribution(new DCATDistribution());
            $dataset->addSpatial(new DCATSpatial());

            $this->assertEquals([new DCATURI('alternateIdentifier', 'https://myidentifier.com')], $dataset->getAlternativeIdentifier());
            $this->assertEquals([new DCATURI('conformsTo', 'https://mystandard.com')], $dataset->getConformsTo());
            $this->assertEquals([new DCATURI('documentation', 'https://mydocumentation.com')], $dataset->getDocumentation());
            $this->assertEquals([new DCATURI('hasVersion', 'https://another.dataset.info')], $dataset->getHasVersion());
            $this->assertEquals([new DCATURI('isVersionOf', 'https://another.dataset.info')], $dataset->getIsVersionOf());
            $this->assertEquals([new DCATProperty('keyword', 'MyKeyword')], $dataset->getKeyword());
            $this->assertEquals([new DCATURI('provenance', 'https://myprovenance.com')], $dataset->getProvenance());
            $this->assertEquals([new DCATURI('sample', 'https://sample.com/dataset')], $dataset->getSample());
            $this->assertEquals([new DCATURI('source', 'https://source.com/dataset')], $dataset->getSource());
            $this->assertEquals([new DCATURI('relatedResource', 'https://related-resource.com/dataset')], $dataset->getRelatedResource());
            $this->assertEquals([new DCATProperty('versionNotes', 'My version notes')], $dataset->getVersionNotes());

            $this->assertEquals([new DCATControlledVocabularyEntry('language', 'http://publications.europa.eu/resource/authority/language/NLD', 'DONL:Language')], $dataset->getLanguage());
            $this->assertEquals([new DCATControlledVocabularyEntry('theme', 'http://standaarden.overheid.nl/owms/terms/Gezin_en_kinderen', 'Overheid:Taxonomiebeleidsagenda')], $dataset->getTheme());
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
            $dataset->setAccessRights(new DCATControlledVocabularyEntry('accessRights', '', 'UnknownVocabulary'));

            $this->fail();
        } catch (DCATException $e) {
            $this->assertEquals('Expected a DCATControlledVocabularyEntry of vocabulary Overheid:Openbaarheidsniveau', $e->getMessage());
        }
    }

    public function testChecksIfControlledVocabularyIsAcceptedForAuthority(): void
    {
        try {
            $dataset = new DCATDataset();
            $dataset->setAuthority(new DCATControlledVocabularyEntry('authority', '', 'UnknownVocabulary'));

            $this->fail();
        } catch (DCATException $e) {
            $this->assertEquals('Expected a DCATControlledVocabularyEntry of vocabulary DONL:Organization', $e->getMessage());
        }
    }

    public function testChecksIfControlledVocabularyIsAcceptedForDatasetStatus(): void
    {
        try {
            $dataset = new DCATDataset();
            $dataset->setDatasetStatus(new DCATControlledVocabularyEntry('datasetStatus', '', 'UnknownVocabulary'));

            $this->fail();
        } catch (DCATException $e) {
            $this->assertEquals('Expected a DCATControlledVocabularyEntry of vocabulary Overheid:DatasetStatus', $e->getMessage());
        }
    }

    public function testChecksIfControlledVocabularyIsAcceptedForFrequency(): void
    {
        try {
            $dataset = new DCATDataset();
            $dataset->setFrequency(new DCATControlledVocabularyEntry('frequency', '', 'UnknownVocabulary'));

            $this->fail();
        } catch (DCATException $e) {
            $this->assertEquals('Expected a DCATControlledVocabularyEntry of vocabulary Overheid:Frequency', $e->getMessage());
        }
    }

    public function testChecksIfControlledVocabularyIsAcceptedForLicense(): void
    {
        try {
            $dataset = new DCATDataset();
            $dataset->setLicense(new DCATControlledVocabularyEntry('license', '', 'UnknownVocabulary'));

            $this->fail();
        } catch (DCATException $e) {
            $this->assertEquals('Expected a DCATControlledVocabularyEntry of vocabulary Overheid:License', $e->getMessage());
        }
    }

    public function testChecksIfControlledVocabularyIsAcceptedForMetadataLanguage(): void
    {
        try {
            $dataset = new DCATDataset();
            $dataset->setMetadataLanguage(new DCATControlledVocabularyEntry('metadataLanguage', '', 'UnknownVocabulary'));

            $this->fail();
        } catch (DCATException $e) {
            $this->assertEquals('Expected a DCATControlledVocabularyEntry of vocabulary DONL:Language', $e->getMessage());
        }
    }

    public function testChecksIfControlledVocabularyIsAcceptedForPublisher(): void
    {
        try {
            $dataset = new DCATDataset();
            $dataset->setPublisher(new DCATControlledVocabularyEntry('publisher', '', 'UnknownVocabulary'));

            $this->fail();
        } catch (DCATException $e) {
            $this->assertEquals('Expected a DCATControlledVocabularyEntry of vocabulary DONL:Organization', $e->getMessage());
        }
    }

    public function testChecksIfControlledVocabularyIsAcceptedForSourceCatalog(): void
    {
        try {
            $dataset = new DCATDataset();
            $dataset->setSourceCatalog(new DCATControlledVocabularyEntry('sourceCatalog', '', 'UnknownVocabulary'));

            $this->fail();
        } catch (DCATException $e) {
            $this->assertEquals('Expected a DCATControlledVocabularyEntry of vocabulary DONL:Catalogs', $e->getMessage());
        }
    }

    public function testChecksIfControlledVocabularyIsAcceptedForLanguage(): void
    {
        try {
            $dataset = new DCATDataset();
            $dataset->addLanguage(new DCATControlledVocabularyEntry('language', '', 'UnknownVocabulary'));

            $this->fail();
        } catch (DCATException $e) {
            $this->assertEquals('Expected a DCATControlledVocabularyEntry of vocabulary DONL:Language', $e->getMessage());
        }
    }

    public function testChecksIfControlledVocabularyIsAcceptedForTheme(): void
    {
        try {
            $dataset = new DCATDataset();
            $dataset->addTheme(new DCATControlledVocabularyEntry('theme', '', 'UnknownVocabulary'));

            $this->fail();
        } catch (DCATException $e) {
            $this->assertEquals('Expected a DCATControlledVocabularyEntry of vocabulary Overheid:Taxonomiebeleidsagenda', $e->getMessage());
        }
    }

}
