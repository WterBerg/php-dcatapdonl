<?php

namespace DCAT_AP_DONL;


/**
 * Class DCATChecksum
 *
 * Represents the complex entity DCATChecksum. It consists of two properties: 'hash' and
 * 'algorithm'. Both of which are required.
 *
 * @package DCAT_AP_DONL
 */
class DCATChecksum extends DCATComplexEntity {

    /** @var string[] */
    protected static $PROPERTIES = [
        'hash', 'algorithm'
    ];

    /** @var string[] */
    protected static $REQUIRED_PROPERTIES = [
        'hash', 'algorithm'
    ];

    /** @var DCATProperty */
    protected $hash;

    /** @var DCATProperty */
    protected $algorithm;

    /**
     * DCATChecksum constructor.
     */
    public function __construct()
    {
        parent::__construct('Checksum', self::$PROPERTIES, self::$REQUIRED_PROPERTIES);
    }

    /**
     * Getter for the hash property, may return null.
     *
     * @return DCATProperty|null The hash property
     */
    public function getHash(): ?DCATProperty
    {
        return $this->hash;
    }

    /**
     * Getter for the algorithm property, may return null.
     *
     * @return DCATProperty|null The algorithm property
     */
    public function getAlgorithm(): ?DCATProperty
    {
        return $this->algorithm;
    }

    /**
     * Setter for the hash property.
     *
     * @param DCATProperty $hash The value to set
     */
    public function setHash(DCATProperty $hash): void
    {
        $this->hash = $hash;
    }

    /**
     * Setter for the algorithm property.
     *
     * @param DCATProperty $algorithm The value to set
     */
    public function setAlgorithm(DCATProperty $algorithm): void
    {
        $this->algorithm = $algorithm;
    }

}
