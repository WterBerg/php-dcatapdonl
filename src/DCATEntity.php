<?php

declare(strict_types=1);

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
    public function getData(): mixed;

    /**
     * Determines and returns whether the DCATEntity is considered valid.
     *
     * @return DCATValidationResult The validation result of this DCAT entity
     */
    public function validate(): DCATValidationResult;
}
