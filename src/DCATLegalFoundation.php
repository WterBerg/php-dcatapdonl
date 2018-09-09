<?php

namespace DCAT_AP_DONL;


/**
 * Class DCATLegalFoundation
 *
 * Represents the complex entity DCATLegalFoundation. It consists of three properties: 'reference',
 * 'uri' and 'label'. All of which are required.
 *
 * @package DCAT_AP_DONL
 */
class DCATLegalFoundation extends DCATComplexEntity {

    /** @var string[] */
    protected static $PROPERTIES = [
        'reference', 'uri', 'label'
    ];

    /** @var string[] */
    protected static $REQUIRED_PROPERTIES = [
        'reference', 'uri', 'label'
    ];

    /** @var DCATProperty */
    protected $reference;

    /** @var DCATURI */
    protected $uri;

    /** @var DCATProperty */
    protected $label;

    /**
     * DCATLegalFoundation constructor.
     */
    public function __construct()
    {
        parent::__construct('LegalFoundation', self::$PROPERTIES, self::$REQUIRED_PROPERTIES);
    }

    /**
     * Getter for the reference property, may return null.
     *
     * @return DCATProperty|null The reference property
     */
    public function getReference(): ?DCATProperty
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
     * @return DCATProperty|null The label property
     */
    public function getLabel(): ?DCATProperty
    {
        return $this->label;
    }

    /**
     * Setter for the reference property.
     *
     * @param DCATProperty $reference The value to set
     */
    public function setReference(DCATProperty $reference): void
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
     * @param DCATProperty $label The value to set
     */
    public function setLabel(DCATProperty $label): void
    {
        $this->label = $label;
    }

}
