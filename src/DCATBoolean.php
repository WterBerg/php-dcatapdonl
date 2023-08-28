<?php

declare(strict_types=1);

namespace DCAT_AP_DONL;

/**
 * Class DCATBoolean.
 *
 * Represents a boolean value.
 */
class DCATBoolean extends DCATLiteral
{
    /**
     * String representation of a truthy value.
     *
     * @var string
     */
    public const TRUE  = 'true';

    /**
     * String representation of a falsy value.
     *
     * @var string
     */
    public const FALSE = 'false';

    /**
     * The acceptable values this instance can hold.
     *
     * @var string[]
     */
    private static array $ACCEPTABLE_VALUES = [self::TRUE, self::FALSE];

    /**
     * Determines and returns whether the DCATBoolean is valid.
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

        if ($this->value && !in_array($this->value, self::$ACCEPTABLE_VALUES)) {
            $result->addMessage('value is not one of ' . implode(', ', self::$ACCEPTABLE_VALUES));
        }

        return $result;
    }
}
