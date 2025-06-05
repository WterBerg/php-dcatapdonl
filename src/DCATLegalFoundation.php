<?php

/**
 * This file is part of the wterberg/dcat-ap-donl package.
 *
 * This source file is subject to the license that is
 * bundled with this source code in the LICENSE.md file.
 */

namespace DCAT_AP_DONL;

/**
 * Class DCATLegalFoundation.
 *
 * Represents the complex entity DCATLegalFoundation. It consists of three properties: 'reference',
 * 'uri' and 'label'. All of which are required.
 */
class DCATLegalFoundation extends DCATComplexEntity
{
    /**
     * @var string[]
     */
    protected static array $PROPERTIES = [
        'reference', 'uri', 'label',
    ];

    /**
     * @var string[]
     */
    protected static array $REQUIRED_PROPERTIES = [
        'reference', 'uri', 'label',
    ];

    protected ?DCATLiteral $reference;

    protected ?DCATURI $uri;

    protected ?DCATLiteral $label;

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
     * @return null|DCATLiteral The reference property
     */
    public function getReference(): ?DCATLiteral
    {
        return $this->reference;
    }

    /**
     * Getter for the uri property, may return null.
     *
     * @return null|DCATURI The uri property
     */
    public function getUri(): ?DCATURI
    {
        return $this->uri;
    }

    /**
     * Getter for the label property, may return null.
     *
     * @return null|DCATLiteral The label property
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
