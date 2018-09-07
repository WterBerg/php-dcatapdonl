<?php

namespace DCAT_AP_DONL\ComplexEntities;

use DCAT_AP_DONL\DCATEntity;
use DCAT_AP_DONL\DCATProperty;
use DCAT_AP_DONL\DCATURI;
use DCAT_AP_DONL\DCATDateTime;
use DCAT_AP_DONL\DCATControlledVocabularyEntry;
use DCAT_AP_DONL\DCATValidationResult;
use DCAT_AP_DONL\DCATException;


/**
 * Class Dataset
 * 
 * Represents the complex entity Dataset.
 * 
 * @package DCAT_AP_DONL\ComplexEntities
 */
class Dataset extends DCATComplexEntity {

    private static $PROPERTIES = [
        'identifier', 'title', 'description', 'keyword', 'license', 'metadataLanguage', 'language',
        'theme', 'modificationDate', 'authority', 'publisher', 'contactPoint', 'accessRights',
        'datasetStatus', 'landingPage', 'spatial', 'temporal', 'conformsTo',
        'alternativeIdentifier', 'relatedResource', 'source', 'hasVersion', 'isVersionOf',
        'releaseDate', 'version', 'versionNotes', 'legalFoundation', 'datePlanned', 'documentation',
        'frequency', 'provenance', 'sample', 'sourceCatalog', 'distribution'
    ];

    private static $REQUIRED_PROPERTIES = [
        'identifier', 'title', 'description', 'metadataLanguage', 'language', 'license',
        'modificationDate', 'distribution', 'authority', 'publisher', 'contactPoint', 'theme'
    ];

    /** @var DCATURI */
    private $identifier;

    /** @var DCATProperty */
    private $title;

    /** @var DCATProperty */
    private $description;

    /** @var DCATProperty[] */
    private $keyword;

    /** @var DCATControlledVocabularyEntry */
    private $license;

    /** @var DCATControlledVocabularyEntry */
    private $metadataLanguage;

    /** @var DCATControlledVocabularyEntry[] */
    private $language;

    /** @var DCATControlledVocabularyEntry[] */
    private $theme;

    /** @var DCATDateTime */
    private $modificationDate;

    /** @var DCATControlledVocabularyEntry */
    private $authority;

    /** @var DCATControlledVocabularyEntry */
    private $publisher;

    /** @var ContactPoint */
    private $contactPoint;

    /** @var DCATControlledVocabularyEntry */
    private $accessRights;

    /** @var DCATControlledVocabularyEntry */
    private $datasetStatus;

    /** @var DCATURI */
    private $landingPage;

    /** @var Spatial[] */
    private $spatial;

    /** @var Temporal */
    private $temporal;

    /** @var DCATURI[] */
    private $conformsTo;

    /** @var DCATURI[] */
    private $alternativeIdentifier;

    /** @var DCATURI[] */
    private $relatedResource;

    /** @var DCATURI[] */
    private $source;

    /** @var DCATURI[] */
    private $hasVersion;

    /** @var DCATURI[] */
    private $isVersionOf;

    /** @var DCATDateTime */
    private $releaseDate;

    /** @var DCATProperty */
    private $version;

    /** @var DCATProperty[] */
    private $versionNotes;

    /** @var LegalFoundation */
    private $legalFoundation;

    /** @var DCATDateTime */
    private $datePlanned;

    /** @var DCATURI[] */
    private $documentation;

    /** @var DCATControlledVocabularyEntry */
    private $frequency;

    /** @var DCATURI[] */
    private $provenance;

    /** @var DCATURI[] */
    private $sample;

    /** @var DCATControlledVocabularyEntry */
    private $sourceCatalog;

    /** @var Distribution[] */
    private $distribution;

