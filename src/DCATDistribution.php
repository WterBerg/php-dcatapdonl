<?php

namespace DCAT_AP_DONL;

use Serializable;

/**
 * Class DCATDistribution.
 *
 * Represents the complex entity DCATDistribution.
 */
class DCATDistribution extends DCATComplexEntity implements Serializable
{
    /** @var string[] */
    protected static $PROPERTIES = [
        'accessURL', 'license', 'title', 'description', 'language', 'metadataLanguage', 'format',
        'rights', 'status', 'releaseDate', 'modificationDate', 'byteSize', 'downloadURL',
        'mediaType', 'linkedSchema', 'checksum', 'documentation',
    ];

    /** @var string[] */
    protected static $REQUIRED_PROPERTIES = [
        'accessURL', 'license', 'title', 'description', 'language', 'format', 'metadataLanguage',
    ];

    /** @var DCATURI */
    protected $accessURL;

    /** @var DCATControlledVocabularyEntry */
    protected $license;

    /** @var DCATLiteral */
    protected $title;

    /** @var DCATLiteral */
    protected $description;

    /** @var DCATControlledVocabularyEntry[] */
    protected $language;

    /** @var DCATControlledVocabularyEntry */
    protected $metadataLanguage;

    /** @var DCATControlledVocabularyEntry */
    protected $format;

    /** @var DCATLiteral */
    protected $rights;

    /** @var DCATControlledVocabularyEntry */
    protected $status;

    /** @var DCATDateTime */
    protected $releaseDate;

    /** @var DCATDateTime */
    protected $modificationDate;

    /** @var DCATNumber */
    protected $byteSize;

    /** @var DCATURI[] */
    protected $downloadURL;

    /** @var DCATControlledVocabularyEntry */
    protected $mediaType;

    /** @var DCATURI[] */
    protected $linkedSchema;

    /** @var DCATChecksum */
    protected $checksum;

    /** @var DCATURI[] */
    protected $documentation;

    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        parent::__construct(self::$PROPERTIES, self::$REQUIRED_PROPERTIES);

        $multivalued = ['downloadURL', 'language', 'linkedSchema', 'documentation'];

