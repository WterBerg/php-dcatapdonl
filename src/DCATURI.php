<?php

declare(strict_types=1);

/**
 * This file is part of the wterberg/dcat-ap-donl package.
 *
 * This source file is subject to the license that is
 * bundled with this source code in the LICENSE.md file.
 */

namespace DCAT_AP_DONL;

/**
 * Class DCATURI.
 *
 * Represents a DCATLiteral as a URI.
 */
class DCATURI extends DCATLiteral
{
    /**
     * Determines and returns whether the DCATURI is valid.
     *
     * A DCATURI is considered valid when:
     * - it passes the validation as defined in `DCATLiteral::validate()`
     * - its value looks and smells like a URL, the URL does not need to be reachable
     *
     * @see DCATLiteral::validate()
     *
     * @return DCATValidationResult The validation result of this DCAT URI
     */
    public function validate(): DCATValidationResult
    {
        $result = parent::validate();

        if (!$this->isURI($this->value)) {
            $result->addMessage('value ' . $this->value . ' is not a valid URI');
        }

        return $result;
    }

    /**
     * Checks if the given value matches the pattern of a URI.
     *
     * @param null|string $uri The potential URI to check
     *
     * @return bool Whether the given value looks like a URI
     */
    protected function isURI(?string $uri): bool
    {
        return !is_null($uri) && false !== filter_var($uri, FILTER_VALIDATE_URL);
    }
}
