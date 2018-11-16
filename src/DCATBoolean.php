<?php

namespace DCAT_AP_DONL;

/**
 * Class DCATBoolean.
 *
 * Represents a boolean value.
 */
class DCATBoolean extends DCATLiteral
{
    const TRUE  = 'True';
    const FALSE = 'False';

    /**
     * Determines and returns whether or not the DCATBoolean is valid.
     *
     * A DCATBoolean is considered valid when:
     * - it passes the validation as defined in `DCATLiteral::validate()`
     * - its value is one of [ `DCATBoolean::TRUE`, `DCATBoolean::FALSE` ]
     *
     * @see DCATLiteral::validate()
     *
     * @return DCATValidationResult The validation result of this DCATBoolean
     */
    public function validate(): DCATValidationResult
    {
        $result = parent::validate();

        if ($this->value && !\in_array($this->value, [self::TRUE, self::FALSE])) {
            $result->addMessage(
                \sprintf(
                    'value is not one of [ %s, %s ]', self::TRUE, self::FALSE
                )
            );
        }

        return $result;
    }
}
