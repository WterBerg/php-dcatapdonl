<?php

declare(strict_types=1);

namespace DCAT_AP_DONL;

/**
 * Class DCATLiteral.
 *
 * Represents the value of any DCAT property.
 */
class DCATLiteral implements DCATEntity
{
    /**
     * DCATLiteral constructor.
     *
     * @param null|string $value The value of this DCATLiteral, the value will be trimmed
     */
    public function __construct(protected ?string $value = null)
    {
        if (!is_null($this->value)) {
            $this->value = trim($this->value);
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
     * Determines and returns whether the DCATLiteral is valid.
     *
     * A DCATLiteral is considered valid when:
     * - its value property is a non-empty trimmed string.
     *
     * @return DCATValidationResult The validation result of this DCATLiteral
     */
    public function validate(): DCATValidationResult
    {
        $result = new DCATValidationResult();

        if (is_null($this->value)) {
            $result->addMessage('value is missing');

            return $result;
        }

        if (0 === strlen($this->value)) {
            $result->addMessage('value is empty');
        }

        return $result;
    }
}
