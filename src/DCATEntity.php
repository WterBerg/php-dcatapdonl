<?php

namespace DCAT_AP_DONL;


/**
 * Class DCATEntity
 *
 * Represents any DCAT entity.
 *
 * @package DCAT_AP_DONL
 */
abstract class DCATEntity {

    /** @var string */
    protected $name;

    /**
     * DCATEntity constructor
     *
     * @param string $name The name of the DCAT entity
     */
    protected function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * Returns the name of the DCATEntity.
     *
     * @return string The name of the DCAT entity
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Returns the data of the DCATEntity.
     *
     * @return mixed The data of the DCATEntity
     */
    abstract public function getData();

    /**
     * Determines and returns whether or not the DCATEntity is valid.
     *
     * @return DCATValidationResult The validation result of this DCAT entity
     */
    abstract public function validate(): DCATValidationResult;

}
