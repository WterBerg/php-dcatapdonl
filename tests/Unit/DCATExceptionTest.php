<?php

/**
 * This file is part of the wterberg/dcat-ap-donl package.
 *
 * This source file is subject to the license that is
 * bundled with this source code in the LICENSE.md file.
 */

namespace Tests\Unit;

use DCAT_AP_DONL\DCATException;
use Exception;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class DCATExceptionTest extends TestCase
{
    public function testIsDerivedOfExceptionClass(): void
    {
        $this->assertTrue(new DCATException() instanceof Exception);
    }
}
