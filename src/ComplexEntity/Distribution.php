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
        'accessURL', 'license', 'title', 'description', 'language',
        'metadataLanguage', 'format', 'rights', 'status', 'releaseDate',
        'modificationDate', 'byteSize', 'downloadURL', 'mediaType',
        'linkedSchema', 'checksum', 'documentation'
    ];

    /** @var string[] */
    protected static $REQUIRED_PROPERTIES = [
        'accessURL', 'license', 'title', 'description', 'language', 'format',
        'metadataLanguage'
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
    }

    /**
     * @inheritdoc
     */
    public function getData(): array
    {
        $data = [];

        foreach (self::$PROPERTIES as $property) {
            if ($this->$property == null) {
                continue;
            }

            if ($property === 'license') {
                $data['license'] = ['id' => $this->license->getData()];
                continue;
            }

            if (is_array($this->$property)) {
                foreach ($this->$property as $value) {
                    /** @var DCATEntity $value */
                    $data[$property][] = $value->getData();
                }
                continue;
            }

            $data[$this->$property->getName()] = $this->$property->getData();
        }

        return $data;
    }

    /**
     * Determines and returns whether or not the Distribution is valid.
     *
     * A Distribution is considered valid when:
     * - All the properties in `Distribution::$REQUIRED_PROPERTIES` are not null
     * - All the present DCATEntities contained within Distribution pass their
     * individual validation
     *
     * @see Distribution::$REQUIRED_PROPERTIES
     * @return DCATValidationResult The validation result of this Distribution
     */
    public function validate(): DCATValidationResult
    {
        $result = new DCATValidationResult();

        foreach (self::$PROPERTIES as $property) {
            if ($this->$property == null) {
                if (in_array($property, self::$REQUIRED_PROPERTIES)) {
                    $result->addMessage(
                        sprintf(
                            '%s: %s is missing',
                            $this->getName(), $property
                        )
                    );
                }
                continue;
            }

            if (is_array($this->$property)) {
                if (count($this->$property) == 0 &&
                    in_array($property, self::$REQUIRED_PROPERTIES)) {
                    $result->addMessage(
                        sprintf(
                            '%s: %s is missing',
                            $this->getName(), $property
                        )
                    );
                    continue;
                }

                foreach ($this->$property as $arrayElement) {
                    /** @var DCATEntity $arrayElement */
                    $messages = $arrayElement->validate()->getMessages();

                    for ($i = 0; $i < count($messages); $i++) {
                        $result->addMessage(
                            sprintf(
                                '%s: %s', $this->getName(), $messages[$i]
                            )
                        );
                    }
                }
                continue;
            }

            $messages = $this->$property->validate()->getMessages();
            for ($i = 0; $i < count($messages); $i++) {
                $result->addMessage($this->getName() . ': ' . $messages[$i]);
            }
        }

        return $result;
    }

    /**
     * Compares itself to another Distribution object.
     *
     * @param Distribution $target The Distribution to compare against
     * @return bool Whether or not this Distribution is equal to the given
     * Distribution
     */
    public function equalTo(Distribution $target): bool
    {
        return $this->serialize() == $target->serialize();
    }

    /**
     * @return DCATURI
     */
    public function getAccessURL(): DCATURI
    {
        return $this->accessURL;
    }

    /**
     * @return DCATControlledVocabularyEntry
     */
    public function getLicense(): DCATControlledVocabularyEntry
    {
        return $this->license;
    }

    /**
     * @return DCATProperty
     */
    public function getTitle(): DCATProperty
    {
        return $this->title;
    }

    /**
     * @return DCATProperty
     */
    public function getDescription(): DCATProperty
    {
        return $this->description;
    }

    /**
     * @return array
     */
    public function getLanguages(): array
    {
        return $this->language;
    }

    /**
     * @return DCATControlledVocabularyEntry
     */
    public function getMetadataLanguage(): DCATControlledVocabularyEntry
    {
        return $this->metadataLanguage;
    }

    /**
     * @return DCATControlledVocabularyEntry
     */
    public function getFormat(): DCATControlledVocabularyEntry
    {
        return $this->format;
    }

    /**
     * @return DCATProperty
     */
    public function getRights(): DCATProperty
    {
        return $this->rights;
    }

    /**
     * @return DCATControlledVocabularyEntry
     */
    public function getStatus(): DCATControlledVocabularyEntry
    {
        return $this->status;
    }

    /**
     * @return DCATDateTime
     */
    public function getReleaseDate(): DCATDateTime
    {
        return $this->releaseDate;
    }

    /**
     * @return DCATDateTime
     */
    public function getModificationDate(): DCATDateTime
    {
        return $this->modificationDate;
    }

    /**
     * @return DCATNumber
     */
    public function getByteSize(): DCATNumber
    {
        return $this->byteSize;
    }

    /**
     * @return array
     */
    public function getDownloadURLs(): array
    {
        return $this->downloadURL;
    }

    /**
     * @return null|DCATControlledVocabularyEntry
     */
    public function getMediaType(): ?DCATControlledVocabularyEntry
    {
        return $this->mediaType ?: null;
    }

    /**
     * @return array
     */
    public function getLinkedSchemas(): array
    {
        return $this->linkedSchema;
    }

    /**
     * @return Checksum
     */
    public function getChecksum(): Checksum
    {
        return $this->checksum;
    }

    /**
     * @return array
     */
    public function getDocumentations(): array
    {
        return $this->documentation;
    }

    /**
     * @param DCATURI $accessURL
     */
    public function setAccessURL(DCATURI $accessURL): void
    {
        $this->accessURL = $accessURL;
    }

    /**
     * @param DCATControlledVocabularyEntry $license
     * @throws DCATException
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
     * @param DCATProperty $title
     */
    public function setTitle(DCATProperty $title): void
    {
        $this->title = $title;
    }

    /**
     * @param DCATProperty $description
     */
    public function setDescription(DCATProperty $description): void
    {
        $this->description = $description;
    }

    /**
     * @param DCATControlledVocabularyEntry $language
     * @throws DCATException
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
     * @param DCATControlledVocabularyEntry $metadataLanguage
     * @throws DCATException
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
     * @param DCATControlledVocabularyEntry $format
     * @throws DCATException
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
     * @param DCATProperty $rights
     */
    public function setRights(DCATProperty $rights): void
    {
        $this->rights = $rights;
    }

    /**
     * @param DCATControlledVocabularyEntry $status
     * @throws DCATException
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
     * @param DCATDateTime $releaseDate
     */
    public function setReleaseDate(DCATDateTime $releaseDate): void
    {
        $this->releaseDate = $releaseDate;
    }

    /**
     * @param DCATDateTime $modificationDate
     */
    public function setModificationDate(DCATDateTime $modificationDate): void
    {
        $this->modificationDate = $modificationDate;
    }

    /**
     * @param DCATNumber $byteSize
     */
    public function setByteSize(DCATNumber $byteSize): void
    {
        $this->byteSize = $byteSize;
    }

    /**
     * @param DCATURI $downloadURL
     */
    public function addDownloadURL(DCATURI $downloadURL): void
    {
        $this->downloadURL[] = $downloadURL;
    }

    /**
     * @param DCATControlledVocabularyEntry $mediaType
     * @throws DCATException
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
     * @param DCATProperty $linkedSchema
     */
    public function addLinkedSchema(DCATProperty $linkedSchema): void
    {
        $this->linkedSchema[] = $linkedSchema;
    }

    /**
     * @param Checksum $checksum
     */
    public function setChecksum(Checksum $checksum): void
    {
        $this->checksum = $checksum;
    }

    /**
     * @param DCATProperty $documentation
     */
    public function addDocumentation(DCATProperty $documentation): void
    {
        $this->documentation[] = $documentation;
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

        return serialize([$serializationValues]);
    }

    /**
     * This method is **NOT** implemented.
     *
     * @param string $serialized Ignored
     * @throws DCATException
     */
    public function unserialize($serialized): void
    {
        throw new DCATException(
            'Distribution::unserialize(string) is not implemented.'
        );
    }

}
