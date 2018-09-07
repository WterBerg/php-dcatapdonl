<?php

namespace DCAT_AP_DONL;


/**
 * Class DCATURI
 *
 * Represents a DCATProperty as an URI.
 *
 * @package DCAT_AP_DONL
 */
class DCATURI extends DCATProperty {

    /**
     * Determines and returns whether or not the DCATURI is valid.
     *
     * A DCATURI is considered valid when:
     * - it passes the validation as defined in `DCATProperty::validate()`
     * - its value looks and smells like an URL, the URL does not need to be
     * reachable
     *
     * @see DCATProperty::validate()
     * @return DCATValidationResult The validation result of this DCAT URI
     */
    public function validate(): DCATValidationResult
    {
        $result = parent::validate();

        if (!$this->isURI($this->value)) {
            $result->addMessage(
                sprintf(
                    '%s: value %s is not a valid URI',
                    $this->getName(), $this->value
                )
            );
        }

        return $result;
    }

    /**
     * Checks if the `$this->value` property matches the pattern of an URI.
     *
     * @param string $uri The potential URI to check
     * @return bool Whether or the not the given value looks like an URI
     */
    protected function isURI(string $uri): bool
    {
        return filter_var($uri, FILTER_VALIDATE_URL) !== false;
    }

}
