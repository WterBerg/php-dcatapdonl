<?php

/**
 * This file is part of the wterberg/dcat-ap-donl package.
 *
 * This source file is subject to the license that is
 * bundled with this source code in the LICENSE.md file.
 */

namespace Tests\Unit;

use DCAT_AP_DONL\DCATLiteral;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class DCATLiteralTest extends TestCase
{
    public function testTheValueCanBeSet(): void
    {
        $property = new DCATLiteral('TestValue');

        $this->assertEquals('TestValue', $property->getData());
    }

    public function testTheValueCannotBeNull(): void
    {
        $property   = new DCATLiteral(null);
        $validation = $property->validate();

        $this->assertEquals(['value is missing'], $validation->getMessages());
    }

    public function testTheValueCannotBeEmpty(): void
    {
        $property   = new DCATLiteral('');
        $validation = $property->validate();

        $this->assertEquals(['value is empty'], $validation->getMessages());
    }

    public function testTheValueCannotContainOnlySpaces(): void
    {
        $property   = new DCATLiteral('   ');
        $validation = $property->validate();

        $this->assertEquals(['value is empty'], $validation->getMessages());
    }

    public function testTheValueGetsStrippedOfLeadingAndEndingSpaces(): void
    {
        $property = new DCATLiteral(' TestValue ');

        $this->assertEquals('TestValue', $property->getData());
    }
}
