<?php

namespace DCAT_AP_DONL\ComplexEntities;

use DCAT_AP_DONL\DCATControlledVocabulary;
use DCAT_AP_DONL\DCATEntity;
use DCAT_AP_DONL\DCATProperty;
use DCAT_AP_DONL\DCATControlledVocabularyEntry;
use DCAT_AP_DONL\DCATValidationResult;
use DCAT_AP_DONL\DCATException;


/**
 * Class Spatial
 *
 * Represents the complex entity Spatial. It consists of two properties:
 * 'scheme' and 'value'. Both are required. Furthermore the value of 'value' is
 * validated against the scheme provided in the 'scheme' property.
 *
 * @package DCAT_AP_DONL\ComplexEntities
 */
class Spatial extends DCATComplexEntity {

    /** @var string[] */
    private static $PROPERTIES = [
        'scheme', 'value'
    ];

    /** @var string[] */
    private static $REQUIRED_PROPERTIES = [
        'scheme', 'value'
    ];

    /** @var DCATControlledVocabularyEntry */
    private $scheme;

    /** @var DCATProperty */
    private $value;

    /**
     * Spatial constructor.
     *
     * @param DCATControlledVocabularyEntry|null $scheme
     * @param DCATProperty|null $value
     */
    public function __construct(DCATControlledVocabularyEntry $scheme = null,
                                DCATProperty $value = null)
    {
        parent::__construct('Spatial');

        $this->scheme = $scheme;
        $this->value = $value;
    }

    /**
     * @inheritdoc
     */
    public function getData(): array
    {
        $data = [];

        foreach (self::$PROPERTIES as $property) {
            if ($this->$property) {
                $data[$this->$property->getName()] = $this->$property->getData();
            }
        }

        return $data;
    }

    /**
     * Determines and returns whether or not the Spatial is valid.
     *
     * A Spatial is considered valid when:
     * - All the properties in `Spatial::$REQUIRED_PROPERTIES` are not null
     * - All the present DCATEntities contained within Spatial pass their
     * individual validation
     * - The `$this->value` property validates against the schema provided in
     * the `$this->scheme` property
     *
     * @see Spatial::$REQUIRED_PROPERTIES
     * @see Spatial::valueMatchesScheme()
     * @return DCATValidationResult The validation result of this Spatial
     * @throws DCATException Thrown when there was a problem with retrieving the
     * scheme
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

            if ($this->$property) {
                if (!$this->$property instanceof DCATEntity) {
                    continue;
                }

                $validation = $this->$property->validate();
                /* @var DCATValidationResult $validation */

                foreach ($validation->getMessages() as $message) {
                    $result->addMessage($this->getName() . ': ' . $message);
                }
            }
        }

        try {
            $vocabulary = DCATControlledVocabulary::getVocabulary(
                'Overheid:SpatialScheme'
            );
            if (!$vocabulary->containsEntry($this->scheme->getData())) {
                $result->addMessage(
                    sprintf(
                        '%s: scheme %s is not a valid scheme',
                        $this->getName(), $this->scheme->getData()
                    )
                );
            }
        } catch (DCATException $e) {
            $result->addMessage(
                sprintf(
                    '%s: could not validate scheme, a problem occurred 
                    while retrieving the controlled vocabulary',
                    $this->getName()
                )
            );
        }

        if (!$this->valueMatchesScheme()) {
            $result->addMessage(
                sprintf(
                    '%s: value %s fails to validate against scheme %s',
                    $this->getName(),
                    $this->value->getData(),
                    $this->scheme->getData()
                )
            );
        }

        return $result;
    }

    /**
     * Validates the `$this->value` against the scheme defined in
     * `$this->scheme`.
     *
     * @see DCATValuelist::hasEntry()
     * @see Spatial::validEPSG28992()
     * @see Spatial::validPostcodeHuisnummer()
     * @return bool Whether or not the value validates against the scheme
     * @throws DCATException Thrown when the scheme references a vocabulary
     * which does not exist
     */
    private function valueMatchesScheme(): bool
    {
        $listValidators = [
            'https://standaarden.overheid.nl/owms/4.0/doc/waardelijsten/overheid.gemeente'          => 'Overheid:SpatialGemeente',
            'https://standaarden.overheid.nl/owms/4.0/doc/waardelijsten/overheid.koninkrijksdeel'   => 'Overheid:SpatialKoninkrijksdeel',
            'https://standaarden.overheid.nl/owms/4.0/doc/waardelijsten/overheid.provincie'         => 'Overheid:SpatialProvincie',
            'https://standaarden.overheid.nl/owms/4.0/doc/waardelijsten/overheid.waterschap'        => 'Overheid:SpatialWaterschap'
        ];

        if (isset($listValidators[$this->scheme->getData()])) {
            $vocabulary = DCATControlledVocabulary::getVocabulary(
                $listValidators[$this->scheme->getData()]
            );
            return $vocabulary->containsEntry($this->value->getData());
        }

        $epsg28992 = 'https://standaarden.overheid.nl/owms/4.0/doc/syntax-codeerschemas/overheid.epsg28992';
        if ($this->scheme->getData() === $epsg28992) {
            return $this->validEPSG28992();
        }

        $postcodehuisnummer = 'https://standaarden.overheid.nl/owms/4.0/doc/syntax-codeerschemas/overheid.postcodehuisnummer';
        if ($this->scheme->getData() === $postcodehuisnummer) {
            return $this->validPostcodeHuisnummer();
        }

        return true;
    }

    /**
     * Determines if the value matches the rules for the EPSG28992 scheme.
     *
     * @return bool Whether or not it is a valid EPSG28992
     */
    private function validEPSG28992(): bool
    {
        $match = preg_match(
            '^\d{6}(\.\d{3})? \d{6}(\.\d{3})?$',
            $this->value->getData()
        );

        return  $match == 1;
    }

    /**
     * Determines if the value matches the rules for the PostcodeHuisnummer
     * scheme.
     *
     * @return bool Whether or not it is a valid PostcodeHuisnummer
     */
    private function validPostcodeHuisnummer(): bool
    {
        $match = preg_match(
            '^[1-9]\d{3}([A-Z]{2}(\d+(\S+)?)?)?$',
            $this->value->getData()
        );

        return $match == 1;
    }

}
