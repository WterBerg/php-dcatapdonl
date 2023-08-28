<?php

declare(strict_types=1);

namespace DCAT_AP_DONL;

use DateTime;

/**
 * Class DCATDateTime.
 *
 * Represents a DCATLiteral as a datetime value.
 */
class DCATDateTime extends DCATLiteral
{
    /**
     * DCATDateTime constructor.
     *
     * @param string $value  The value of this DCAT datetime
     * @param string $format The format of this DCAT datetime, defaults to 'Y-m-d\TH:i:s'
     */
    public function __construct(string $value, protected string $format = 'Y-m-d\TH:i:s')
    {
        parent::__construct($value);
    }

    /**
     * Determines and returns whether the DCATDateTime is valid.
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
     * @return bool Whether this value matches the given format
     */
    protected function isDateTime(): bool
    {
        return false !== DateTime::createFromFormat($this->format, $this->value);
    }
}
