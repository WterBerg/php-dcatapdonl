<?php

use PHPUnit\Framework\TestCase;
use DCAT_AP_DONL\DCATEntity;
use DCAT_AP_DONL\DCATValidationResult;
use DCAT_AP_DONL\DCATComplexEntity;


class DCATComplexEntityTest extends TestCase {

    public function testComplexEntitiesAreStillEntities(): void
    {
        $entity = new class('TestName') extends DCATComplexEntity {
            public function __construct(string $name)
            {
                parent::__construct($name, [], []);
            }

            public function getData(): array { return []; }
            public function validate(): DCATValidationResult { return null; }
            public function stripInvalidOptionalProperties(): array { return []; }
        };

        $this->assertEquals('TestName', $entity->getName());
        $this->assertTrue($entity instanceof DCATEntity);
    }

}
