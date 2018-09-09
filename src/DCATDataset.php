<?php

namespace DCAT_AP_DONL;


/**
 * Class DCATDataset
 * 
 * Represents the complex entity DCATDataset.
 * 
 * @package DCAT_AP_DONL
 */
class DCATDataset extends DCATComplexEntity {

    /** @var string[] */
    protected static $PROPERTIES = [
        'identifier', 'title', 'description', 'keyword', 'license', 'metadataLanguage', 'language',
        'theme', 'modificationDate', 'authority', 'publisher', 'contactPoint', 'accessRights',
        'datasetStatus', 'landingPage', 'spatial', 'temporal', 'conformsTo',
        'alternativeIdentifier', 'relatedResource', 'source', 'hasVersion', 'isVersionOf',
        'releaseDate', 'version', 'versionNotes', 'legalFoundation', 'datePlanned', 'documentation',
        'frequency', 'provenance', 'sample', 'sourceCatalog', 'distribution'
    ];

    /** @var string[] */
    protected static $REQUIRED_PROPERTIES = [
        'identifier', 'title', 'description', 'metadataLanguage', 'language', 'license',
        'modificationDate', 'distribution', 'authority', 'publisher', 'contactPoint', 'theme'
    ];

    /** @var DCATURI */
    protected $identifier;

    /** @var DCATProperty */
    protected $title;

    /** @var DCATProperty */
    protected $description;

    /** @var DCATProperty[] */
    protected $keyword;

    /** @var DCATControlledVocabularyEntry */
    protected $license;

    /** @var DCATControlledVocabularyEntry */
    protected $metadataLanguage;

    /** @var DCATControlledVocabularyEntry[] */
    protected $language;

    /** @var DCATControlledVocabularyEntry[] */
    protected $theme;

    /** @var DCATDateTime */
    protected $modificationDate;

    /** @var DCATControlledVocabularyEntry */
    protected $authority;

    /** @var DCATControlledVocabularyEntry */
    protected $publisher;

    /** @var DCATContactPoint */
    protected $contactPoint;

    /** @var DCATControlledVocabularyEntry */
    protected $accessRights;

    /** @var DCATControlledVocabularyEntry */
    protected $datasetStatus;

    /** @var DCATURI */
    protected $landingPage;

    /** @var DCATSpatial[] */
    protected $spatial;

    /** @var DCATTemporal */
    protected $temporal;

    /** @var DCATURI[] */
    protected $conformsTo;

    /** @var DCATURI[] */
    protected $alternativeIdentifier;

    /** @var DCATURI[] */
    protected $relatedResource;

    /** @var DCATURI[] */
    protected $source;

    /** @var DCATURI[] */
    protected $hasVersion;

    /** @var DCATURI[] */
    protected $isVersionOf;

    /** @var DCATDateTime */
    protected $releaseDate;

    /** @var DCATProperty */
    protected $version;

    /** @var DCATProperty[] */
    protected $versionNotes;

    /** @var DCATLegalFoundation */
    protected $legalFoundation;

    /** @var DCATDateTime */
    protected $datePlanned;

    /** @var DCATURI[] */
    protected $documentation;

    /** @var DCATControlledVocabularyEntry */
    protected $frequency;

    /** @var DCATURI[] */
    protected $provenance;

    /** @var DCATURI[] */
    protected $sample;

    /** @var DCATControlledVocabularyEntry */
    protected $sourceCatalog;

    /** @var DCATDistribution[] */
    protected $distribution;

    /**
     * DCATDataset constructor.
     */
    public function __construct()
    {
        parent::__construct('Dataset', self::$PROPERTIES, self::$REQUIRED_PROPERTIES);

        $multivalued = [
            'conformsTo', 'alternativeIdentifier', 'source', 'hasVersion', 'isVersionOf',
            'versionNotes', 'documentation', 'provenance', 'sample', 'language', 'theme'
        ];

        foreach ($multivalued as $property) {
            $this->$property = [];
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
     * @return DCATContactPoint
     */
    public function getContactPoint(): ?DCATContactPoint
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
     * @return DCATTemporal
     */
    public function getTemporal(): ?DCATTemporal
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
     * @return DCATLegalFoundation
     */
    public function getLegalFoundation(): ?DCATLegalFoundation
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
     * @param DCATContactPoint $contactPoint
     */
    public function setContactPoint(DCATContactPoint $contactPoint): void
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
     * @param DCATSpatial $spatial
     */
    public function addSpatial(DCATSpatial $spatial): void
    {
        $this->spatial[] = $spatial;
    }

    /**
     * @param DCATTemporal $temporal
     */
    public function setTemporal(DCATTemporal $temporal): void
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
     * @param DCATLegalFoundation $legalFoundation
     */
    public function setLegalFoundation(DCATLegalFoundation $legalFoundation): void
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
     * @param DCATDistribution $distribution
     */
    public function addDistribution(DCATDistribution $distribution): void
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
