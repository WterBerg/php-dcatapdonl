<?php

use PHPUnit\Framework\TestCase;
use DCAT_AP_DONL\DCATEntity;


class DCATEntityTest extends TestCase {

    public function testTheEntityHasAName(): void
    {
        $entity = new class('TestName') extends DCATEntity {
            public function __construct(string $name)
            {
                parent::__construct($name);
            }

            public function getData() { return null; }
            public function validate(): \DCAT_AP_DONL\DCATValidationResult { return null; }
        };

        $this->assertEquals('TestName', $entity->getName());
    }

}
