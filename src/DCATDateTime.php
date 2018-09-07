<?php

namespace DCAT_AP_DONL;

use DateTime;


/**
 * Class DCATDateTime
 *
 * Represents a DCATProperty as a datetime value.
 *
 * @package DCAT_AP_DONL
 */
class DCATDateTime extends DCATProperty {

    /** @var string */
    protected $format;

    /**
     * DCATDateTime constructor.
     *
     * @param string $name The name of this DCAT datetime
     * @param string $value The value of this DCAT datetime
     * @param string $format The format of this DCAT datetime, defaults to
     * 'Y-m-d\tH:i:s'
     */
    public function __construct(string $name, string $value,
                                string $format = 'Y-m-d\TH:i:s')
    {
        parent::__construct($name, $value);
        $this->format = $format;
    }

    /**
     * Determines and returns whether or not the `DCATDateTime` is valid.
     *
     * A `DCATDateTime` is considered valid when:
     * - it passes the validation as defined in `DCATProperty::validate()`
     * - its value property matches the datetime format given
     *
     * @see DCATProperty::validate()
     * @return DCATValidationResult The validation result of this DCAT datetime
     */
    public function validate(): DCATValidationResult
    {
        $result = parent::validate();

        if (!$this->isDateTime()) {
            $result->addMessage(
                sprintf(
                    '%s: value %s is not conform the given format %s',
                    $this->getName(), $this->getData(), $this->getFormat()
                )
            );
        }

        return $result;
    }

    /**
     * Retrieves the format of the `DCATDateTime`.
     *
     * @return string The format this DCAT datetime
     */
    public function getFormat(): string
    {
        return $this->format;
    }

    /**
     * Checks if the `$this->value` property follows the format as defined by
     * `$this->format`.
     *
     * @return bool Whether or not this value matches the given format
     */
    protected function isDateTime(): bool
    {
        return DateTime::createFromFormat($this->format, $this->value) != false;
    }

}
