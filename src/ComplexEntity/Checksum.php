<?php

namespace DCAT_AP_DONL\ComplexEntities;

use DCAT_AP_DONL\DCATEntity;
use DCAT_AP_DONL\DCATProperty;
use DCAT_AP_DONL\DCATValidationResult;


/**
 * Class Checksum
 *
 * Represents the complex entity `Checksum`. It consists of two properties:
 * 'hash' and 'algorithm'. Both of which are required.
 *
 * @package DCAT_AP_DONL\ComplexEntities
 */
class Checksum extends DCATComplexEntity {

    /** @var string[] */
    private static $PROPERTIES = [
        'hash', 'algorithm'
    ];

    /** @var string[] */
    private static $REQUIRED_PROPERTIES = [
        'hash', 'algorithm'
    ];

    /** @var DCATProperty */
    private $hash;

    /** @var DCATProperty */
    private $algorithm;

    /**
     * Checksum constructor.
     *
     * @param DCATProperty|null $hash The actual hash of the Checksum
     * @param DCATProperty|null $algorithm The algorithm used to determine the
     * hash
     */
    public function __construct(DCATProperty $hash = null,
                                DCATProperty $algorithm = null)
    {
        parent::__construct('Checksum');

        $this->hash = $hash;
        $this->algorithm = $algorithm;
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
     * Determines and returns whether or not the Checksum is valid.
     *
     * A Checksum is considered valid when:
     * - All the properties in `Checksum::$REQUIRED_PROPERTIES` are not null
     * - All the present DCATEntities contained within Checksum pass their
     * individual validation
     *
     * @see Checksum::$REQUIRED_PROPERTIES
     * @see DCATProperty::validate()
     * @return DCATValidationResult The validation result of this Checksum
     */
    public function validate(): DCATValidationResult
    {
        $result = new DCATValidationResult();

        foreach (self::$PROPERTIES as $property) {
            if ($this->$property == null) {
                if (in_array($property, self::$REQUIRED_PROPERTIES)) {
                    $result->addMessage(
                        sprintf('%s: %s is required',
                            $this->getName(), $property)
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
                    $result->addMessage(
                        sprintf('%s: %s', $this->getName(), $message)
                    );
                }
            }
        }

        return $result;
    }

}
