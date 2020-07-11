<?php

namespace DCAT_AP_DONL;

/**
 * Class DCATControlledVocabulary.
 *
 * Allows for checking if a value is part of a certain controlled vocabulary as defined by the
 * DCAT-AP-DONL 1.1 metadata standard.
 */
class DCATControlledVocabulary
{
    /** @var string[] */
    const CONTROLLED_VOCABULARIES = [
        'ADMS:Changetype'                 => 'https://waardelijsten.dcat-ap-donl.nl/adms_changetype.json',
        'ADMS:Distributiestatus'          => 'https://waardelijsten.dcat-ap-donl.nl/adms_distributiestatus.json',
        'DONL:Catalogs'                   => 'https://waardelijsten.dcat-ap-donl.nl/donl_catalogs.json',
        'DONL:DistributionType'           => 'https://waardelijsten.dcat-ap-donl.nl/donl_distributiontype.json',
        'DONL:Language'                   => 'https://waardelijsten.dcat-ap-donl.nl/donl_language.json',
        'DONL:License'                    => 'https://waardelijsten.dcat-ap-donl.nl/donl_license.json',
        'DONL:Organization'               => 'https://waardelijsten.dcat-ap-donl.nl/donl_organization.json',
        'IANA:Mediatypes'                 => 'https://waardelijsten.dcat-ap-donl.nl/iana_mediatypes.json',
        'MDR:FiletypeNAL'                 => 'https://waardelijsten.dcat-ap-donl.nl/mdr_filetype_nal.json',
        'Overheid:DatasetStatus'          => 'https://waardelijsten.dcat-ap-donl.nl/overheid_dataset_status.json',
        'Overheid:Frequency'              => 'https://waardelijsten.dcat-ap-donl.nl/overheid_frequency.json',
        'Overheid:Openbaarheidsniveau'    => 'https://waardelijsten.dcat-ap-donl.nl/overheid_openbaarheidsniveau.json',
        'Overheid:SpatialGemeente'        => 'https://waardelijsten.dcat-ap-donl.nl/overheid_spatial_gemeente.json',
        'Overheid:SpatialKoninkrijksdeel' => 'https://waardelijsten.dcat-ap-donl.nl/overheid_spatial_koninkrijksdeel.json',
        'Overheid:SpatialProvincie'       => 'https://waardelijsten.dcat-ap-donl.nl/overheid_spatial_provincie.json',
        'Overheid:SpatialScheme'          => 'https://waardelijsten.dcat-ap-donl.nl/overheid_spatial_scheme.json',
        'Overheid:SpatialWaterschap'      => 'https://waardelijsten.dcat-ap-donl.nl/overheid_spatial_waterschap.json',
        'Overheid:Taxonomiebeleidsagenda' => 'https://waardelijsten.dcat-ap-donl.nl/overheid_taxonomiebeleidsagenda.json',
    ];

    /** @var DCATControlledVocabulary[] */
    protected static $LISTS = [];

    /** @var string */
    protected $name;

    /** @var string */
    protected $source;

    /** @var string[] */
    protected $entries;

    /**
     * DCATControlledVocabulary constructor.
     *
     * @param string      $name   The name of this controlled vocabulary
     * @param null|string $source The online source of this controlled vocabulary
     */
    protected function __construct(string $name, string $source = null)
    {
        $this->name   = $name;
        $this->source = $source;
    }

    /**
     * Retrieves the DCATControlledVocabulary that matches the given name. If it is the first time
     * this vocabulary is requested the values will be loaded from its remote source.
     *
     * No attempt will be made to load custom controlled vocabularies added with
     * `DCATControlledVocabulary::addCustomVocabulary()` as they have no source configured.
     *
     * @param string $name The name of the controlled vocabulary
     *
     * @throws DCATException Thrown when either the requested vocabulary does not exist, or when the
     *                       class was unable to load the values from its remote source
     *
     * @return DCATControlledVocabulary The DCATControlledVocabulary representing the vocabulary
     *                                  with the given name
     */
    public static function getVocabulary(string $name): DCATControlledVocabulary
    {
        if (!array_key_exists($name, self::$LISTS)) {
            if (!array_key_exists($name, self::CONTROLLED_VOCABULARIES)) {
                throw new DCATException('no vocabulary found with name ' . $name);
            }

            $list = new DCATControlledVocabulary($name, self::CONTROLLED_VOCABULARIES[$name]);
            $list->loadEntries();
            self::$LISTS[$name] = $list;
        }

        return self::$LISTS[$name];
    }

    /**
     * Adds a custom vocabulary to the DCAT model.
     *
     * @param string $name    The name of the controlled vocabulary
     * @param array  $entries The acceptable values for this vocabulary
     *
     * @throws DCATException Thrown when trying to define a vocabulary with a name that is already
     *                       registered as a controlled vocabulary
     */
    public static function addCustomVocabulary(string $name, array $entries): void
    {
        if (array_key_exists($name, self::$LISTS)) {
            throw new DCATException('a vocabulary with the given name is already defined');
        }

        $customVocabulary = new DCATControlledVocabulary($name);
        $customVocabulary->setEntries($entries);
        $customVocabulary->setSource('custom');

        self::$LISTS[$name] = $customVocabulary;
    }

    /**
     * Adds a custom external vocabulary to the DCAT model.
     *
     * @param string $name   The name of the controlled vocabulary
     * @param string $source The external source for this vocabulary
     *
     * @throws DCATException Thrown when trying to define a vocabulary with a name that is already
     *                       registered as a controlled vocabulary
     */
    public static function addCustomExternalVocabulary(string $name, string $source): void
    {
        if (array_key_exists($name, self::$LISTS)) {
            throw new DCATException('a vocabulary with the given name is already defined');
        }

        $customVocabulary = new DCATControlledVocabulary($name, $source);
        $customVocabulary->loadEntries();

        self::$LISTS[$name] = $customVocabulary;
    }

    /**
     * Returns the name of this DCAT controlled vocabulary.
     *
     * @return string The name of this DCAT controlled vocabulary
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Returns the source of this DCAT controlled vocabulary.
     *
     * @return string The source of this controlled vocabulary
     */
    public function getSource(): ?string
    {
        return $this->source;
    }

    /**
     * Checks if this DCAT vocabulary contains the given value. This is a case-sensitive search.
     *
     * @param string $entry The entry to check
     *
     * @return bool Whether the vocabulary contains the entry
     */
    public function containsEntry(string $entry): bool
    {
        return false !== array_search($entry, $this->entries, false);
    }

    /**
     * Loads the entries from the source of the vocabulary.
     *
     * @throws DCATException If, for any reason, the vocabulary was unable to load the entries from
     *                       the source
     */
    protected function loadEntries(): void
    {
        $this->entries = [];

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->source);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $remoteContents = curl_exec($curl);
        $requestCode    = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if ($requestCode < 200 || $requestCode >= 300) {
            curl_close($curl);

            throw new DCATException('unable to retrieve contents from source ' . $this->getSource());
        }

        $parsed = json_decode($remoteContents, true);

        if (null === $parsed) {
            throw new DCATException('failed to parse JSON for vocabulary ' . $this->source);
        }

        $this->entries = array_keys($parsed);

        curl_close($curl);
    }

    /**
     * Manually set the entries allowed for this vocabulary.
     *
     * @param string[] $entries The entries to use
     */
    protected function setEntries(array $entries): void
    {
        $this->entries = $entries;
    }

    /**
     * Setter for the source property.
     *
     * @param string $source The value to set
     */
    protected function setSource(string $source): void
    {
        $this->source = $source;
    }
}
