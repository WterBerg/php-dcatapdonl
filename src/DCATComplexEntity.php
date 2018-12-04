<?php

namespace DCAT_AP_DONL;

/**
 * Class DCATComplexEntity.
 *
 * Represents a complex DCAT entity. A entity is considered complex when it contains more than a
 * single value.
 */
abstract class DCATComplexEntity implements DCATEntity
{
    /** @var string[] */
    protected $properties;

    /** @var string[] */
    protected $requiredProperties;

    /**
     * DCATComplexEntity constructor.
     *
     * @param string[] $properties         The properties of the DCATComplexEntity
     * @param string[] $requiredProperties The properties which are required
     */
    public function __construct(array $properties, array $requiredProperties)
    {
        $this->properties         = $properties;
        $this->requiredProperties = $requiredProperties;

        foreach ($properties as $property) {
            $this->$property = null;
        }
    }

    /**
     * Returns the DCATComplexEntity as a KeyValue array.
     *
     * @return array A key => value array of the entity
     */
    public function getData(): array
    {
        $data = [];

        foreach ($this->properties as $property) {
            $prop = $this->$property;

            if (null == $prop) {
                continue;
            }

            if (\is_array($prop)) {
                foreach ($prop as $value) {
                    /* @var DCATEntity $value */
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
     * Determines and returns whether or not the DCATComplexEntity is valid.
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
            $prop = $this->$property;

            if (null !== $prop || (\is_array($this->$property) && \count($this->$property) > 0)) {
                $propertiesPresent = true;
            }

            if (null === $prop) {
                if (\in_array($property, $this->requiredProperties)) {
                    $result->addMessage(\sprintf('%s: value is missing', $property));
                }

                continue;
            }

            if (\is_array($prop)) {
                if (0 == \count($prop) && \in_array($property, $this->requiredProperties)) {
                    $result->addMessage(\sprintf('%s: value is empty', $property));

                    continue;
                }

                foreach ($prop as $arrayElement) {
                    /** @var DCATEntity $arrayElement */
                    $messages = $arrayElement->validate()->getMessages();

                    for ($i = 0; $i < \count($messages); ++$i) {
                        $result->addMessage(
                            \sprintf('%s: %s', $property, $messages[$i])
                        );
                    }
                }

                continue;
            }

            /** @var DCATEntity $prop */
            $messages = $prop->validate()->getMessages();
            for ($i = 0; $i < \count($messages); ++$i) {
                $result->addMessage(
                    \sprintf('%s: %s', $property, $messages[$i])
                );
            }
        }

        if (!$propertiesPresent) {
            $result->addMessage('at least one property must be provided');
        }

        return $result;
    }
}
