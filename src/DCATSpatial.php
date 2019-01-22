<?php

namespace DCAT_AP_DONL;

/**
 * Class DCATSpatial.
 *
 * Represents the complex entity DCATSpatial. It consists of two properties: 'scheme' and 'value'.
 * Both are required. Furthermore the value of 'value' is validated against the scheme provided in
 * the 'scheme' property.
 */
class DCATSpatial extends DCATComplexEntity
{
    /** @var string[] */
    protected static $PROPERTIES = [
        'scheme', 'value',
    ];

    /** @var string[] */
    protected static $REQUIRED_PROPERTIES = [
        'scheme', 'value',
    ];

    /** @var DCATControlledVocabularyEntry */
    protected $scheme;

    /** @var DCATLiteral */
    protected $value;

    /**
     * DCATSpatial constructor.
     */
    public function __construct()
    {
        parent::__construct(self::$PROPERTIES, self::$REQUIRED_PROPERTIES);
    }

    /**
     * Determines and returns whether or not the DCATSpatial is valid.
     *
     * A DCATSpatial is considered valid when:
     * - It passes the validation as defined in `DCATComplexEntity::validate()`
     * - The `$this->value` property validates against the schema provided in the `$this->scheme`
     * property
     *
     * @see DCATComplexEntity::validate()
     * @see DCATSpatial::valueMatchesScheme()
     *
     * @throws DCATException Thrown when there was a problem with retrieving the scheme
     *
     * @return DCATValidationResult The validation result of this DCATSpatial
     */
    public function validate(): DCATValidationResult
    {
        $result = parent::validate();

        if (null == $this->scheme || null == $this->value) {
            return $result;
        }

        if (!$this->valueMatchesScheme()) {
            $result->addMessage(
                sprintf(
                    'value %s fails to validate against scheme %s',
                    $this->value->getData(), $this->scheme->getData()
                )
            );
        }

        return $result;
    }

    /**
     * Getter for the scheme property, may return null.
     *
     * @return null|DCATControlledVocabularyEntry The scheme property
     */
    public function getScheme(): ?DCATControlledVocabularyEntry
    {
        return $this->scheme;
    }

    /**
     * Getter for the value property, may return null.
     *
     * @return null|DCATLiteral The value property
     */
    public function getValue(): ?DCATLiteral
    {
        return $this->value;
    }

    /**
     * Setter for the scheme property.
     *
     * @param DCATControlledVocabularyEntry $scheme The value to set
     */
    public function setScheme(DCATControlledVocabularyEntry $scheme): void
    {
        $this->scheme = $scheme;
    }

    /**
     * Setter for the value property.
     *
     * @param DCATLiteral $value The value to set
     */
    public function setValue(DCATLiteral $value): void
    {
        $this->value = $value;
    }

    /**
     * Validates the `$this->value` against the scheme defined in `$this->scheme`.
     *
     * @see DCATValuelist::hasEntry()
     * @see DCATSpatial::validEPSG28992()
     * @see DCATSpatial::validPostcodeHuisnummer()
     *
     * @throws DCATException Thrown when the scheme references a vocabulary which does not exist
     *
     * @return bool Whether or not the value validates against the scheme
     */
    protected function valueMatchesScheme(): bool
    {
        $listValidators = [
            'http://standaarden.overheid.nl/owms/4.0/doc/waardelijsten/overheid.gemeente'        => 'Overheid:SpatialGemeente',
            'http://standaarden.overheid.nl/owms/4.0/doc/waardelijsten/overheid.koninkrijksdeel' => 'Overheid:SpatialKoninkrijksdeel',
            'http://standaarden.overheid.nl/owms/4.0/doc/waardelijsten/overheid.provincie'       => 'Overheid:SpatialProvincie',
            'http://standaarden.overheid.nl/owms/4.0/doc/waardelijsten/overheid.waterschap'      => 'Overheid:SpatialWaterschap',
        ];

        if (isset($listValidators[$this->scheme->getData()])) {
            $vocabulary = DCATControlledVocabulary::getVocabulary(
                $listValidators[$this->scheme->getData()]
            );

            return $vocabulary->containsEntry($this->value->getData());
        }

        $epsg28992 = 'http://standaarden.overheid.nl/owms/4.0/doc/syntax-codeerschemas/overheid.epsg28992';
        if ($this->scheme->getData() === $epsg28992) {
            return $this->validEPSG28992();
        }

        $postcodehuisnummer = 'http://standaarden.overheid.nl/owms/4.0/doc/syntax-codeerschemas/overheid.postcodehuisnummer';
        if ($this->scheme->getData() === $postcodehuisnummer) {
            return $this->validPostcodeHuisnummer();
        }

        throw new DCATException('invalid scheme specified for Spatial');
    }

    /**
     * Determines if the value matches the rules for the EPSG28992 scheme.
     *
     * @return bool Whether or not it is a valid EPSG28992
     */
    protected function validEPSG28992(): bool
    {
        $match = preg_match('/^\d{6}(\.\d{3})? \d{6}(\.\d{3})?$/', $this->value->getData());

        return  1 == $match;
    }

    /**
     * Determines if the value matches the rules for the PostcodeHuisnummer scheme.
     *
     * @return bool Whether or not it is a valid PostcodeHuisnummer
     */
    protected function validPostcodeHuisnummer(): bool
    {
        $match = preg_match('/^[1-9]\d{3}([A-Z]{2}(\d+(\S+)?)?)?$/', $this->value->getData());

        return 1 == $match;
    }
}
