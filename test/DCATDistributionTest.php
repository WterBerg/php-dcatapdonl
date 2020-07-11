<?php

namespace DCAT_AP_DONL\Test;

use DCAT_AP_DONL\DCATChecksum;
use DCAT_AP_DONL\DCATControlledVocabularyEntry;
use DCAT_AP_DONL\DCATDateTime;
use DCAT_AP_DONL\DCATDistribution;
use DCAT_AP_DONL\DCATException;
use DCAT_AP_DONL\DCATLiteral;
use DCAT_AP_DONL\DCATNumber;
use DCAT_AP_DONL\DCATURI;
use PHPUnit\Framework\TestCase;

class DCATDistributionTest extends TestCase
{
    public function testGettersAndSettersArePresentAndFunctional(): void
    {
        try {
            $title             = new DCATLiteral('testTitle');
            $description       = new DCATLiteral('testDescription');
            $access_url        = new DCATURI('https://test.uri');
            $byte_size         = new DCATNumber(1);
            $format            = new DCATControlledVocabularyEntry('test', 'MDR:FiletypeNAL');
            $license           = new DCATControlledVocabularyEntry('test', 'DONL:License');
            $mediatype         = new DCATControlledVocabularyEntry('test', 'IANA:Mediatypes');
            $language          = new DCATControlledVocabularyEntry('test', 'DONL:Language');
            $type              = new DCATControlledVocabularyEntry('test', 'DONL:DistributionType');
            $modification_date = new DCATDateTime('testDate');
            $release_date      = new DCATDateTime('testDate');
            $rights            = new DCATLiteral('testRights');
            $status            = new DCATControlledVocabularyEntry('', 'ADMS:Distributiestatus');
            $url               = new DCATURI('https://example.com');
            $checksum          = new DCATChecksum();

            $distribution = new DCATDistribution();
            $distribution->setTitle($title);
            $distribution->setDescription($description);
            $distribution->setAccessURL($access_url);
            $distribution->setByteSize($byte_size);
            $distribution->setFormat($format);
            $distribution->setLicense($license);
            $distribution->setMediaType($mediatype);
            $distribution->setMetadataLanguage($language);
            $distribution->setDistributionType($type);
            $distribution->setModificationDate($modification_date);
            $distribution->setReleaseDate($release_date);
            $distribution->setRights($rights);
            $distribution->setStatus($status);
            $distribution->addDocumentation($url);
            $distribution->addDownloadURL($url);
            $distribution->addLanguage($language);
            $distribution->addLinkedSchemas($url);
            $distribution->setChecksum($checksum);

            $this->assertEquals($title, $distribution->getTitle());
            $this->assertEquals($description, $distribution->getDescription());
            $this->assertEquals($access_url, $distribution->getAccessURL());
            $this->assertEquals($byte_size, $distribution->getByteSize());
            $this->assertEquals($format, $distribution->getFormat());
            $this->assertEquals($license, $distribution->getLicense());
            $this->assertEquals($mediatype, $distribution->getMediaType());
            $this->assertEquals($language, $distribution->getMetadataLanguage());
            $this->assertEquals($type, $distribution->getDistributionType());
            $this->assertEquals($modification_date, $distribution->getModificationDate());
            $this->assertEquals($release_date, $distribution->getReleaseDate());
            $this->assertEquals($rights, $distribution->getRights());
            $this->assertEquals($status, $distribution->getStatus());
            $this->assertEquals([$url], $distribution->getDocumentations());
            $this->assertEquals([$url], $distribution->getDownloadURLs());
            $this->assertEquals([$language], $distribution->getLanguages());
            $this->assertEquals([$url], $distribution->getLinkedSchemas());
            $this->assertEquals($checksum, $distribution->getChecksum());
        } catch (DCATException $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testEmptyDistributionsDoNotValidate(): void
    {
        $distribution = new DCATDistribution();

        $this->assertFalse($distribution->validate()->validated());
    }

    public function testSerializedDistributionsAreEqual(): void
    {
        $title         = new DCATLiteral('testValue');
        $distribiton_a = new DCATDistribution();
        $distribiton_b = new DCATDistribution();

        $distribiton_a->setTitle($title);
        $distribiton_b->setTitle($title);

        $this->assertTrue($distribiton_a->equalTo($distribiton_b));
    }

    public function testUnserializeThrowsDCATException(): void
    {
        try {
            $distribution = new DCATDistribution();
            $distribution->unserialize('test');

            $this->fail('expected DCATException');
        } catch (DCATException $e) {
            $this->assertEquals(
                'DCATDistribution::unserialize(string) is not implemented',
                $e->getMessage()
            );
        }
    }

    public function testChecksIfControlledVocabularyIsAcceptedForFormat(): void
    {
        try {
            $dataset = new DCATDistribution();
            $dataset->setFormat(new DCATControlledVocabularyEntry('', 'UnknownVocabulary'));

            $this->fail();
        } catch (DCATException $e) {
            $this->assertEquals(
                sprintf(DCATControlledVocabularyEntry::VOCABULARY_ERROR_FORMAT, 'MDR:FiletypeNAL'),
                $e->getMessage()
            );
        }
    }

    public function testChecksIfControlledVocabularyIsAcceptedForLicense(): void
    {
        try {
            $dataset = new DCATDistribution();
            $dataset->setLicense(new DCATControlledVocabularyEntry('', 'UnknownVocabulary'));

            $this->fail();
        } catch (DCATException $e) {
            $this->assertEquals(
                sprintf(DCATControlledVocabularyEntry::VOCABULARY_ERROR_FORMAT, 'DONL:License'),
                $e->getMessage()
            );
        }
    }

    public function testChecksIfControlledVocabularyIsAcceptedForLanguage(): void
    {
        try {
            $dataset = new DCATDistribution();
            $dataset->addLanguage(new DCATControlledVocabularyEntry('', 'UnknownVocabulary'));

            $this->fail();
        } catch (DCATException $e) {
            $this->assertEquals(
                sprintf(DCATControlledVocabularyEntry::VOCABULARY_ERROR_FORMAT, 'DONL:Language'),
                $e->getMessage()
            );
        }
    }

    public function testChecksIfControlledVocabularyIsAcceptedForMetadataLanguage(): void
    {
        try {
            $dataset = new DCATDistribution();
            $dataset->setMetadataLanguage(new DCATControlledVocabularyEntry('', 'UnknownVocabulary'));

            $this->fail();
        } catch (DCATException $e) {
            $this->assertEquals(
                sprintf(DCATControlledVocabularyEntry::VOCABULARY_ERROR_FORMAT, 'DONL:Language'),
                $e->getMessage()
            );
        }
    }

    public function testChecksIfControlledVocabularyIsAcceptedForStatus(): void
    {
        try {
            $dataset = new DCATDistribution();
            $dataset->setStatus(new DCATControlledVocabularyEntry('', 'UnknownVocabulary'));

            $this->fail();
        } catch (DCATException $e) {
            $this->assertEquals(
                sprintf(DCATControlledVocabularyEntry::VOCABULARY_ERROR_FORMAT, 'ADMS:Distributiestatus'),
                $e->getMessage()
            );
        }
    }

    public function testChecksIfControlledVocabularyIsAcceptedForMediatype(): void
    {
        try {
            $dataset = new DCATDistribution();
            $dataset->setMediaType(new DCATControlledVocabularyEntry('', 'UnknownVocabulary'));

            $this->fail();
        } catch (DCATException $e) {
            $this->assertEquals(
                sprintf(DCATControlledVocabularyEntry::VOCABULARY_ERROR_FORMAT, 'IANA:Mediatypes'),
                $e->getMessage()
            );
        }
    }

    public function testChecksIfControlledVocabularyIsAcceptedForType(): void
    {
        try {
            $dataset = new DCATDistribution();
            $dataset->setDistributionType(new DCATControlledVocabularyEntry('', 'UnknownVocabulary'));

            $this->fail();
        } catch (DCATException $e) {
            $this->assertEquals(
                sprintf(DCATControlledVocabularyEntry::VOCABULARY_ERROR_FORMAT, 'DONL:DistributionType'),
                $e->getMessage()
            );
        }
    }
}
