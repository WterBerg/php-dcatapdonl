<?php

namespace DCAT_AP_DONL;

/**
 * Class DCATLegalFoundation.
 *
 * Represents the complex entity DCATLegalFoundation. It consists of three properties: 'reference',
 * 'uri' and 'label'. All of which are required.
 */
class DCATLegalFoundation extends DCATComplexEntity
{
    /** @var string[] */
    protected static $PROPERTIES = [
        'reference', 'uri', 'label',
    ];

    /** @var string[] */
    protected static $REQUIRED_PROPERTIES = [
        'reference', 'uri', 'label',
    ];

    /** @var DCATLiteral */
    protected $reference;

    /** @var DCATURI */
    protected $uri;

    /** @var DCATLiteral */
    protected $label;

    /**
     * DCATLegalFoundation constructor.
     */
    public function __construct()
    {
        parent::__construct(self::$PROPERTIES, self::$REQUIRED_PROPERTIES);
    }

    /**
     * Getter for the reference property, may return null.
     *
     * @return DCATLiteral|null The reference property
     */
    public function getReference(): ?DCATLiteral
    {
        return $this->reference;
    }

    /**
     * Getter for the uri property, may return null.
     *
     * @return DCATURI|null The uri property
     */
    public function getUri(): ?DCATURI
    {
        return $this->uri;
    }

    /**
     * Getter for the label property, may return null.
     *
     * @return DCATLiteral|null The label property
     */
    public function getLabel(): ?DCATLiteral
    {
        return $this->label;
    }

    /**
     * Setter for the reference property.
     *
     * @param DCATLiteral $reference The value to set
     */
    public function setReference(DCATLiteral $reference): void
    {
        $this->reference = $reference;
    }

    /**
     * Setter for the uri property.
     *
     * @param DCATURI $uri The value to set
     */
    public function setUri(DCATURI $uri): void
    {
        $this->uri = $uri;
    }

    /**
     * Setter for the label property.
     *
     * @param DCATLiteral $label The value to set
     */
    public function setLabel(DCATLiteral $label): void
    {
        $this->label = $label;
    }
}
