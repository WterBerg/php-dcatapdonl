<?php

namespace DCAT_AP_DONL;

/**
 * Interface DCATEntity.
 *
 * Represents any DCAT entity.
 */
interface DCATEntity
{
    /**
     * Returns the data of the DCATEntity.
     *
     * @return mixed The data of the DCATEntity
     */
    public function getData();

    /**
     * Determines and returns whether or not the DCATEntity is considered valid.
     *
     * @return DCATValidationResult The validation result of this DCAT entity
     */
    public function validate(): DCATValidationResult;
}
