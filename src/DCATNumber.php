<?php

namespace DCAT_AP_DONL;


/**
 * Class DCATNumber
 *
 * Represents a DCATProperty as a number.
 *
 * @package DCAT_AP_DONL
 */
class DCATNumber extends DCATProperty {

    /**
     * Determines and returns whether or not the DCATNumber is valid.
     *
     * A DCATNumber is considered valid when:
     * - it passes the validation as defined in `DCATProperty::validate()`
     * - its value property, cast as an int, is greater than 0
     *
     * @see DCATProperty::validate()
     * @return DCATValidationResult The validation result of this DCAT number
     */
    public function validate(): DCATValidationResult
    {
        $result = parent::validate();

        if ((int)$this->value <= 0) {
            $result->addMessage(
                sprintf(
                    '%s: value must be a positive integer',
                    $this->getName()
                )
            );
        }

        return $result;
    }

}
