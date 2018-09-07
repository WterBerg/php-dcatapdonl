<?php

namespace DCAT_AP_DONL\ComplexEntities;

use Serializable;
use DCAT_AP_DONL\DCATEntity;
use DCAT_AP_DONL\DCATProperty;
use DCAT_AP_DONL\DCATURI;
use DCAT_AP_DONL\DCATDateTime;
use DCAT_AP_DONL\DCATNumber;
use DCAT_AP_DONL\DCATControlledVocabularyEntry;
use DCAT_AP_DONL\DCATValidationResult;
use DCAT_AP_DONL\DCATException;


/**
 * Class Distribution
 * 
 * Represents the complex entity Distribution.
 * 
 * @package DCAT_AP_DONL\ComplexEntities
 */
class Distribution extends DCATComplexEntity implements Serializable {

    /** @var string[] */
    protected static $PROPERTIES = [
        'accessURL', 'license', 'title', 'description', 'language', 'metadataLanguage', 'format',
        'rights', 'status', 'releaseDate', 'modificationDate', 'byteSize', 'downloadURL',
        'mediaType', 'linkedSchema', 'checksum', 'documentation'
    ];

    /** @var string[] */
    protected static $REQUIRED_PROPERTIES = [
        'accessURL', 'license', 'title', 'description', 'language', 'format', 'metadataLanguage'
    ];

    /** @var DCATURI */
    protected $accessURL;

    /** @var DCATControlledVocabularyEntry */
    protected $license;

    /** @var DCATProperty */
    protected $title;

    /** @var DCATProperty */
    protected $description;

    /** @var DCATControlledVocabularyEntry[] */
    protected $language;

    /** @var DCATControlledVocabularyEntry */
    protected $metadataLanguage;

    /** @var DCATControlledVocabularyEntry */
    protected $format;

    /** @var DCATProperty */
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

    /** @var Checksum */
    protected $checksum;

    /** @var DCATURI[] */
    protected $documentation;

    /**
     * @inheritdoc
     */
    public function __construct()
    {
        parent::__construct('Distribution');

        foreach (self::$PROPERTIES as $property) {
            $this->$property = null;
        }

        $multivalued = ['downloadURL', 'language', 'linkedSchema', 'documentation'];

        foreach ($multivalued as $property) {
            $this->$property = [];
        }
    }

    /**
     * @inheritdoc
     */
    public function getData(): array
    {
        $data = [];

        foreach (self::$PROPERTIES as $property) {
            $prop = $this->$property;

            if ($prop == null) {
                continue;
            }

            if (is_array($prop)) {
                foreach ($prop as $value) {
                    /** @var DCATEntity $value */
                    $data[$property][] = $value->getData();
                }

                continue;
            }

            /** @var DCATEntity $prop */
            $data[$prop->getName()] = $prop->getData();
        }

        return $data;
    }

    /**
     * Determines and returns whether or not the Distribution is valid.
     *
     * A Distribution is considered valid when:
     * - All the properties in `Distribution::$REQUIRED_PROPERTIES` are not null
     * - All the present DCATEntities contained within Distribution pass their individual validation
     *
     * @see Distribution::$REQUIRED_PROPERTIES
     * @return DCATValidationResult The validation result of this Distribution
     */
    public function validate(): DCATValidationResult
    {
        $result = new DCATValidationResult();

        foreach (self::$PROPERTIES as $property) {
            $prop = $this->$property;

            if ($prop == null) {
                if (in_array($property, self::$REQUIRED_PROPERTIES)) {
                    $result->addMessage(
                        sprintf('%s: %s is missing', $this->getName(), $property)
                    );
                }

                continue;
            }

            if (is_array($prop)) {
                if (count($prop) == 0 && in_array($property, self::$REQUIRED_PROPERTIES)) {
                    $result->addMessage(
                        sprintf('%s: %s is missing', $this->getName(), $property)
                    );

                    continue;
                }

                foreach ($prop as $arrayElement) {
                    /** @var DCATEntity $arrayElement */
                    $messages = $arrayElement->validate()->getMessages();

                    for ($i = 0; $i < count($messages); $i++) {
                        $result->addMessage(
                            sprintf('%s: %s', $this->getName(), $messages[$i])
                        );
                    }
                }

                continue;
            }

            /** @var DCATEntity $prop */
            $messages = $prop->validate()->getMessages();
            for ($i = 0; $i < count($messages); $i++) {
                $result->addMessage(sprintf('%s: %s', $this->getName(), $messages[$i]));
            }
        }

        return $result;
    }

    /**
     * Compares itself to another Distribution object.
     *
     * @param Distribution $target The Distribution to compare against
     * @return bool Whether or not this Distribution is equal to the given Distribution
     */
    public function equalTo(Distribution $target): bool
    {
        return $this->serialize() == $target->serialize();
    }

    /**
     * @inheritdoc
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
     * @throws DCATException Always thrown
     */
    public function unserialize($serialized): void
    {
        throw new DCATException('Distribution::unserialize(string) is not implemented');
    }

    /**
     * Getter for the accessURL property, may return null.
     *
     * @return DCATURI|null The accessURL property
     */
    public function getAccessURL(): ?DCATURI
    {
        return $this->accessURL;
    }

