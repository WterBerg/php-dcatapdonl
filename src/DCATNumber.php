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
 * Class DCATNumber.
 *
 * Represents a DCATLiteral as a number.
 */
class DCATNumber extends DCATLiteral
{
    /**
     * Determines and returns whether the DCATNumber is valid.
     *
     * A DCATNumber is considered valid when:
     * - it passes the validation as defined in `DCATLiteral::validate()`
     * - its value property, cast as an int, is greater than 0
     *
     * @see DCATLiteral::validate()
     *
     * @return DCATValidationResult The validation result of this DCAT number
     */
    public function validate(): DCATValidationResult
    {
        $result = parent::validate();

        if ((int) $this->value <= 0) {
            $result->addMessage('value must be a positive integer');
        }

        return $result;
    }
}