    /**
     * @inheritdoc
     */
    public function __construct()
    {
        parent::__construct('Dataset');

        foreach (self::$PROPERTIES as $property) {
            $this->$property = null;
        }

        $multivalued = [
            'conformsTo' => 'conforms_to',
            'alternativeIdentifier' => 'alternate_identifier',
            'source' => 'source',
            'hasVersion' => 'has_version',
            'isVersionOf' => 'is_version_of',
            'versionNotes' => 'version_notes',
            'documentation' => 'documentation',
            'provenance' => 'provenance',
            'sample' => 'sample',
            'language' => 'language',
            'theme' => 'theme'
        ];

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
        $simple = [
            'identifier' => 'identifier',
            'title' => 'title',
            'metadataLanguage' => 'metadata_language',
            'modificationDate' => 'modified',
            'authority' => 'authority',
            'publisher' => 'publisher',
            'accessRights' => 'access_rights',
            'datasetStatus' => 'dataset_status',
            'landingPage' => 'url',
            'releaseDate' => 'release_date',
            'version' => 'version',
            'datePlanned' => 'date_planned',
            'sourceCatalog' => 'source_catalog',
            'frequency' => 'frequency',
            'description' => 'notes'
        ];
        $array = [
            'conformsTo' => 'conforms_to',
            'alternativeIdentifier' => 'alternate_identifier',
            'source' => 'source',
            'hasVersion' => 'has_version',
            'isVersionOf' => 'is_version_of',
            'versionNotes' => 'version_notes',
            'documentation' => 'documentation',
            'provenance' => 'provenance',
            'sample' => 'sample',
            'language' => 'language',
            'theme' => 'theme'
        ];

        foreach ($simple as $propertyKey => $propertyValue) {
            if (isset($this->$propertyKey)) {
                $data[$propertyValue] = $this->$propertyKey->getData();
            }
        }

        foreach ($array as $propertyKey => $propertyValue) {
            if (isset($this->$propertyKey)) {
                foreach ($this->$propertyKey as $element) {
                    /** @var DCATProperty $element */
                    $data[$propertyValue][] = $element->getData();
                }

                if (isset($data[$propertyValue])) {
                    $data[$propertyValue] = array_values(array_unique($data[$propertyValue]));
                }
            }
        }

        if (isset($this->keyword)) {
            foreach ($this->keyword as $keyword) {
                /** @var DCATProperty $keyword */
                $data['tags'][] = ['name' => $keyword->getData()];
            }
        }

        if (isset($this->license)) {
            $data['license'] = ['id' => $this->license->getData()];
        }

        $complex = ['contactPoint', 'legalFoundation', 'temporal'];
        foreach ($complex as $property) {
            if (isset($this->$property)) {
                $data = array_merge($data, $this->$property->getData());
            }
        }

        if (isset($this->spatial)) {
            $data['spatial_scheme'] = [];
            $data['spatial_value'] = [];

            foreach ($this->spatial as $spatial) {
                /** @var Spatial $spatial */
                $spatialData = $spatial->getData();

                if (isset($spatialData['spatial_scheme'])) {
                    $data['spatial_scheme'][] = $spatialData['spatial_scheme'];
                }

                if (isset($spatialData['spatial_value'])) {
                    $data['spatial_value'][] = $spatialData['spatial_value'];
                }
            }

            $data['spatial_value'] = array_unique($data['spatial_value']);
        }

        if (isset($this->distribution) && count($this->distribution) > 0) {
            foreach ($this->distribution as $distribution) {
                /** @var Distribution $distribution */
                $data['resources'][] = $distribution->getData();
            }
        }

        return $data;
    }

