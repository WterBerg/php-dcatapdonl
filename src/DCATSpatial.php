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
    /** @var string[][] */
    public const SPATIAL_MAPPING = [
        'http://standaarden.overheid.nl/owms/4.0/doc/waardelijsten/overheid.gemeente'         => [
            'type'       => 'vocabulary',
            'vocabulary' => 'Overheid:SpatialGemeente',
        ],
        'http://standaarden.overheid.nl/owms/4.0/doc/waardelijsten/overheid.koninkrijksdeel'  => [
            'type'       => 'vocabulary',
            'vocabulary' => 'Overheid:SpatialKoninkrijksdeel',
        ],
        'http://standaarden.overheid.nl/owms/4.0/doc/waardelijsten/overheid.provincie'        => [
            'type'       => 'vocabulary',
            'vocabulary' => 'Overheid:SpatialProvincie',
        ],
        'http://standaarden.overheid.nl/owms/4.0/doc/waardelijsten/overheid.waterschap'       => [
            'type'       => 'vocabulary',
            'vocabulary' => 'Overheid:SpatialWaterschap',
        ],
        'http://standaarden.overheid.nl/owms/4.0/doc/syntax-codeerschemas/overheid.epsg28992' => [
            'type'  => 'regex',
            'regex' => '/^\d{6}(\.\d{3})? \d{6}(\.\d{3})?$/',
        ],
        'http://standaarden.overheid.nl/owms/4.0/doc/syntax-codeerschemas/overheid.postcodehuisnummer' => [
            'type'  => 'regex',
            'regex' => '/^[1-9]\d{3}([A-Z]{2}(\d+(\S+)?)?)?$/',
        ],
    ];

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
                'value ' . $this->value->getData() . ' fails to validate against scheme ' .
                $this->scheme->getData()
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
     * @see DCATSpatial::matchesRegex()
     *
     * @throws DCATException Thrown when the scheme references a vocabulary which does not exist
     *
     * @return bool Whether or not the value validates against the scheme
     */
    protected function valueMatchesScheme(): bool
    {
        $scheme = $this->scheme->getData();
        $value  = $this->value->getData();

        if (!array_key_exists($scheme, self::SPATIAL_MAPPING)) {
            throw new DCATException('invalid scheme specified for Spatial');
        }

        $mapping = self::SPATIAL_MAPPING[$scheme];

        switch ($mapping['type']) {
            case 'vocabulary':
                return DCATControlledVocabulary::getVocabulary($mapping['vocabulary'])
                    ->containsEntry($value);
            case 'regex':
                return $this->matchesRegex($value, $mapping['regex']);
            default:
                throw new DCATException('invalid scheme specified for Spatial');
        }
    }

    /**
     * Determines if the value matches the given Regex pattern.
     *
     * @param mixed  $value The value to validate
     * @param string $regex The pattern to match against
     *
     * @return bool Whether or not it is a valid value according to the regex
     */
    protected function matchesRegex($value, string $regex): bool
    {
        return 1 === preg_match($regex, $value);
    }
}
