<?php

namespace DCAT_AP_DONL;


class DCATBoolean extends DCATProperty {

    const TRUE = 'True';
    const FALSE = 'False';

    /**
     * Determines and returns whether or not the DCATBoolean is valid.
     *
     * A DCATBoolean is considered valid when:
     * - it passes the validation as defined in `DCATProperty::validate()`
     * - its value is one of [ `DCATBoolean::TRUE`, `DCATBoolean::FALSE` ]
     *
     * @see DCATProperty::validate()
     * @return DCATValidationResult The validation result of this DCAT URI
     */
    public function validate(): DCATValidationResult
    {
        $result = parent::validate();

        if ($this->value && !in_array($this->value, [self::TRUE, self::FALSE])) {
            $result->addMessage(
                sprintf(
                    '%s: value is not one of [ %s, %s ]',
                    $this->getName(), self::TRUE, self::FALSE
                )
            );
        }

        return $result;
    }

}
