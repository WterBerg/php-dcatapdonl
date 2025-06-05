<?php

/**
 * This file is part of the wterberg/dcat-ap-donl package.
 *
 * This source file is subject to the license that is
 * bundled with this source code in the LICENSE.md file.
 */

namespace Tests\Unit;

use DCAT_AP_DONL\DCATBoolean;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class DCATBooleanTest extends TestCase
{
    public function testAcceptsTrueValues(): void
    {
        $const_bool = new DCATBoolean(DCATBoolean::TRUE);
        $str_bool   = new DCATBoolean('true');

        $this->assertTrue($const_bool->validate()->validated());
        $this->assertTrue($str_bool->validate()->validated());
    }

    public function testAcceptsFalseValues(): void
    {
        $const_bool = new DCATBoolean(DCATBoolean::FALSE);
        $str_bool   = new DCATBoolean('false');

        $this->assertTrue($const_bool->validate()->validated());
        $this->assertTrue($str_bool->validate()->validated());
    }

    public function testDeclinesNonBooleanValues(): void
    {
        $false_bool = new DCATBoolean('False');
        $true_bool  = new DCATBoolean('True');

        $this->assertFalse($false_bool->validate()->validated());
        $this->assertFalse($true_bool->validate()->validated());
    }
}
