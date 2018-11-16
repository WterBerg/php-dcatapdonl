<?php

namespace DCAT_AP_DONL;

/**
 * Class DCATURI.
 *
 * Represents a DCATLiteral as an URI.
 */
class DCATURI extends DCATLiteral
{
    /**
     * Determines and returns whether or not the DCATURI is valid.
     *
     * A DCATURI is considered valid when:
     * - it passes the validation as defined in `DCATLiteral::validate()`
     * - its value looks and smells like an URL, the URL does not need to be reachable
     *
     * @see DCATLiteral::validate()
     *
     * @return DCATValidationResult The validation result of this DCAT URI
     */
    public function validate(): DCATValidationResult
    {
        $result = parent::validate();

        if (!$this->isURI($this->value)) {
            $result->addMessage(
                sprintf('value %s is not a valid URI', $this->value)
            );
        }

        return $result;
    }

    /**
     * Checks if the given value matches the pattern of an URI.
     *
     * @param string $uri The potential URI to check
     *
     * @return bool Whether or the not the given value looks like an URI
     */
    protected function isURI(string $uri): bool
    {
        return false !== filter_var($uri, FILTER_VALIDATE_URL);
    }
}