    /**
     * Determines and returns whether or not the Dataset is valid.
     *
     * A Dataset is considered valid when:
     * - All the properties in `Dataset::$REQUIRED_PROPERTIES` are not null
     * - All the present DCATEntities contained within Dataset pass their individual validation
     *
     * @see Dataset::$REQUIRED_PROPERTIES
     * @return DCATValidationResult
     */
    public function validate(): DCATValidationResult
    {
        $result = new DCATValidationResult();

        foreach (self::$PROPERTIES as $property) {
            if ($this->$property == null) {
                if (in_array($property, self::$REQUIRED_PROPERTIES)) {
                    $result->addMessage($this->getName() . ': ' . $property . ' is required');
                }
                continue;
            }

            if (is_array($this->$property)) {
                if (count($this->$property) == 0 && in_array($property, self::$REQUIRED_PROPERTIES)) {
                    $result->addMessage($this->getName() . ': ' . $property . ' is required');
                    continue;
                }

                if ($property === 'distribution') {
                    continue;
                }

                foreach ($this->$property as $arrayElement) {
                    /** @var DCATEntity $arrayElement */
                    $messages = $arrayElement->validate()->getMessages();

                    for ($i = 0; $i < count($messages); $i++) {
                        $result->addMessage($this->getName() . ': ' . $messages[$i]);
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
     * @inheritdoc
     */
    public function stripInvalidOptionalProperties(): void
    {
        foreach (self::$PROPERTIES as $property) {
            if (!isset($this->$property)) {
                continue;
            }

            if (in_array($property, self::$REQUIRED_PROPERTIES)) {
                continue;
            }

            if (is_array($this->$property)) {
                for ($i = 0; $i < count($this->$property); $i++) {
                    if ($this->$property[$i] instanceof DCATComplexEntity) {
                        $this->$property[$i]->stripInvalidOptionalProperties();
                    }

                    if (!$this->$property[$i]->validate()->validated()) {
                        unset($this->$property[$i]);
                    }

                    $this->$property = array_values($this->$property);
                }

                continue;
            }

            if ($this->$property instanceof DCATComplexEntity) {
                $this->$property->stripInvalidOptionalProperties();
            }

            if (!$this->$property->validate()->validated()) {
                $this->$property = null;
            }
        }
    }

    /**
     * @return DCATURI
     */
    public function getIdentifier(): ?DCATURI
    {
        return $this->identifier;
    }

    /**
     * @return DCATProperty
     */
    public function getTitle(): ?DCATProperty
    {
        return $this->title;
    }

    /**
     * @return DCATProperty
     */
    public function getDescription(): ?DCATProperty
    {
        return $this->description;
    }

    /**
     * @return array
     */
    public function getKeywords(): ?array
    {
        return $this->keyword;
    }

    /**
     * @return DCATControlledVocabularyEntry
     */
    public function getLicense(): ?DCATControlledVocabularyEntry
    {
        return $this->license;
    }

    /**
     * @return DCATControlledVocabularyEntry
     */
    public function getMetadataLanguage(): ?DCATControlledVocabularyEntry
    {
        return $this->metadataLanguage;
    }

    /**
     * @return array
     */
    public function getLanguages(): ?array
    {
        return $this->language;
    }

    /**
     * @return array
     */
    public function getThemes(): ?array
    {
        return $this->theme;
    }

    /**
     * @return DCATDateTime
     */
    public function getModificationDate(): ?DCATDateTime
    {
        return $this->modificationDate;
    }

    /**
     * @return DCATControlledVocabularyEntry
     */
    public function getAuthority(): ?DCATControlledVocabularyEntry
    {
        return $this->authority;
    }

    /**
     * @return DCATControlledVocabularyEntry
     */
    public function getPublisher(): ?DCATControlledVocabularyEntry
    {
        return $this->publisher;
    }

    /**
     * @return ContactPoint
     */
    public function getContactPoint(): ?ContactPoint
    {
        return $this->contactPoint;
    }

    /**
     * @return DCATControlledVocabularyEntry
     */
    public function getAccessRights(): ?DCATControlledVocabularyEntry
    {
        return $this->accessRights;
    }

    /**
     * @return DCATControlledVocabularyEntry
     */
    public function getDatasetStatus(): ?DCATControlledVocabularyEntry
    {
        return $this->datasetStatus;
    }

    /**
     * @return DCATURI
     */
    public function getLandingPage(): ?DCATURI
    {
        return $this->landingPage;
    }

    /**
     * @return array
     */
    public function getSpatials(): ?array
    {
        return $this->spatial;
    }

    /**
     * @return Temporal
     */
    public function getTemporal(): ?Temporal
    {
        return $this->temporal;
    }

    /**
     * @return array
     */
    public function getConformsTos(): ?array
    {
        return $this->conformsTo;
    }

    /**
     * @return array
     */
    public function getAlternativeIdentifiers(): ?array
    {
        return $this->alternativeIdentifier;
    }

    /**
     * @return array
     */
    public function getRelatedResources(): ?array
    {
        return $this->relatedResource;
    }

    /**
     * @return array
     */
    public function getSources(): ?array
    {
        return $this->source;
    }

    /**
     * @return array
     */
    public function getHasVersions(): ?array
    {
        return $this->hasVersion;
    }

    /**
     * @return array
     */
    public function getIsVersionOfs(): ?array
    {
        return $this->isVersionOf;
    }

    /**
     * @return DCATDateTime
     */
    public function getReleaseDate(): ?DCATDateTime
    {
        return $this->releaseDate;
    }

    /**
     * @return DCATProperty
     */
    public function getVersion(): ?DCATProperty
    {
        return $this->version;
    }

    /**
     * @return array
     */
    public function getVersionNotes(): ?array
    {
        return $this->versionNotes;
    }

    /**
     * @return LegalFoundation
     */
    public function getLegalFoundation(): ?LegalFoundation
    {
        return $this->legalFoundation;
    }

    /**
     * @return DCATDateTime
     */
    public function getDatePlanned(): ?DCATDateTime
    {
        return $this->datePlanned;
    }

    /**
     * @return array
     */
    public function getDocumentations(): ?array
    {
        return $this->documentation;
    }

    /**
     * @return DCATControlledVocabularyEntry
     */
    public function getFrequency(): ?DCATControlledVocabularyEntry
    {
        return $this->frequency;
    }

    /**
     * @return array
     */
    public function getProvenances(): ?array
    {
        return $this->provenance;
    }

    /**
     * @return array
     */
    public function getSamples(): ?array
    {
        return $this->sample;
    }

    /**
     * @return DCATControlledVocabularyEntry
     */
    public function getSourceCatalog(): ?DCATControlledVocabularyEntry
    {
        return $this->sourceCatalog;
    }

    /**
     * @return array
     */
    public function getDistributions(): ?array
    {
        return $this->distribution;
    }

    /**
     * @param DCATURI $identifier
     */
    public function setIdentifier(DCATURI $identifier): void
    {
        $this->identifier = $identifier;
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
     * @param DCATProperty $keyword
     */
    public function addKeyword(DCATProperty $keyword): void
    {
        $this->keyword[] = $keyword;
    }

    /**
     * @param DCATControlledVocabularyEntry $license
     * @throws DCATException
     */
    public function setLicense(DCATControlledVocabularyEntry $license): void
    {
        if ($license->getControlledVocabulary() !== 'Overheid:License') {
            throw new DCATException('Expected a DCATControlledVocabularyEntry of vocabulary Overheid:License');
        }

        $this->license = $license;
    }

    /**
     * @param DCATControlledVocabularyEntry $metadataLanguage
     * @throws DCATException
     */
    public function setMetadataLanguage(DCATControlledVocabularyEntry $metadataLanguage): void
    {
        if ($metadataLanguage->getControlledVocabulary() !== 'DONL:Language') {
            throw new DCATException('Expected a DCATControlledVocabularyEntry of vocabulary DONL:Language');
        }

        $this->metadataLanguage = $metadataLanguage;
    }

    /**
     * @param DCATControlledVocabularyEntry $language
     * @throws DCATException
     */
    public function addLanguage(DCATControlledVocabularyEntry $language): void
    {
        if ($language->getControlledVocabulary() !== 'DONL:Language') {
            throw new DCATException('Expected a DCATControlledVocabularyEntry of vocabulary DONL:Language');
        }

        $this->language[] = $language;
    }

    /**
     * @param DCATControlledVocabularyEntry $theme
     * @throws DCATException
     */
    public function addTheme(DCATControlledVocabularyEntry $theme): void
    {
        if ($theme->getControlledVocabulary() !== 'Overheid:Taxonomiebeleidsagenda') {
            throw new DCATException('Expected a DCATControlledVocabularyEntry of vocabulary Overheid:Taxonomiebeleidsagenda');
        }

        $this->theme[] = $theme;
    }

    /**
     * @param DCATDateTime $modificationDate
     */
    public function setModificationDate(DCATDateTime $modificationDate): void
    {
        $this->modificationDate = $modificationDate;
    }

    /**
     * @param DCATControlledVocabularyEntry $authority
     * @throws DCATException
     */
    public function setAuthority(DCATControlledVocabularyEntry $authority): void
    {
        if ($authority->getControlledVocabulary() !== 'DONL:Organization') {
            throw new DCATException('Expected a DCATControlledVocabularyEntry of vocabulary DONL:Organization');
        }

        $this->authority = $authority;
    }

    /**
     * @param DCATControlledVocabularyEntry $publisher
     * @throws DCATException
     */
    public function setPublisher(DCATControlledVocabularyEntry $publisher): void
    {
        if ($publisher->getControlledVocabulary() !== 'DONL:Organization') {
            throw new DCATException('Expected a DCATControlledVocabularyEntry of vocabulary DONL:Organization');
        }

        $this->publisher = $publisher;
    }

    /**
     * @param ContactPoint $contactPoint
     */
    public function setContactPoint(ContactPoint $contactPoint): void
    {
        $this->contactPoint = $contactPoint;
    }

    /**
     * @param DCATControlledVocabularyEntry $accessRights
     * @throws DCATException
     */
    public function setAccessRights(DCATControlledVocabularyEntry $accessRights): void
    {
        if ($accessRights->getControlledVocabulary() !== 'Overheid:Openbaarheidsniveau') {
            throw new DCATException('Expected a DCATControlledVocabularyEntry of vocabulary Overheid:Openbaarheidsniveau');
        }

        $this->accessRights = $accessRights;
    }

    /**
     * @param DCATControlledVocabularyEntry $datasetStatus
     * @throws DCATException
     */
    public function setDatasetStatus(DCATControlledVocabularyEntry $datasetStatus): void
    {
        if ($datasetStatus->getControlledVocabulary() !== 'Overheid:DatasetStatus') {
            throw new DCATException('Expected a DCATControlledVocabularyEntry of vocabulary Overheid:DatasetStatus');
        }

        $this->datasetStatus = $datasetStatus;
    }

    /**
     * @param DCATURI $landingPage
     */
    public function setLandingPage(DCATURI $landingPage): void
    {
        $this->landingPage = $landingPage;
    }

    /**
     * @param Spatial $spatial
     */
    public function addSpatial(Spatial $spatial): void
    {
        $this->spatial[] = $spatial;
    }

    /**
     * @param Temporal $temporal
     */
    public function setTemporal(Temporal $temporal): void
    {
        $this->temporal = $temporal;
    }

    /**
     * @param DCATProperty $conformsTo
     */
    public function addConformsTo(DCATProperty $conformsTo): void
    {
        $this->conformsTo[] = $conformsTo;
    }

    /**
     * @param DCATProperty $alternativeIdentifier
     */
    public function addAlternativeIdentifier(DCATProperty $alternativeIdentifier): void
    {
        $this->alternativeIdentifier[] = $alternativeIdentifier;
    }

    /**
     * @param DCATProperty $relatedResource
     */
    public function addRelatedResource(DCATProperty $relatedResource): void
    {
        $this->relatedResource[] = $relatedResource;
    }

    /**
     * @param DCATProperty $source
     */
    public function addSource(DCATProperty $source): void
    {
        $this->source[] = $source;
    }

    /**
     * @param DCATProperty $hasVersion
     */
    public function addHasVersion(DCATProperty $hasVersion): void
    {
        $this->hasVersion[] = $hasVersion;
    }

    /**
     * @param DCATProperty $isVersionOf
     */
    public function addIsVersionOf(DCATProperty $isVersionOf): void
    {
        $this->isVersionOf[] = $isVersionOf;
    }

    /**
     * @param DCATDateTime $releaseDate
     */
    public function setReleaseDate(DCATDateTime $releaseDate): void
    {
        $this->releaseDate = $releaseDate;
    }

    /**
     * @param DCATProperty $version
     */
    public function setVersion(DCATProperty $version): void
    {
        $this->version = $version;
    }

    /**
     * @param DCATProperty $versionNotes
     */
    public function addVersionNotes(DCATProperty $versionNotes): void
    {
        $this->versionNotes[] = $versionNotes;
    }

    /**
     * @param LegalFoundation $legalFoundation
     */
    public function setLegalFoundation(LegalFoundation $legalFoundation): void
    {
        $this->legalFoundation = $legalFoundation;
    }

    /**
     * @param DCATDateTime $datePlanned
     */
    public function setDatePlanned(DCATDateTime $datePlanned): void
    {
        $this->datePlanned = $datePlanned;
    }

    /**
     * @param DCATProperty $documentation
     */
    public function addDocumentation(DCATProperty $documentation): void
    {
        $this->documentation[] = $documentation;
    }

    /**
     * @param DCATControlledVocabularyEntry $frequency
     * @throws DCATException
     */
    public function setFrequency(DCATControlledVocabularyEntry $frequency): void
    {
        if ($frequency->getControlledVocabulary() !== 'Overheid:Frequency') {
            throw new DCATException('Expected a DCATControlledVocabularyEntry of vocabulary Overheid:Frequency');
        }

        $this->frequency = $frequency;
    }

    /**
     * @param DCATProperty $provenance
     */
    public function addProvenance(DCATProperty $provenance): void
    {
        $this->provenance[] = $provenance;
    }

    /**
     * @param DCATProperty $sample
     */
    public function addSample(DCATProperty $sample): void
    {
        $this->sample[] = $sample;
    }

    /**
     * @param DCATControlledVocabularyEntry $sourceCatalog
     * @throws DCATException
     */
    public function setSourceCatalog(DCATControlledVocabularyEntry $sourceCatalog): void
    {
        if ($sourceCatalog->getControlledVocabulary() !== 'DONL:Catalogs') {
            throw new DCATException('Expected a DCATControlledVocabularyEntry of vocabulary DONL:Catalogs');
        }

        $this->sourceCatalog = $sourceCatalog;
    }

    /**
     * @param Distribution $distribution
     */
    public function addDistribution(Distribution $distribution): void
    {
        $this->distribution[] = $distribution;
    }

    /**
     * @param array $distributions
     */
    public function setDistributions(array $distributions): void
    {
        $this->distribution = $distributions;
    }

}
