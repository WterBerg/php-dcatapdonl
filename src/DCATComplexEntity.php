<?php

namespace DCAT_AP_DONL;


/**
 * Class DCATComplexEntity
 *
 * Represents a complex DCAT entity. A entity is considered complex when it contains more than a
 * single value.
 *
 * It is important to note that implementations of the DCATComplexEntity do not have to respect
 * the name property of the DCATEntities contained within. They may be set to names in order to fit
 * that particular implementation.
 *
 * @package DCAT_AP_DONL
 */
abstract class DCATComplexEntity extends DCATEntity {

    /** @var string[] */
    protected $properties;

    /** @var string[] */
    protected $requiredProperties;

    /**
     * DCATComplexEntity constructor.
     *
     * @param string $name The name of the DCATEntity
     * @param string[] $properties The properties of the DCATComplexEntity
     * @param string[] $requiredProperties The properties which are required
     */
    public function __construct(string $name, array $properties, array $requiredProperties)
    {
        parent::__construct($name);

        $this->properties = $properties;
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

            if ($prop == null) {
                continue;
            }

            if (is_array($prop)) {
                foreach ($prop as $value) {
                    /** @var DCATEntity $value */
                    $data[$value->getName()][] = $value->getData();
                }

                continue;
            }

            /** @var DCATEntity $prop */
            $data[$prop->getName()] = $prop->getData();
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
        $result = new DCATValidationResult();
        $propertiesPresent = false;

        foreach ($this->properties as $property) {
            $prop = $this->$property;

            if ($prop !== null || (is_array($this->$property) && count($this->$property) > 0)) {
                $propertiesPresent = true;
            }

            if ($prop === null) {
                if (in_array($property, $this->requiredProperties)) {
                    $result->addMessage(
                        sprintf('%s: %s is missing', $this->getName(), $property)
                    );
                }

                continue;
            }

            if (is_array($prop)) {
                if (count($prop) == 0 && in_array($property, $this->requiredProperties)) {
                    $result->addMessage(
                        sprintf('%s: %s is empty', $this->getName(), $property)
                    );

                    continue;
                }

                foreach ($prop as $arrayElement) {
                    /** @var DCATEntity $arrayElement */
                    $messages = $arrayElement->validate()->getMessages();

                    for ($i = 0; $i < count($messages); $i++) {
                        $result->addMessage(
                            sprintf('%s: %s', $this->getName(), $messages[$i])
                        );
                    }
                }

                continue;
            }

            /** @var DCATEntity $prop */
            $messages = $prop->validate()->getMessages();
            for ($i = 0; $i < count($messages); $i++) {
                $result->addMessage(sprintf('%s: %s', $this->getName(), $messages[$i]));
            }
        }

        if (!$propertiesPresent) {
            $result->addMessage(
                sprintf('%s: at least one property must be provided', $this->getName())
            );
        }

        return $result;
    }

    /**
     * Removes all the optional properties of the DCATComplexEntity which do not pass their
     * individual validation.
     *
     * @return string[] The properties removed
     */
    public function stripInvalidOptionalProperties(): array
    {
        $stripped = [];

        foreach ($this->properties as $property) {
            if ($this->$property == null) {
                continue;
            }

            if (!$this->$property instanceof DCATEntity && !is_array($this->$property)) {
                continue;
            }

            if (in_array($property, $this->requiredProperties)) {
                continue;
            }

            if (is_array($this->$property)) {
                for ($i = 0; $i <= count($this->$property); $i++) {
                    if ($this->$property[$i]->validate()->validated()) {
                        continue;
                    }

                    $stripped[] = $this->$property[$i]->getName();
                    unset($this->$property[$i]);
                }

                return $stripped;
            }

            if ($this->$property->validate()->validated()) {
                continue;
            }

            $this->$property = null;
            $stripped[] = $property;
        }

        return $stripped;
    }

}