    /**
     * Getter for the license property, may return null.
     *
     * @return DCATControlledVocabularyEntry|null The license property
     */
    public function getLicense(): ?DCATControlledVocabularyEntry
    {
        return $this->license;
    }

    /**
     * Getter for the title property, may return null.
     *
     * @return DCATProperty|null The title property
     */
    public function getTitle(): ?DCATProperty
    {
        return $this->title;
    }

    /**
     * Getter for the description property, may return null.
     *
     * @return DCATProperty|null The description property
     */
    public function getDescription(): ?DCATProperty
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
     * @return DCATControlledVocabularyEntry|null The metadataLanguage property
     */
    public function getMetadataLanguage(): ?DCATControlledVocabularyEntry
    {
        return $this->metadataLanguage;
    }

    /**
     * Getter for the format property, may return null.
     *
     * @return DCATControlledVocabularyEntry|null The format property
     */
    public function getFormat(): ?DCATControlledVocabularyEntry
    {
        return $this->format;
    }

    /**
     * Getter for the rights property, may return null.
     *
     * @return DCATProperty|null The rights property
     */
    public function getRights(): ?DCATProperty
    {
        return $this->rights;
    }

    /**
     * Getter for the status property, may return null.
     *
     * @return DCATControlledVocabularyEntry|null The status property
     */
    public function getStatus(): ?DCATControlledVocabularyEntry
    {
        return $this->status;
    }

    /**
     * Getter for the releaseDate property, may return null.
     *
     * @return DCATDateTime|null The releaseDate property
     */
    public function getReleaseDate(): ?DCATDateTime
    {
        return $this->releaseDate;
    }

    /**
     * Getter for the modificationDate property, may return null.
     *
     * @return DCATDateTime|null The modificationDate property
     */
    public function getModificationDate(): ?DCATDateTime
    {
        return $this->modificationDate;
    }

    /**
     * Getter for the byteSize property, may return null.
     *
     * @return DCATNumber|null The byteSize property
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
     * @return DCATControlledVocabularyEntry|null The mediaType property
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
     * @return Checksum|null The checksum property
     */
    public function getChecksum(): ?Checksum
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
     * @throws DCATException Thrown when the vocabulary is not 'Overheid:License'
     */
    public function setLicense(DCATControlledVocabularyEntry $license): void
    {
        if ($license->getControlledVocabulary() !== 'Overheid:License') {
            throw new DCATException(
                'Expected a DCATControlledVocabularyEntry of vocabulary Overheid:License'
            );
        }

        $this->license = $license;
    }

    /**
     * Setter for the title property.
     *
     * @param DCATProperty $title The value to set
     */
    public function setTitle(DCATProperty $title): void
    {
        $this->title = $title;
    }

    /**
     * Setter for the description property.
     *
     * @param DCATProperty $description The value to set
     */
    public function setDescription(DCATProperty $description): void
    {
        $this->description = $description;
    }

    /**
     * Adds a value to the language property. Expect a DCATControlledVocabularyEntry of vocabulary
     * 'DONL:Language'.
     *
     * @param DCATControlledVocabularyEntry $language The value to add
     * @throws DCATException Thrown when the vocabulary is not 'DONL:Language'
     */
    public function addLanguage(DCATControlledVocabularyEntry $language): void
    {
        if ($language->getControlledVocabulary() !== 'DONL:Language') {
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
     * @throws DCATException Thrown when the vocabulary is not 'DONL:Language'
     */
    public function setMetadataLanguage(DCATControlledVocabularyEntry $metadataLanguage): void
    {
        if ($metadataLanguage->getControlledVocabulary() !== 'DONL:Language') {
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
     * @throws DCATException Thrown when the vocabulary is not 'MDR:FiletypeNAL'
     */
    public function setFormat(DCATControlledVocabularyEntry $format): void
    {
        if ($format->getControlledVocabulary() !== 'MDR:FiletypeNAL') {
            throw new DCATException(
                'Expected a DCATControlledVocabularyEntry of vocabulary MDR:FiletypeNAL'
            );
        }

        $this->format = $format;
    }

    /**
     * Setter for the rights property.
     *
     * @param DCATProperty $rights The value to set
     */
    public function setRights(DCATProperty $rights): void
    {
        $this->rights = $rights;
    }

    /**
     * Setter for the status property. Expect a DCATControlledVocabularyEntry of vocabulary
     * 'ADMS:Distributiestatus'.
     *
     * @param DCATControlledVocabularyEntry $status The value to set
     * @throws DCATException Thrown when the vocabulary is not 'ADMS:Distributiestatus'
     */
    public function setStatus(DCATControlledVocabularyEntry $status): void
    {
        if ($status->getControlledVocabulary() !== 'ADMS:Distributiestatus') {
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
     * @throws DCATException Thrown when the vocabulary is not 'IANA:Mediatypes'
     */
    public function setMediaType(DCATControlledVocabularyEntry $mediaType): void
    {
        if ($mediaType->getControlledVocabulary() !== 'IANA:Mediatypes') {
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
     * @param Checksum $checksum The value to set
     */
    public function setChecksum(Checksum $checksum): void
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
