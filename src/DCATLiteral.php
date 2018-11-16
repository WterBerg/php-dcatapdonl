<?php

namespace DCAT_AP_DONL;

/**
 * Class DCATLiteral.
 *
 * Represents the value of any DCAT property.
 */
class DCATLiteral implements DCATEntity
{
    /** @var string */
    protected $value;

    /**
     * DCATLiteral constructor.
     *
     * @param null|string $value The value of this DCATLiteral, the value will be trimmed
     */
    public function __construct(string $value = null)
    {
        if (null !== $value) {
            $this->value = \trim($value);
        }
    }

    /**
     * Returns the data of the DCATLiteral as a string.
     *
     * @return null|string The data of the DCATLiteral
     */
    public function getData(): ?string
    {
        return $this->value;
    }

    /**
     * Determines and returns whether or not the DCATLiteral is valid.
     *
     * A DCATLiteral is considered valid when:
     * - its value property is a non-empty trimmed string.
     *
     * @return DCATValidationResult The validation result of this DCATLiteral
     */
    public function validate(): DCATValidationResult
    {
        $result = new DCATValidationResult();

        if (null === $this->value) {
            $result->addMessage('value is missing');

            return $result;
        }

        if (empty($this->value)) {
            $result->addMessage('value is empty');
        }

        return $result;
    }
}