        foreach ($multivalued as $property) {
            $this->$property = [];
        }
    }

    /**
     * Compares itself to another DCATDistribution object.
     *
     * @param DCATDistribution $target The DCATDistribution to compare against
     *
     * @return bool Whether or not this DCATDistribution is equal to the given DCATDistribution
     */
    public function equalTo(DCATDistribution $target): bool
    {
        return $this->serialize() == $target->serialize();
    }

    /**
     * {@inheritdoc}
     */
    public function serialize(): string
    {
        $serializationValues = [];

        foreach (self::$PROPERTIES as $property) {
            $serializationValues[] = $this->$property;
        }

        return serialize($serializationValues);
    }

    /**
     * This method is **NOT** implemented.
     *
     * @param string $serialized Ignored
     *
     * @throws DCATException Always thrown
     */
    public function unserialize($serialized): void
    {
        throw new DCATException(
            'DCATDistribution::unserialize(string) is not implemented'
        );
    }

    /**
     * Getter for the accessURL property, may return null.
     *
     * @return null|DCATURI The accessURL property
     */
    public function getAccessURL(): ?DCATURI
    {
        return $this->accessURL;
    }

    /**
     * Getter for the license property, may return null.
     *
     * @return null|DCATControlledVocabularyEntry The license property
     */
    public function getLicense(): ?DCATControlledVocabularyEntry
    {
        return $this->license;
    }

    /**
     * Getter for the title property, may return null.
     *
     * @return null|DCATLiteral The title property
     */
    public function getTitle(): ?DCATLiteral
    {
        return $this->title;
    }

    /**
     * Getter for the description property, may return null.
     *
     * @return null|DCATLiteral The description property
     */
    public function getDescription(): ?DCATLiteral
    {
        return $this->description;
    }

    /**
     * Getter for the language property, may return an empty array.
     *
     * @return DCATControlledVocabularyEntry[] The language property
     */
    public function getLanguages(): array
    {
        return $this->language;
    }

    /**
     * Getter for the metadataLanguage property, may return null.
     *
     * @return null|DCATControlledVocabularyEntry The metadataLanguage property
     */
    public function getMetadataLanguage(): ?DCATControlledVocabularyEntry
    {
        return $this->metadataLanguage;
    }

    /**
     * Getter for the format property, may return null.
     *
     * @return null|DCATControlledVocabularyEntry The format property
     */
    public function getFormat(): ?DCATControlledVocabularyEntry
    {
        return $this->format;
    }

    /**
     * Getter for the rights property, may return null.
     *
     * @return null|DCATLiteral The rights property
     */
    public function getRights(): ?DCATLiteral
    {
        return $this->rights;
    }

    /**
     * Getter for the status property, may return null.
     *
     * @return null|DCATControlledVocabularyEntry The status property
     */
    public function getStatus(): ?DCATControlledVocabularyEntry
    {
        return $this->status;
    }

    /**
     * Getter for the releaseDate property, may return null.
     *
     * @return null|DCATDateTime The releaseDate property
     */
    public function getReleaseDate(): ?DCATDateTime
    {
        return $this->releaseDate;
    }

    /**
     * Getter for the modificationDate property, may return null.
     *
     * @return null|DCATDateTime The modificationDate property
     */
    public function getModificationDate(): ?DCATDateTime
    {
        return $this->modificationDate;
    }

    /**
     * Getter for the byteSize property, may return null.
     *
     * @return null|DCATNumber The byteSize property
     */
    public function getByteSize(): ?DCATNumber
    {
        return $this->byteSize;
    }

    /**
     * Getter for the downloadURL property, may return an empty array.
     *
     * @return DCATURI[] The downloadURL property
     */
    public function getDownloadURLs(): array
    {
        return $this->downloadURL;
    }

    /**
     * Getter for the mediaType property, may return null.
     *
     * @return null|DCATControlledVocabularyEntry The mediaType property
     */
    public function getMediaType(): ?DCATControlledVocabularyEntry
    {
        return $this->mediaType ?: null;
    }

    /**
     * Getter for the linkedSchema property, may return an empty array.
     *
     * @return DCATURI[] The linkedSchema property
     */
    public function getLinkedSchemas(): array
    {
        return $this->linkedSchema;
    }

    /**
     * Getter for the checksum property, may return null.
     *
     * @return null|DCATChecksum The checksum property
     */
    public function getChecksum(): ?DCATChecksum
    {
        return $this->checksum;
    }

    /**
     * Getter for the documentation property, may return an empty array.
     *
     * @return DCATURI[] The documentation property
     */
    public function getDocumentations(): array
    {
        return $this->documentation;
    }

    /**
     * Setter for the accessURL property.
     *
     * @param DCATURI $accessURL The value to set
     */
    public function setAccessURL(DCATURI $accessURL): void
    {
        $this->accessURL = $accessURL;
    }

    /**
     * Setter for the license property. Expect a DCATControlledVocabularyEntry of vocabulary
     * 'Overheid:License'.
     *
     * @param DCATControlledVocabularyEntry $license The value to set
     *
     * @throws DCATException Thrown when the vocabulary is not 'Overheid:License'
     */
    public function setLicense(DCATControlledVocabularyEntry $license): void
    {
        if ('Overheid:License' !== $license->getControlledVocabulary()) {
            throw new DCATException(
                'Expected a DCATControlledVocabularyEntry of vocabulary Overheid:License'
            );
        }

        $this->license = $license;
    }

    /**
     * Setter for the title property.
     *
     * @param DCATLiteral $title The value to set
     */
    public function setTitle(DCATLiteral $title): void
    {
        $this->title = $title;
    }

    /**
     * Setter for the description property.
     *
     * @param DCATLiteral $description The value to set
     */
    public function setDescription(DCATLiteral $description): void
    {
        $this->description = $description;
    }

    /**
     * Adds a value to the language property. Expect a DCATControlledVocabularyEntry of vocabulary
     * 'DONL:Language'.
     *
     * @param DCATControlledVocabularyEntry $language The value to add
     *
     * @throws DCATException Thrown when the vocabulary is not 'DONL:Language'
     */
    public function addLanguage(DCATControlledVocabularyEntry $language): void
    {
        if ('DONL:Language' !== $language->getControlledVocabulary()) {
            throw new DCATException(
                'Expected a DCATControlledVocabularyEntry of vocabulary DONL:Language'
            );
        }

        $this->language[] = $language;
    }

    /**
     * Setter for the metadataLanguage property. Expect a DCATControlledVocabularyEntry of
     * vocabulary 'DONL:Language'.
     *
     * @param DCATControlledVocabularyEntry $metadataLanguage The value to set
     *
     * @throws DCATException Thrown when the vocabulary is not 'DONL:Language'
     */
    public function setMetadataLanguage(DCATControlledVocabularyEntry $metadataLanguage): void
    {
        if ('DONL:Language' !== $metadataLanguage->getControlledVocabulary()) {
            throw new DCATException(
                'Expected a DCATControlledVocabularyEntry of vocabulary DONL:Language'
            );
        }

        $this->metadataLanguage = $metadataLanguage;
    }

    /**
     * Setter for the format property. Expect a DCATControlledVocabularyEntry of vocabulary
     * 'MDR:FiletypeNAL'.
     *
     * @param DCATControlledVocabularyEntry $format The value to set
     *
     * @throws DCATException Thrown when the vocabulary is not 'MDR:FiletypeNAL'
     */
    public function setFormat(DCATControlledVocabularyEntry $format): void
    {
        if ('MDR:FiletypeNAL' !== $format->getControlledVocabulary()) {
            throw new DCATException(
                'Expected a DCATControlledVocabularyEntry of vocabulary MDR:FiletypeNAL'
            );
        }

        $this->format = $format;
    }

    /**
     * Setter for the rights property.
     *
     * @param DCATLiteral $rights The value to set
     */
    public function setRights(DCATLiteral $rights): void
    {
        $this->rights = $rights;
    }

    /**
     * Setter for the status property. Expect a DCATControlledVocabularyEntry of vocabulary
     * 'ADMS:Distributiestatus'.
     *
     * @param DCATControlledVocabularyEntry $status The value to set
     *
     * @throws DCATException Thrown when the vocabulary is not 'ADMS:Distributiestatus'
     */
    public function setStatus(DCATControlledVocabularyEntry $status): void
    {
        if ('ADMS:Distributiestatus' !== $status->getControlledVocabulary()) {
            throw new DCATException(
                'Expected a DCATControlledVocabularyEntry of vocabulary ADMS:Distributiestatus'
            );
        }

        $this->status = $status;
    }

    /**
     * Setter for the releaseDate property.
     *
     * @param DCATDateTime $releaseDate The value to set
     */
    public function setReleaseDate(DCATDateTime $releaseDate): void
    {
        $this->releaseDate = $releaseDate;
    }

    /**
     * Setter for the modificationDate property.
     *
     * @param DCATDateTime $modificationDate The value to set
     */
    public function setModificationDate(DCATDateTime $modificationDate): void
    {
        $this->modificationDate = $modificationDate;
    }

    /**
     * Setter for the byteSize property.
     *
     * @param DCATNumber $byteSize The value to set
     */
    public function setByteSize(DCATNumber $byteSize): void
    {
        $this->byteSize = $byteSize;
    }

    /**
     * Adds a value to the downloadURL property.
     *
     * @param DCATURI $downloadURL The value to add
     */
    public function addDownloadURL(DCATURI $downloadURL): void
    {
        $this->downloadURL[] = $downloadURL;
    }

    /**
     * Setter for the mediaType property. Expect a DCATControlledVocabularyEntry of vocabulary
     * 'IANA:Mediatypes'.
     *
     * @param DCATControlledVocabularyEntry $mediaType The value to set
     *
     * @throws DCATException Thrown when the vocabulary is not 'IANA:Mediatypes'
     */
    public function setMediaType(DCATControlledVocabularyEntry $mediaType): void
    {
        if ('IANA:Mediatypes' !== $mediaType->getControlledVocabulary()) {
            throw new DCATException(
                'Expected a DCATControlledVocabularyEntry of vocabulary IANA:Mediatypes'
            );
        }

        $this->mediaType = $mediaType;
    }

    /**
     * Adds a value to the linkedSchema property.
     *
     * @param DCATURI $linkedSchema The value to add
     */
    public function addLinkedSchema(DCATURI $linkedSchema): void
    {
        $this->linkedSchema[] = $linkedSchema;
    }

    /**
     * Setter for the checksum property.
     *
     * @param DCATChecksum $checksum The value to set
     */
    public function setChecksum(DCATChecksum $checksum): void
    {
        $this->checksum = $checksum;
    }

    /**
     * Adds a value to the documentation property.
     *
     * @param DCATURI $documentation The value to add
     */
    public function addDocumentation(DCATURI $documentation): void
    {
        $this->documentation[] = $documentation;
    }
}
