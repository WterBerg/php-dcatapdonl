<?php

namespace DCAT_AP_DONL\ComplexEntities;

use DCAT_AP_DONL\DCATEntity;
use DCAT_AP_DONL\DCATProperty;
use DCAT_AP_DONL\DCATURI;
use DCAT_AP_DONL\DCATValidationResult;


/**
 * Class LegalFoundation
 *
 * Represents the complex entity LegalFoundation. It consists of three properties: 'reference',
 * 'uri' and 'label'. All of which are required.
 *
 * @package DCAT_AP_DONL\ComplexEntities
 */
class LegalFoundation extends DCATComplexEntity {

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
     * LegalFoundation constructor.
     *
     * @param DCATProperty|null $reference
     * @param DCATURI|null $uri
     * @param DCATProperty|null $label
     */
    public function __construct(DCATProperty $reference = null, DCATURI $uri = null,
                                DCATProperty $label = null)
    {
        parent::__construct('LegalFoundation');

        $this->reference = $reference;
        $this->uri = $uri;
        $this->label = $label;
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
     * Determines and returns whether or not the LegalFoundation is valid.
     *
     * A LegalFoundation is considered valid when:
     * - All the properties in `LegalFoundation::$REQUIRED_PROPERTIES` are not null
     * - All the present DCATEntities contained within LegalFoundation pass their individual
     * validation
     *
     * @see LegalFoundation::$REQUIRED_PROPERTIES
     * @return DCATValidationResult The validation result of the LegalFoundation
     */
    public function validate(): DCATValidationResult
    {
        $result = new DCATValidationResult();

        foreach (self::$PROPERTIES as $property) {
            if ($this->$property == null) {
                if (in_array($property, self::$REQUIRED_PROPERTIES)) {
                    $result->addMessage(
                        sprintf('%s: %s is missing', $this->getName(), $property)
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

        return $result;
    }

}
