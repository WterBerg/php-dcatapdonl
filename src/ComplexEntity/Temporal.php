<?php

namespace DCAT_AP_DONL\ComplexEntities;

use DCAT_AP_DONL\DCATEntity;
use DCAT_AP_DONL\DCATProperty;
use DCAT_AP_DONL\DCATDateTime;
use DCAT_AP_DONL\DCATValidationResult;


/**
 * Class Temporal
 *
 * Represents the complex entity Temporal. It consists of three properties: 'start', 'end' and
 * 'label'. At least one of these three must be provided.
 *
 * @package DCAT_AP_DONL\ComplexEntities
 */
class Temporal extends DCATComplexEntity {

    /** @var string[] */
    protected static $PROPERTIES = [
        'start', 'end', 'label'
    ];

    /** @var string[] */
    protected static $REQUIRED_PROPERTIES = [
    ];

    /** @var DCATDateTime */
    protected $start;

    /** @var DCATDateTime */
    protected $end;

    /** @var DCATProperty */
    protected $label;

    /**
     * Temporal constructor.
     *
     * @param DCATDateTime|null $start
     * @param DCATDateTime|null $end
     * @param DCATProperty|null $label
     */
    public function __construct(DCATDateTime $start = null, DCATDateTime $end = null,
                                DCATProperty $label = null)
    {
        parent::__construct('Temporal');

        $this->start = $start;
        $this->end = $end;
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
     * Determines and returns whether or not the Temporal is valid.
     *
     * A Temporal is considered valid when:
     * - All the properties in `Temporal::$REQUIRED_PROPERTIES` are not null
     * - All the present DCATEntities contained within Temporal pass their individual validation
     * - The value of `$this->start` is smaller than `$this->end`, assuming both are present
     *
     * @see Temporal::$REQUIRED_PROPERTIES
     * @return DCATValidationResult The validation result of this Temporal
     */
    public function validate(): DCATValidationResult
    {
        $result = new DCATValidationResult();

        if ($this->start == null && $this->end == null && $this->label == null) {
            $result->addMessage(
                sprintf('%s: at least one property must be provided', $this->getName())
            );
        }

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

        if ($this->start == null && $this->end == null) {
            return $result;
        }

        $start = new \DateTime($this->start->getData());
        $end = new \DateTime($this->end->getData());

        if ($start >= $end) {
            $result->addMessage(
                sprintf(
                    '%s: start must be smalled than end; got %s and %s',
                    $this->getName(), $this->start->getData(), $this->end->getData())
            );
        }

        return $result;
    }

}
