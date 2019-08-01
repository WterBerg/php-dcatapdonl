<?php

namespace DCAT_AP_DONL;

/**
 * Class DCATDataset.
 *
 * Represents the complex entity DCATDataset which is the primary class of the DCAT-AP-DONL model.
 */
class DCATDataset extends DCATComplexEntity
{
    /** @var string[] */
    protected static $PROPERTIES = [
        'identifier', 'title', 'description', 'keyword', 'license', 'metadataLanguage', 'language',
        'theme', 'modificationDate', 'authority', 'publisher', 'contactPoint', 'accessRights',
        'datasetStatus', 'landingPage', 'spatial', 'temporal', 'conformsTo',
        'alternativeIdentifier', 'relatedResource', 'source', 'hasVersion', 'isVersionOf',
        'releaseDate', 'version', 'versionNotes', 'legalFoundation', 'datePlanned', 'documentation',
        'frequency', 'provenance', 'sample', 'sourceCatalog', 'highValue', 'basisRegister',
        'referentieData', 'nationalCoverage', 'distribution',
    ];

    /** @var string[] */
    protected static $REQUIRED_PROPERTIES = [
        'identifier', 'title', 'description', 'metadataLanguage', 'language', 'license',
        'modificationDate', 'distribution', 'authority', 'publisher', 'contactPoint', 'theme',
    ];

    /** @var DCATURI */
    protected $identifier;

    /** @var DCATLiteral */
    protected $title;

    /** @var DCATLiteral */
    protected $description;

    /** @var DCATLiteral[] */
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

    /** @var DCATLiteral */
    protected $version;

    /** @var DCATLiteral[] */
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

    /** @var DCATBoolean */
    protected $highValue;

    /** @var DCATBoolean */
    protected $basisRegister;

    /** @var DCATBoolean */
    protected $referentieData;

    /** @var DCATBoolean */
    protected $nationalCoverage;

    /** @var DCATDistribution[] */
    protected $distribution;

    /**
     * DCATDataset constructor.
     */
    public function __construct()
    {
        parent::__construct(self::$PROPERTIES, self::$REQUIRED_PROPERTIES);

        $multivalued = [
            'conformsTo', 'alternativeIdentifier', 'source', 'hasVersion', 'isVersionOf',
            'versionNotes', 'documentation', 'provenance', 'sample', 'language', 'theme',
            'keyword', 'relatedResource', 'distribution', 'spatial',
        ];

        foreach ($multivalued as $property) {
            $this->$property = [];
        }
    }

    /**
     * Determines and returns whether or not the DCATDataset is valid.
     *
     * A DCATDataset is considered valid when:
     * - It passes the validation as defined in `DCATComplexEntity::validate()`
     *
     * @see DCATComplexEntity::validate()
     *
     * @return DCATValidationResult The validation result of this DCATDataset
     */
    public function validate(): DCATValidationResult
    {
        $result = parent::validate();

        return $result;
    }

