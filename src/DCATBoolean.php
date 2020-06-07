<?php

namespace DCAT_AP_DONL;

/**
 * Class DCATBoolean.
 *
 * Represents a boolean value.
 */
class DCATBoolean extends DCATLiteral
{
    /** @var string */
    const TRUE  = 'true';

    /** @var string */
    const FALSE = 'false';

    /** @var string[] */
    private $acceptableValues;

    /**
     * {@inheritdoc}
     */
    public function __construct(string $value = null)
    {
        parent::__construct($value);

        $this->acceptableValues = [self::TRUE, self::FALSE];
    }

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

        if ($this->value && !in_array($this->value, $this->acceptableValues)) {
            $result->addMessage(sprintf(
                'value is not one of [ %s ]', join(', ', $this->acceptableValues)
            ));
        }

        return $result;
    }
}
