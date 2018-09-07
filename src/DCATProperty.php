<?php

namespace DCAT_AP_DONL;


/**
 * Class DCATProperty
 *
 * Represents an individual DCAT property.
 *
 * @package DCAT_AP_DONL
 */
class DCATProperty extends DCATEntity {

    /** @var string */
    protected $value;

    /**
     * DCATProperty constructor.
     *
     * @param string $name The name of this DCAT property
     * @param null|string $value The value of this DCAT property, the value will be trimmed
     */
    public function __construct(string $name, string $value = null)
    {
        parent::__construct($name);

        if ($value !== null) {
            $this->value = trim($value);
        }
    }

    /**
     * Returns the data of the DCATProperty as a string.
     *
     * @return null|string The data of the DCATProperty
     */
    public function getData(): ?string
    {
        return $this->value;
    }

    /**
     * Determines and returns whether or not the DCATProperty is valid.
     *
     * A DCATProperty is considered valid when:
     * - its value property is a non-empty trimmed string.
     *
     * @return DCATValidationResult The validation result of this DCAT property
     */
    public function validate(): DCATValidationResult
    {
        $result = new DCATValidationResult();

        if ($this->value === null) {
            $result->addMessage(sprintf('%s: value is missing', $this->getName()));

            return $result;
        }

        if (empty($this->value)) {
            $result->addMessage(sprintf('%s: value is empty', $this->getName()));
        }

        return $result;
    }

}
