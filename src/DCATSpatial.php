<?php

/**
 * This file is part of the wterberg/dcat-ap-donl package.
 *
 * This source file is subject to the license that is
 * bundled with this source code in the LICENSE.md file.
 */

namespace DCAT_AP_DONL;

/**
 * Class DCATSpatial.
 *
 * Represents the complex entity DCATSpatial. It consists of two properties: 'scheme' and 'value'.
 * Both are required. Furthermore, the value of 'value' is validated against the scheme provided in
 * the 'scheme' property.
 */
class DCATSpatial extends DCATComplexEntity
{
    /**
     * @var string[][]
     */
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

    /**
     * @var string[]
     */
    protected static array $PROPERTIES = ['scheme', 'value'];

    /**
     * @var string[]
     */
    protected static array $REQUIRED_PROPERTIES = ['scheme', 'value'];

    protected ?DCATControlledVocabularyEntry $scheme;

    protected ?DCATLiteral $value;

    /**
     * DCATSpatial constructor.
     */
    public function __construct()
    {
        parent::__construct(self::$PROPERTIES, self::$REQUIRED_PROPERTIES);
    }

    /**
     * Determines and returns whether the DCATSpatial is valid.
     *
     * A DCATSpatial is considered valid when:
     * - It passes the validation as defined in `DCATComplexEntity::validate()`
     * - The `$this->value` property validates against the schema provided in the `$this->scheme`
     *   property
     *
     * @see DCATComplexEntity::validate()
     * @see DCATSpatial::valueMatchesScheme()
     *
     * @return DCATValidationResult The validation result of this DCATSpatial
     *
     * @throws DCATException Thrown when there was a problem with retrieving the scheme
     */
    public function validate(): DCATValidationResult
    {
        $result = parent::validate();

        if (is_null($this->scheme?->getData()) || is_null($this->value?->getData())) {
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
     * @return bool Whether the value validates against the scheme
     *
     * @throws DCATException Thrown when the scheme references a vocabulary which does not exist
     */
    protected function valueMatchesScheme(): bool
    {
        $scheme = $this->scheme?->getData();
        $value  = $this->value?->getData();

        if (is_null($scheme) || is_null($value)) {
            return true;
        }

        if (!array_key_exists($scheme, self::SPATIAL_MAPPING)) {
            throw new DCATException('invalid scheme specified for Spatial');
        }

        $mapping = self::SPATIAL_MAPPING[$scheme];

        return match ($mapping['type']) {
            'regex'      => $this->matchesRegex($value, $mapping['regex']),
            'vocabulary' => DCATControlledVocabulary::getVocabulary($mapping['vocabulary'])
                ->containsEntry($value),
        };
    }

    /**
     * Determines if the value matches the given Regex pattern.
     *
     * @param mixed  $value The value to validate
     * @param string $regex The pattern to match against
     *
     * @return bool Whether it is a valid value according to the regex
     */
    protected function matchesRegex(mixed $value, string $regex): bool
    {
        return 1 === preg_match($regex, $value);
    }
}
