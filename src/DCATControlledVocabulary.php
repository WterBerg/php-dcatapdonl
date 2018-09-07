<?php

namespace DCAT_AP_DONL;


/**
 * Class DCATControlledVocabulary
 *
 * Allows for checking if a value is part of a certain controlled vocabulary as
 * defined by the DCAT-AP-DONL 1.1 metadata standard.
 *
 * @package DCAT_AP_DONL
 */
class DCATControlledVocabulary {

    /** @var array */
    const CONTROLLED_VOCABULARIES = [
        'ADMS:Changetype'                   => 'https://waardelijsten.dcat-ap-donl.nl/adms_changetype.json',
        'ADMS:Distributiestatus'            => 'https://waardelijsten.dcat-ap-donl.nl/adms_distributiestatus.json',
        'DONL:Catalogs'                     => 'https://waardelijsten.dcat-ap-donl.nl/donl_catalogs.json',
        'DONL:Language'                     => 'https://waardelijsten.dcat-ap-donl.nl/donl_language.json',
        'DONL:Organization'                 => 'https://waardelijsten.dcat-ap-donl.nl/donl_organization.json',
        'IANA:Mediatypes'                   => 'https://waardelijsten.dcat-ap-donl.nl/iana_mediatypes.json',
        'MDR:FiletypeNAL'                   => 'https://waardelijsten.dcat-ap-donl.nl/mdr_filetype_nal.json',
        'Overheid:DatasetStatus'            => 'https://waardelijsten.dcat-ap-donl.nl/overheid_dataset_status.json',
        'Overheid:Frequency'                => 'https://waardelijsten.dcat-ap-donl.nl/overheid_frequency.json',
        'Overheid:License'                  => 'https://waardelijsten.dcat-ap-donl.nl/overheid_license.json',
        'Overheid:Openbaarheidsniveau'      => 'https://waardelijsten.dcat-ap-donl.nl/overheid_openbaarheidsniveau.json',
        'Overheid:SpatialGemeente'          => 'https://waardelijsten.dcat-ap-donl.nl/overheid_spatial_gemeente.json',
        'Overheid:SpatialKoninkrijksdeel'   => 'https://waardelijsten.dcat-ap-donl.nl/overheid_spatial_koninkrijksdeel.json',
        'Overheid:SpatialProvincie'         => 'https://waardelijsten.dcat-ap-donl.nl/overheid_spatial_provincie.json',
        'Overheid:SpatialScheme'            => 'https://waardelijsten.dcat-ap-donl.nl/overheid_spatial_scheme.json',
        'Overheid:SpatialWaterschap'        => 'https://waardelijsten.dcat-ap-donl.nl/overheid_spatial_waterschap.json',
        'Overheid:Taxonomiebeleidsagenda'   => 'https://waardelijsten.dcat-ap-donl.nl/overheid_taxonomiebeleidsagenda.json'
    ];

    /** @var DCATControlledVocabulary[] */
    private static $LISTS = [];

    /**
     * Retrieves the DCATControlledVocabulary that matches the given name. If it
     * is the first time this vocabulary is requested the values will be loaded
     * from its remote source.
     *
     * @param string $name The name of the controlled vocabulary
     * @return DCATControlledVocabulary The DCATControlledVocabulary
     * representing the vocabulary with the given name
     * @throws DCATException Thrown when either the requested vocabulary does
     * not exist, or when the class was unable to load the values from its
     * remote source
     */
    public static function getVocabulary(string $name): DCATControlledVocabulary
    {
        if (!isset(self::$LISTS[$name])) {
            if (!isset(DCATControlledVocabulary::CONTROLLED_VOCABULARIES[$name])) {
                throw new DCATException(
                    sprintf('no vocabulary found with name %s', $name)
                );
            }

            $list = new DCATControlledVocabulary(
                $name,
                DCATControlledVocabulary::CONTROLLED_VOCABULARIES[$name]
            );
            $list->loadEntries();
            self::$LISTS[$name] = $list;
        }

        return self::$LISTS[$name];
    }

    /**
     * Adds a custom vocabulary to the DCAT model.
     *
     * @param string $name The name of the controlled vocabulary
     * @param array $entries The acceptable values for this vocabulary
     * @throws DCATException Thrown when trying to define a vocabulary with a
     * name that is already registered as a controlled vocabulary
     */
    public static function addCustomVocabulary(string $name, array $entries): void
    {
        if (isset(DCATControlledVocabulary::$LISTS[$name])) {
            throw new DCATException(
                'a vocabulary with the given name is already defined'
            );
        }

        $customVocabulary = new DCATControlledVocabulary($name);
        $customVocabulary->setEntries($entries);

        DCATControlledVocabulary::$LISTS[$name] = $customVocabulary;
    }

    /** @var string */
    private $name;

    /** @var string */
    private $source;

    /** @var string[] */
    private $entries;

    /**
     * DCATControlledVocabulary constructor.
     *
     * @param string $name The name of this controlled vocabulary
     * @param null|string $source The online source of this controlled
     * vocabulary
     */
    private function __construct(string $name, string $source = null)
    {
        $this->name = $name;
        $this->source = $source;
    }

    /**
     * Loads the entries from the online resource defined in `$this->source`.
     *
     * @throws DCATException If, for any reason, the vocabulary was unable to
     * load the entries from the remote source
     */
    private function loadEntries(): void
    {
        $this->entries = [];

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->source);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $remoteContents = curl_exec($curl);
        $requestCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if ($requestCode < 200 && $requestCode >= 300) {
            curl_close($curl);
            throw new DCATException(
                sprintf(
                    'unable to retrieve contents from source %s',
                    $this->getSource()
                )
            );
        }

        $parsed = json_decode($remoteContents, true);

        if ($this->name == 'Overheid:License') {
            foreach ($parsed as $entry) {
                $this->entries[] = $entry['id'];
            }
        } else {
            $this->entries = array_keys($parsed);
        }

        curl_close($curl);
    }

    /**
     * Manually set the entries allowed for this vocabulary.
     *
     * @param string[] $entries The entries to use
     */
    private function setEntries(array $entries): void
    {
        $this->entries = $entries;
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
     * Returns the source of this DCAT controlled vocabulary. May be null if
     * this is a custom vocabulary.
     *
     * @return string The source of this controlled vocabulary
     */
    public function getSource(): string
    {
        return $this->source;
    }

    /**
     * Checks if this DCAT vocabulary contains the given value. This is a
     * case-sensitive search.
     *
     * @param string $entry The entry to check
     * @return bool Whether the vocabulary contains the entry
     */
    public function containsEntry(string $entry): bool
    {
        return array_search($entry, $this->entries, false) !== false;
    }

}
