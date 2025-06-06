<?php

/**
 * This file is part of the wterberg/dcat-ap-donl package.
 *
 * This source file is subject to the license that is
 * bundled with this source code in the LICENSE.md file.
 */

namespace DCAT_AP_DONL;

/**
 * Class DCATDistribution.
 *
 * Represents the complex entity DCATDistribution.
 */
class DCATDistribution extends DCATComplexEntity
{
    /**
     * @var string[]
     */
    protected static array $PROPERTIES = [
        'accessURL', 'license', 'title', 'description', 'language', 'metadataLanguage', 'format',
        'rights', 'status', 'releaseDate', 'modificationDate', 'byteSize', 'downloadURL',
        'mediaType', 'linkedSchema', 'checksum', 'documentation', 'distributionType',
    ];

    /**
     * @var string[]
     */
    protected static array $REQUIRED_PROPERTIES = [
        'accessURL', 'license', 'title', 'description', 'language', 'format', 'metadataLanguage',
    ];

    protected ?DCATURI $accessURL;

    protected ?DCATControlledVocabularyEntry $license;

    protected ?DCATLiteral $title;

    protected ?DCATLiteral $description;

    /**
     * @var DCATControlledVocabularyEntry[]
     */
    protected array $language;

    protected ?DCATControlledVocabularyEntry $metadataLanguage;

    protected ?DCATControlledVocabularyEntry $format;

    protected ?DCATLiteral $rights;

    protected ?DCATControlledVocabularyEntry $status;

    protected ?DCATDateTime $releaseDate;

    protected ?DCATDateTime $modificationDate;

    protected ?DCATNumber $byteSize;

    /**
     * @var DCATURI[]
     */
    protected array $downloadURL;

    protected ?DCATControlledVocabularyEntry $mediaType;

    /**
     * @var DCATURI[]
     */
    protected array $linkedSchema;

    protected ?DCATChecksum $checksum;

    /**
     * @var DCATURI[]
     */
    protected array $documentation;

