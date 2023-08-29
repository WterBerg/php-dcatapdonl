<?php

declare(strict_types=1);

namespace DCAT_AP_DONL;

/**
 * Class DCATComplexEntity.
 *
 * Represents a complex DCAT entity. An entity is considered complex when it contains one or more
 * attributes rather than simply representing a value.
 */
abstract class DCATComplexEntity implements DCATEntity
{
    /**
     * DCATComplexEntity constructor.
     *
     * @param string[] $properties         The properties of the DCATComplexEntity
     * @param string[] $requiredProperties The properties which are required
     */
    public function __construct(protected array $properties, protected array $requiredProperties)
    {
        foreach ($this->properties as $property) {
            $this->{$property} = null;
        }
    }

    /**
     * Returns the DCATComplexEntity as a `{attribute} => {value}` array.
     *
     * @return array A key => value array of the entity
     */
    public function getData(): array
    {
        $data = [];

        foreach ($this->properties as $property) {
            $prop = $this->{$property};

            if (is_null($prop)) {
                continue;
            }

            if (is_array($prop)) {
                /* @var DCATEntity[] $prop */
                foreach ($prop as $value) {
                    $data[$property][] = $value->getData();
                }

                continue;
            }

            /* @var DCATEntity $prop */
            $data[$property] = $prop->getData();
        }

        return $data;
    }

    /**
     * Determines and returns whether the DCATComplexEntity is valid.
     *
     * A DCATComplexEntity is considered valid when:
     * - At least one of the properties as defined in `$this->properties` is present
     * - All the properties which are defined in `$this->requiredProperties` are present
     * - All the present properties pass their individual validation
     *
     * @return DCATValidationResult The validation result of this DCATComplexEntity
     */
    public function validate(): DCATValidationResult
    {
        $result            = new DCATValidationResult();
        $propertiesPresent = false;

        foreach ($this->properties as $property) {
            $value = $this->{$property};

            if (!is_null($value) || (is_array($this->{$property}) && count($this->{$property}) > 0)) {
                $propertiesPresent = true;
            }

            if (is_null($value)) {
                if (in_array($property, $this->requiredProperties)) {
                    $result->addMessage($property . ': value is missing');
                }

                continue;
            }

            is_array($value)
                ? $this->addMultivaluedPropertyMessages($property, $value, $result)
                : $this->addSingleValuedPropertyMessage($property, $value, $result);
        }

        if (!$propertiesPresent) {
            $result->addMessage('at least one property must be provided');
        }

        return $result;
    }

    /**
     * Add the validation messages of a single valued property to the validation result.
     *
     * @param string               $name   The name of the DCAT property
     * @param DCATEntity           $value  The value of the DCAT property
     * @param DCATValidationResult $result The validation result so far
     */
    private function addSingleValuedPropertyMessage(string $name, DCATEntity $value,
                                                    DCATValidationResult $result): void
    {
        $messages = $value->validate()->getMessages();

        for ($i = 0; $i < count($messages); ++$i) {
            $result->addMessage($name . ': ' . $messages[$i]);
        }
    }

    /**
     * Add the validation messages of a multivalued property to the validation result.
     *
     * @param string               $name   The name of the DCAT property
     * @param DCATEntity[]         $values The values of the DCAT property
     * @param DCATValidationResult $result The validation result so far
     */
    private function addMultivaluedPropertyMessages(string $name, array $values,
                                                    DCATValidationResult $result): void
    {
        if (0 === count($values) && in_array($name, $this->requiredProperties)) {
            $result->addMessage($name . ': value is empty');

            return;
        }

        foreach ($values as $arrayElement) {
            $messages = $arrayElement->validate()->getMessages();

            for ($i = 0; $i < count($messages); ++$i) {
                $result->addMessage($name . ': ' . $messages[$i]);
            }
        }
    }
}
