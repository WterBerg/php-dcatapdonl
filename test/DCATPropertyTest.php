<?php

use PHPUnit\Framework\TestCase;
use DCAT_AP_DONL\DCATProperty;


class DCATPropertyTest extends TestCase {

    public function testTheValueCanBeSet(): void
    {
        $property = new DCATProperty('TestProperty', 'TestValue');

        $this->assertEquals('TestValue', $property->getData());
    }

    public function testTheValueCannotBeNull(): void
    {
        $property = new DCATProperty('TestProperty', null);
        $validation = $property->validate();

        $this->assertEquals(['TestProperty: value is missing'], $validation->getMessages());
    }

    public function testTheValueCannotBeEmpty(): void
    {
        $property = new DCATProperty('TestProperty', '');
        $validation = $property->validate();

        $this->assertEquals(['TestProperty: value is empty'], $validation->getMessages());
    }

    public function testTheValueCannotContainOnlySpaces(): void
    {
        $property = new DCATProperty('TestProperty', '   ');
        $validation = $property->validate();

        $this->assertEquals(['TestProperty: value is empty'], $validation->getMessages());
    }

    public function testTheValueGetsStrippedOfLeadingAndEndingSpaces(): void
    {
        $property = new DCATProperty('TestProperty', ' TestValue ');

        $this->assertEquals('TestValue', $property->getData());
    }

}