    protected ?DCATControlledVocabularyEntry $distributionType;

    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        parent::__construct(self::$PROPERTIES, self::$REQUIRED_PROPERTIES, [
            'language', 'downloadURL', 'linkedSchema', 'documentation',
        ]);
    }

    /**
     * Compares itself to another DCATDistribution object.
     *
     * @param DCATDistribution $target The DCATDistribution to compare against
     *
     * @return bool Whether this DCATDistribution is equal to the given DCATDistribution
     */
    public function equalTo(DCATDistribution $target): bool
    {
        return $this->asSerializedString() === $target->asSerializedString();
    }

    /**
     * Creates a string representation of the values this DCATDistribution holds.
     *
     * @return string The string representation
     */
    public function asSerializedString(): string
    {
        $serializationValues = [];

        foreach (self::$PROPERTIES as $property) {
            $serializationValues[] = $this->{$property};
        }

        return serialize($serializationValues);
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
     * Getter for the distributionType property, may return null.
     *
     * @return null|DCATControlledVocabularyEntry The distributionType property
     */
    public function getDistributionType(): ?DCATControlledVocabularyEntry
    {
        return $this->distributionType ?: null;
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
     * Setter for the license property. Expects a DCATControlledVocabularyEntry of vocabulary
     * 'DONL:License'.
     *
     * @param DCATControlledVocabularyEntry $license The value to set
     *
     * @throws DCATException Thrown when the vocabulary is not 'DONL:License'
     */
    public function setLicense(DCATControlledVocabularyEntry $license): void
    {
        $vocabulary = 'DONL:License';

        if ($license->getControlledVocabulary() !== $vocabulary) {
            throw new DCATException(
                sprintf(DCATControlledVocabularyEntry::VOCABULARY_ERROR_FORMAT, $vocabulary)
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
     * Adds a value to the language property. Expects a DCATControlledVocabularyEntry of vocabulary
     * 'DONL:Language'.
     *
     * @param DCATControlledVocabularyEntry $language The value to add
     *
     * @throws DCATException Thrown when the vocabulary is not 'DONL:Language'
     */
    public function addLanguage(DCATControlledVocabularyEntry $language): void
    {
        $vocabulary = 'DONL:Language';

        if ($language->getControlledVocabulary() !== $vocabulary) {
            throw new DCATException(
                sprintf(DCATControlledVocabularyEntry::VOCABULARY_ERROR_FORMAT, $vocabulary)
            );
        }

        $this->language[] = $language;
    }

    /**
     * Setter for the metadataLanguage property. Expects a DCATControlledVocabularyEntry of
     * vocabulary 'DONL:Language'.
     *
     * @param DCATControlledVocabularyEntry $metadataLanguage The value to set
     *
     * @throws DCATException Thrown when the vocabulary is not 'DONL:Language'
     */
    public function setMetadataLanguage(DCATControlledVocabularyEntry $metadataLanguage): void
    {
        $vocabulary = 'DONL:Language';

        if ($metadataLanguage->getControlledVocabulary() !== $vocabulary) {
            throw new DCATException(
                sprintf(DCATControlledVocabularyEntry::VOCABULARY_ERROR_FORMAT, $vocabulary)
            );
        }

        $this->metadataLanguage = $metadataLanguage;
    }

    /**
     * Setter for the format property. Expects a DCATControlledVocabularyEntry of vocabulary
     * 'MDR:FiletypeNAL'.
     *
     * @param DCATControlledVocabularyEntry $format The value to set
     *
     * @throws DCATException Thrown when the vocabulary is not 'MDR:FiletypeNAL'
     */
    public function setFormat(DCATControlledVocabularyEntry $format): void
    {
        $vocabulary = 'MDR:FiletypeNAL';

        if ($format->getControlledVocabulary() !== $vocabulary) {
            throw new DCATException(
                sprintf(DCATControlledVocabularyEntry::VOCABULARY_ERROR_FORMAT, $vocabulary)
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
     * Setter for the status property. Expects a DCATControlledVocabularyEntry of vocabulary
     * 'ADMS:Distributiestatus'.
     *
     * @param DCATControlledVocabularyEntry $status The value to set
     *
     * @throws DCATException Thrown when the vocabulary is not 'ADMS:Distributiestatus'
     */
    public function setStatus(DCATControlledVocabularyEntry $status): void
    {
        $vocabulary = 'ADMS:Distributiestatus';

        if ($status->getControlledVocabulary() !== $vocabulary) {
            throw new DCATException(
                sprintf(DCATControlledVocabularyEntry::VOCABULARY_ERROR_FORMAT, $vocabulary)
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
     * Setter for the mediaType property. Expects a DCATControlledVocabularyEntry of vocabulary
     * 'IANA:Mediatypes'.
     *
     * @param DCATControlledVocabularyEntry $mediaType The value to set
     *
     * @throws DCATException Thrown when the vocabulary is not 'IANA:Mediatypes'
     */
    public function setMediaType(DCATControlledVocabularyEntry $mediaType): void
    {
        $vocabulary = 'IANA:Mediatypes';

        if ($mediaType->getControlledVocabulary() !== $vocabulary) {
            throw new DCATException(
                sprintf(DCATControlledVocabularyEntry::VOCABULARY_ERROR_FORMAT, $vocabulary)
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
     * Alias of addLinkedSchema.
     *
     * @param DCATURI $linkedSchema The value to add
     *
     * @see DCATDistribution::addLinkedSchema()
     */
    public function addLinkedSchemas(DCATURI $linkedSchema): void
    {
        $this->addLinkedSchema($linkedSchema);
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

    /**
     * Setter for the distributionType property. Expects a DCATControlledVocabularyEntry of
     * vocabulary 'DONL:DistributionType'.
     *
     * @param DCATControlledVocabularyEntry $distributionType The value to set
     *
     * @throws DCATException Thrown when the vocabulary is not 'DONL:DistributionType'
     */
    public function setDistributionType(DCATControlledVocabularyEntry $distributionType): void
    {
        $vocabulary = 'DONL:DistributionType';

        if ($distributionType->getControlledVocabulary() !== $vocabulary) {
            throw new DCATException(
                sprintf(DCATControlledVocabularyEntry::VOCABULARY_ERROR_FORMAT, $vocabulary)
            );
        }

        $this->distributionType = $distributionType;
    }
}
