<?php

use PHPUnit\Framework\TestCase;
use DCAT_AP_DONL\DCATDataset;
use DCAT_AP_DONL\DCATContactPoint;
use DCAT_AP_DONL\DCATProperty;
use DCAT_AP_DONL\DCATDateTime;
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

            $contactPoint = new DCATContactPoint();
            $contactPoint->setFullName(new DCATProperty('fullName', 'Willem ter Berg'));
            $dataset->setContactPoint($contactPoint);

            $this->assertEquals('http://publications.europa.eu/resource/authority/access-right/PUBLIC', $dataset->getAccessRights()->getData());
            $this->assertEquals('http://standaarden.overheid.nl/owms/terms/Veere', $dataset->getAuthority()->getData());
            $this->assertEquals('http://data.overheid.nl/status/beschikbaar', $dataset->getDatasetStatus()->getData());
            $this->assertEquals('2018-12-31T23:59:59', $dataset->getDatePlanned()->getData());
            $this->assertEquals('bla bla bla', $dataset->getDescription()->getData());
            $this->assertEquals('testFrequency', $dataset->getFrequency()->getData());
            $this->assertEquals(['fullName' => 'Willem ter Berg'], $dataset->getContactPoint()->getData());
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

}
