<?php

namespace DCAT_AP_DONL;

use DateTime;

/**
 * Class DCATDateTime.
 *
 * Represents a DCATLiteral as a datetime value.
 */
class DCATDateTime extends DCATLiteral
{
    /** @var string */
    protected $format;

    /**
     * DCATDateTime constructor.
     *
     * @param string $value  The value of this DCAT datetime
     * @param string $format The format of this DCAT datetime, defaults to 'Y-m-d\TH:i:s'
     */
    public function __construct(string $value, string $format = 'Y-m-d\TH:i:s')
    {
        parent::__construct($value);
        $this->format = $format;
    }

    /**
     * Determines and returns whether or not the DCATDateTime is valid.
     *
     * A DCATDateTime is considered valid when:
     * - it passes the validation as defined in `DCATLiteral::validate()`
     * - its value property matches the datetime format given
     *
     * @see DCATLiteral::validate()
     *
     * @return DCATValidationResult The validation result of this DCATDateTime
     */
    public function validate(): DCATValidationResult
    {
        $result = parent::validate();

        if (!$this->isDateTime()) {
            $result->addMessage(
                'value ' . $this->getData() . ' is not conform the given format ' .
                $this->getFormat()
            );
        }

        return $result;
    }

    /**
     * Retrieves the format of the DCATDateTime.
     *
     * @return string The format this DCAT datetime
     */
    public function getFormat(): string
    {
        return $this->format;
    }

    /**
     * Checks if the `$this->value` property follows the format as defined by `$this->format`.
     *
     * @return bool Whether or not this value matches the given format
     */
    protected function isDateTime(): bool
    {
        return false !== DateTime::createFromFormat($this->format, $this->value);
    }
}
