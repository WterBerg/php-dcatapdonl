<?php

namespace DCAT_AP_DONL;

use DateTime;
use Exception;

/**
 * Class DCATTemporal.
 *
 * Represents the complex entity DCATTemporal. It consists of three properties: 'start', 'end' and
 * 'label'. At least one of these three must be provided.
 *
 * This property represent a point or period in time. When both start and end are provided it
 * represents a period in time from the given start date until the given end date. When only start
 * is provided, it presents a single point in time. When only end is provided it represents a period
 * of time ending at the given end date.
 */
class DCATTemporal extends DCATComplexEntity
{
    /** @var string[] */
    protected static $PROPERTIES = [
        'start', 'end', 'label',
    ];

    /** @var string[] */
    protected static $REQUIRED_PROPERTIES = [
    ];

    /** @var DCATDateTime */
    protected $start;

    /** @var DCATDateTime */
    protected $end;

    /** @var DCATLiteral */
    protected $label;

    /**
     * DCATTemporal constructor.
     */
    public function __construct()
    {
        parent::__construct(self::$PROPERTIES, self::$REQUIRED_PROPERTIES);
    }

    /**
     * Determines and returns whether or not the DCATTemporal is valid.
     *
     * A DCATTemporal is considered valid when:
     * - It passes the validation as defined in `DCATComplexEntity::validate()`
     * - The value of `$this->start` is smaller than `$this->end`, assuming both are present
     *
     * @see DCATComplexEntity::validate()
     *
     * @return DCATValidationResult The validation result of this DCATTemporal
     */
    public function validate(): DCATValidationResult
    {
        $result = parent::validate();

        if (null == $this->start || null == $this->end) {
            return $result;
        }

        try {
            $start_date = new DateTime($this->start->getData());
            $end_date   = new DateTime($this->end->getData());

            if ($start_date >= $end_date) {
                $result->addMessage(
                    'start must be smaller than end; got ' . $this->start->getData() . ' and ' .
                    $this->end->getData()
                );
            }
        } catch (Exception $e) {
            $result->addMessage('failed to convert a temporal property into a DateTime object');
        }

        return $result;
    }

    /**
     * Getter for the start property, may return null.
     *
     * @return null|DCATDateTime The start property
     */
    public function getStart(): ?DCATDateTime
    {
        return $this->start;
    }

    /**
     * Getter for the end property, may return null.
     *
     * @return null|DCATDateTime The end property
     */
    public function getEnd(): ?DCATDateTime
    {
        return $this->end;
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
     * Setter for the start property.
     *
     * @param DCATDateTime $start The value to set
     */
    public function setStart(DCATDateTime $start): void
    {
        $this->start = $start;
    }

    /**
     * Setter for the end property.
     *
     * @param DCATDateTime $end The value to set
     */
    public function setEnd(DCATDateTime $end): void
    {
        $this->end = $end;
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