    /**
     * Getter for the identifier property, may return null.
     *
     * @return null|DCATURI The identifier property
     */
    public function getIdentifier(): ?DCATURI
    {
        return $this->identifier;
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
     * Getter for the keyword property, may return an empty array.
     *
     * @return DCATLiteral[] The keyword property
     */
    public function getKeyword(): array
    {
        return $this->keyword;
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
     * Getter for the metadataLanguage property, may return null.
     *
     * @return null|DCATControlledVocabularyEntry The metadataLanguage property
     */
    public function getMetadataLanguage(): ?DCATControlledVocabularyEntry
    {
        return $this->metadataLanguage;
    }

    /**
     * Getter for the language property, may return an empty array.
     *
     * @return DCATControlledVocabularyEntry[] The language property
     */
    public function getLanguage(): array
    {
        return $this->language;
    }

    /**
     * Getter for the theme property, may return an empty array.
     *
     * @return DCATControlledVocabularyEntry[] The theme property
     */
    public function getTheme(): array
    {
        return $this->theme;
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
     * Getter for the authority property, may return null.
     *
     * @return null|DCATControlledVocabularyEntry The authority property
     */
    public function getAuthority(): ?DCATControlledVocabularyEntry
    {
        return $this->authority;
    }

    /**
     * Getter for the publisher property, may return null.
     *
     * @return null|DCATControlledVocabularyEntry The publisher property
     */
    public function getPublisher(): ?DCATControlledVocabularyEntry
    {
        return $this->publisher;
    }

    /**
     * Getter for the contactPoint property, may return null.
     *
     * @return null|DCATContactPoint The contactPoint property
     */
    public function getContactPoint(): ?DCATContactPoint
    {
        return $this->contactPoint;
    }

    /**
     * Getter for the accessRights property, may return null.
     *
     * @return null|DCATControlledVocabularyEntry The accessRights property
     */
    public function getAccessRights(): ?DCATControlledVocabularyEntry
    {
        return $this->accessRights;
    }

    /**
     * Getter for the datasetStatus property, may return null.
     *
     * @return null|DCATControlledVocabularyEntry The datasetStatus property
     */
    public function getDatasetStatus(): ?DCATControlledVocabularyEntry
    {
        return $this->datasetStatus;
    }

    /**
     * Getter for the landingPage property, may return null.
     *
     * @return null|DCATURI The landingPage property
     */
    public function getLandingPage(): ?DCATURI
    {
        return $this->landingPage;
    }

    /**
     * Getter for the spatial property, may return an empty array.
     *
     * @return DCATSpatial[] The spatial property
     */
    public function getSpatial(): array
    {
        return $this->spatial;
    }

    /**
     * Getter for the temporal property, may return null.
     *
     * @return null|DCATTemporal The temporal property
     */
    public function getTemporal(): ?DCATTemporal
    {
        return $this->temporal;
    }

    /**
     * Getter for the conformsTo property, may return an empty array.
     *
     * @return DCATURI[] The conformsTo property
     */
    public function getConformsTo(): array
    {
        return $this->conformsTo;
    }

    /**
     * Getter for the alternativeIdentifier property, may return an empty array.
     *
     * @return DCATURI[] The alternativeIdentifier property
     */
    public function getAlternativeIdentifier(): array
    {
        return $this->alternativeIdentifier;
    }

    /**
     * Getter for the relatedResource property, may return an empty array.
     *
     * @return DCATURI[] The relatedResource property
     */
    public function getRelatedResource(): array
    {
        return $this->relatedResource;
    }

    /**
     * Getter for the source property, may return an empty array.
     *
     * @return DCATURI[] The source property
     */
    public function getSource(): array
    {
        return $this->source;
    }

    /**
     * Getter for the hasVersion property, may return an empty array.
     *
     * @return DCATURI[] The hasVersion property
     */
    public function getHasVersion(): array
    {
        return $this->hasVersion;
    }

    /**
     * Getter for the isVersionOf property, may return an empty array.
     *
     * @return DCATURI[] The isVersionOf property
     */
    public function getIsVersionOf(): array
    {
        return $this->isVersionOf;
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
     * Getter for the version property, may return null.
     *
     * @return null|DCATLiteral The version property
     */
    public function getVersion(): ?DCATLiteral
    {
        return $this->version;
    }

    /**
     * Getter for the versionNotes property, may return an empty array.
     *
     * @return DCATLiteral[] The versionNotes property
     */
    public function getVersionNotes(): array
    {
        return $this->versionNotes;
    }

    /**
     * Getter for the legalFoundation property, may return null.
     *
     * @return null|DCATLegalFoundation The legalFoundation property
     */
    public function getLegalFoundation(): ?DCATLegalFoundation
    {
        return $this->legalFoundation;
    }

    /**
     * Getter for the datePlanned property, may return null.
     *
     * @return null|DCATDateTime The datePlanned property
     */
    public function getDatePlanned(): ?DCATDateTime
    {
        return $this->datePlanned;
    }

    /**
     * Getter for the documentation property, may return an empty array.
     *
     * @return DCATURI[] The documentation property
     */
    public function getDocumentation(): array
    {
        return $this->documentation;
    }

    /**
     * Getter for the frequency property, may return null.
     *
     * @return null|DCATControlledVocabularyEntry The frequency property
     */
    public function getFrequency(): ?DCATControlledVocabularyEntry
    {
        return $this->frequency;
    }

    /**
     * Getter for the provenance property, may return an empty array.
     *
     * @return DCATURI[] The provenance property
     */
    public function getProvenance(): array
    {
        return $this->provenance;
    }

    /**
     * Getter for the sample property, may return an empty array.
     *
     * @return DCATURI[] The sample property
     */
    public function getSample(): array
    {
        return $this->sample;
    }

    /**
     * Getter for the sourceCatalog property, may return null.
     *
     * @return null|DCATControlledVocabularyEntry The sourceCatalog property
     */
    public function getSourceCatalog(): ?DCATControlledVocabularyEntry
    {
        return $this->sourceCatalog;
    }

    /**
     * Getter for the highValue property, may return null.
     *
     * @return null|DCATBoolean The highValue property
     */
    public function getHighValue(): ?DCATBoolean
    {
        return $this->highValue;
    }

    /**
     * Getter for the basisRegister property, may return null.
     *
     * @return null|DCATBoolean The basisRegister property
     */
    public function getBasisRegister(): ?DCATBoolean
    {
        return $this->basisRegister;
    }

    /**
     * Getter for the referentieData property, may return null.
     *
     * @return null|DCATBoolean The referentieData property
     */
    public function getReferentieData(): ?DCATBoolean
    {
        return $this->referentieData;
    }

    /**
     * Getter for the nationalCoverage property, may return null.
     *
     * @return null|DCATBoolean The nationalCoverage property
     */
    public function getNationalCoverage(): ?DCATBoolean
    {
        return $this->nationalCoverage;
    }

    /**
     * Getter for the distribution property, may return an empty array.
     *
     * @return DCATDistribution[] The distribution property
     */
    public function getDistributions(): array
    {
        return $this->distribution;
    }

    /**
     * Setter for the identifier property.
     *
     * @param DCATURI $identifier The value to set
     */
    public function setIdentifier(DCATURI $identifier): void
    {
        $this->identifier = $identifier;
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
     * Adds a value to the keyword property.
     *
     * @param DCATLiteral $keyword The value to add
     */
    public function addKeyword(DCATLiteral $keyword): void
    {
        $this->keyword[] = $keyword;
    }

    /**
     * Setter for the license property. Expects a DCATControlledVocabularyEntry of vocabulary
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
     * Setter for the metadataLanguage property. Expects a DCATControlledVocabularyEntry of
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
     * Adds a value to the language property. Expects a DCATControlledVocabularyEntry of vocabulary
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
     * Adds a value to the theme property. Expects a DCATControlledVocabularyEntry of vocabulary
     * 'Overheid:Taxonomiebeleidsagenda'.
     *
     * @param DCATControlledVocabularyEntry $theme The value to add
     *
     * @throws DCATException Thrown when the vocabulary is not 'Overheid:Taxonomiebeleidsagenda'
     */
    public function addTheme(DCATControlledVocabularyEntry $theme): void
    {
        if ('Overheid:Taxonomiebeleidsagenda' !== $theme->getControlledVocabulary()) {
            throw new DCATException(
                'Expected a DCATControlledVocabularyEntry of vocabulary Overheid:Taxonomiebeleidsagenda'
            );
        }

        $this->theme[] = $theme;
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
     * Setter for the authority property. Expects a DCATControlledVocabularyEntry of vocabulary
     * 'DONL:Organization'.
     *
     * @param DCATControlledVocabularyEntry $authority The value to set
     *
     * @throws DCATException Thrown when the vocabulary is not 'DONL:Organization'
     */
    public function setAuthority(DCATControlledVocabularyEntry $authority): void
    {
        if ('DONL:Organization' !== $authority->getControlledVocabulary()) {
            throw new DCATException(
                'Expected a DCATControlledVocabularyEntry of vocabulary DONL:Organization'
            );
        }

        $this->authority = $authority;
    }

    /**
     * Setter for the publisher property. Expects a DCATControlledVocabularyEntry of vocabulary
     * 'DONL:Organization'.
     *
     * @param DCATControlledVocabularyEntry $publisher The value to set
     *
     * @throws DCATException Thrown when the vocabulary is not 'DONL:Organization'
     */
    public function setPublisher(DCATControlledVocabularyEntry $publisher): void
    {
        if ('DONL:Organization' !== $publisher->getControlledVocabulary()) {
            throw new DCATException(
                'Expected a DCATControlledVocabularyEntry of vocabulary DONL:Organization'
            );
        }

        $this->publisher = $publisher;
    }

    /**
     * Setter for the contactPoint property.
     *
     * @param DCATContactPoint $contactPoint The value to set
     */
    public function setContactPoint(DCATContactPoint $contactPoint): void
    {
        $this->contactPoint = $contactPoint;
    }

    /**
     * Setter for the accessRights property. Expects a DCATControlledVocabularyEntry of vocabulary
     * 'Overheid:Openbaarheidsniveau'.
     *
     * @param DCATControlledVocabularyEntry $accessRights The value to set
     *
     * @throws DCATException Thrown when the vocabulary is not 'Overheid:Openbaarheidsniveau'
     */
    public function setAccessRights(DCATControlledVocabularyEntry $accessRights): void
    {
        if ('Overheid:Openbaarheidsniveau' !== $accessRights->getControlledVocabulary()) {
            throw new DCATException(
                'Expected a DCATControlledVocabularyEntry of vocabulary Overheid:Openbaarheidsniveau'
            );
        }

        $this->accessRights = $accessRights;
    }

    /**
     * Setter for the datasetStatus property. Expects a DCATControlledVocabularyEntry of vocabulary
     * 'Overheid:DatasetStatus'.
     *
     * @param DCATControlledVocabularyEntry $datasetStatus The value to set
     *
     * @throws DCATException Thrown when the vocabulary is not 'Overheid:DatasetStatus'
     */
    public function setDatasetStatus(DCATControlledVocabularyEntry $datasetStatus): void
    {
        if ('Overheid:DatasetStatus' !== $datasetStatus->getControlledVocabulary()) {
            throw new DCATException(
                'Expected a DCATControlledVocabularyEntry of vocabulary Overheid:DatasetStatus'
            );
        }

        $this->datasetStatus = $datasetStatus;
    }

    /**
     * Setter for the landingPage property.
     *
     * @param DCATURI $landingPage The value to set
     */
    public function setLandingPage(DCATURI $landingPage): void
    {
        $this->landingPage = $landingPage;
    }

    /**
     * Adds a value to the spatial property.
     *
     * @param DCATSpatial $spatial The value to add
     */
    public function addSpatial(DCATSpatial $spatial): void
    {
        $this->spatial[] = $spatial;
    }

    /**
     * Setter for the temporal property.
     *
     * @param DCATTemporal $temporal The value to set
     */
    public function setTemporal(DCATTemporal $temporal): void
    {
        $this->temporal = $temporal;
    }

    /**
     * Adds a value to the conformsTo property.
     *
     * @param DCATURI $conformsTo The value to add
     */
    public function addConformsTo(DCATURI $conformsTo): void
    {
        $this->conformsTo[] = $conformsTo;
    }

    /**
     * Adds a value to the alternativeIdentifier property.
     *
     * @param DCATURI $alternativeIdentifier The value to add
     */
    public function addAlternativeIdentifier(DCATURI $alternativeIdentifier): void
    {
        $this->alternativeIdentifier[] = $alternativeIdentifier;
    }

    /**
     * Adds a value to the relatedResource property.
     *
     * @param DCATURI $relatedResource The value to add
     */
    public function addRelatedResource(DCATURI $relatedResource): void
    {
        $this->relatedResource[] = $relatedResource;
    }

    /**
     * Adds a value to the source property.
     *
     * @param DCATURI $source The value to add
     */
    public function addSource(DCATURI $source): void
    {
        $this->source[] = $source;
    }

    /**
     * Adds a value to the hasVersion property.
     *
     * @param DCATURI $hasVersion The value to add
     */
    public function addHasVersion(DCATURI $hasVersion): void
    {
        $this->hasVersion[] = $hasVersion;
    }

    /**
     * Adds a value to the isVersionOf property.
     *
     * @param DCATURI $isVersionOf The value to add
     */
    public function addIsVersionOf(DCATURI $isVersionOf): void
    {
        $this->isVersionOf[] = $isVersionOf;
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
     * Setter for the version property.
     *
     * @param DCATLiteral $version The value to set
     */
    public function setVersion(DCATLiteral $version): void
    {
        $this->version = $version;
    }

    /**
     * Adds a value to the versionNotes property.
     *
     * @param DCATLiteral $versionNotes The value to add
     */
    public function addVersionNotes(DCATLiteral $versionNotes): void
    {
        $this->versionNotes[] = $versionNotes;
    }

    /**
     * Setter for the legalFoundation property.
     *
     * @param DCATLegalFoundation $legalFoundation The value to set
     */
    public function setLegalFoundation(DCATLegalFoundation $legalFoundation): void
    {
        $this->legalFoundation = $legalFoundation;
    }

    /**
     * Setter for the datePlanned property.
     *
     * @param DCATDateTime $datePlanned The value to set
     */
    public function setDatePlanned(DCATDateTime $datePlanned): void
    {
        $this->datePlanned = $datePlanned;
    }

    /**
     * Adds a value to the documentation property.
     *
     * @param DCATLiteral $documentation The value to add
     */
    public function addDocumentation(DCATLiteral $documentation): void
    {
        $this->documentation[] = $documentation;
    }

    /**
     * Setter for the frequency property. Expects a DCATControlledVocabularyEntry of vocabulary
     * 'Overheid:Frequency'.
     *
     * @param DCATControlledVocabularyEntry $frequency The value to set
     *
     * @throws DCATException Thrown when the vocabulary is not 'Overheid:Frequency'
     */
    public function setFrequency(DCATControlledVocabularyEntry $frequency): void
    {
        if ('Overheid:Frequency' !== $frequency->getControlledVocabulary()) {
            throw new DCATException(
                'Expected a DCATControlledVocabularyEntry of vocabulary Overheid:Frequency'
            );
        }

        $this->frequency = $frequency;
    }

    /**
     * Adds a value to the provenance property.
     *
     * @param DCATURI $provenance The value to add
     */
    public function addProvenance(DCATURI $provenance): void
    {
        $this->provenance[] = $provenance;
    }

    /**
     * Adds a value to the sample property.
     *
     * @param DCATURI $sample The value to add
     */
    public function addSample(DCATURI $sample): void
    {
        $this->sample[] = $sample;
    }

    /**
     * Setter for the sourceCatalog property. Expects a DCATControlledVocabularyEntry of vocabulary
     * 'DONL:Catalogs'.
     *
     * @param DCATControlledVocabularyEntry $sourceCatalog The value to set
     *
     * @throws DCATException Thrown when the vocabulary is not 'DONL:Catalogs'
     */
    public function setSourceCatalog(DCATControlledVocabularyEntry $sourceCatalog): void
    {
        if ('DONL:Catalogs' !== $sourceCatalog->getControlledVocabulary()) {
            throw new DCATException(
                'Expected a DCATControlledVocabularyEntry of vocabulary DONL:Catalogs'
            );
        }

        $this->sourceCatalog = $sourceCatalog;
    }

    /**
     * Adds a value to the distribution property.
     *
     * @param DCATDistribution $distribution The value to add
     */
    public function addDistribution(DCATDistribution $distribution): void
    {
        $this->distribution[] = $distribution;
    }

    /**
     * Setter for the highValue property.
     *
     * @param DCATBoolean $highValue The value to set
     */
    public function setHighValue(DCATBoolean $highValue): void
    {
        $this->highValue = $highValue;
    }

    /**
     * Setter for the referentieData property.
     *
     * @param DCATBoolean $referentieData The value to set
     */
    public function setReferentieData(DCATBoolean $referentieData): void
    {
        $this->referentieData = $referentieData;
    }

    /**
     * Setter for the basisRegister property.
     *
     * @param DCATBoolean $basisRegister The value to set
     */
    public function setBasisRegister(DCATBoolean $basisRegister): void
    {
        $this->basisRegister = $basisRegister;
    }

    /**
     * Setter for the nationalCoverage property.
     *
     * @param DCATBoolean $nationalCoverage the value to set
     */
    public function setNationalCoverage(DCATBoolean $nationalCoverage): void
    {
        $this->nationalCoverage = $nationalCoverage;
    }
}
