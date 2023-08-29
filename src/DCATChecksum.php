<?php

declare(strict_types=1);

namespace DCAT_AP_DONL;

/**
 * Class DCATChecksum.
 *
 * Represents the complex entity DCATChecksum. It consists of two properties: 'hash' and
 * 'algorithm'. Both of which are required.
 */
class DCATChecksum extends DCATComplexEntity
{
    /**
     * The hash (`spdx:checksumValue`) property.
     *
     * @var null|DCATLiteral
     */
    protected ?DCATLiteral $hash;

    /**
     * The 'algorithm' (`spdx:algorithm`) property.
     *
     * @var null|DCATLiteral
     */
    protected ?DCATLiteral $algorithm;

    /**
     * DCATChecksum constructor.
     */
    public function __construct()
    {
        parent::__construct(['hash', 'algorithm'], ['hash', 'algorithm']);
    }

    /**
     * Getter for the hash property, may return null.
     *
     * @return null|DCATLiteral The hash property
     */
    public function getHash(): ?DCATLiteral
    {
        return $this->hash;
    }

    /**
     * Getter for the algorithm property, may return null.
     *
     * @return null|DCATLiteral The algorithm property
     */
    public function getAlgorithm(): ?DCATLiteral
    {
        return $this->algorithm;
    }

    /**
     * Setter for the hash property.
     *
     * @param DCATLiteral $hash The value to set
     */
    public function setHash(DCATLiteral $hash): void
    {
        $this->hash = $hash;
    }

    /**
     * Setter for the algorithm property.
     *
     * @param DCATLiteral $algorithm The value to set
     */
    public function setAlgorithm(DCATLiteral $algorithm): void
    {
        $this->algorithm = $algorithm;
    }
}
