<?php

declare(strict_types=1);

/**
 * This file is part of the wterberg/dcat-ap-donl package.
 *
 * This source file is subject to the license that is
 * bundled with this source code in the LICENSE.md file.
 */

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
