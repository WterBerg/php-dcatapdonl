<?php

use DCAT_AP_DONL\DCATComplexEntity;
use DCAT_AP_DONL\DCATLiteral;
use PHPUnit\Framework\TestCase;

class DCATComplexEntityTest extends TestCase
{
    public function testMultiValuedRequiredPropertyIsInvalidWhenEmpty(): void
    {
        $entity = new class('TestName') extends DCATComplexEntity {
            protected $myProperty;

            public function __construct(string $name)
            {
                parent::__construct(['myProperty'], ['myProperty']);
                $this->myProperty = [];
            }

            public function addMyProperty(DCATLiteral $myProperty): void
            {
                $this->myProperty[] = $myProperty;
            }
        };

        $this->assertEquals(
            ['myProperty is empty'],
            $entity->validate()->getMessages()
        );
    }

    public function testMultiValuedRequiredPropertiesHaveIndividualValidation(): void
    {
        $entity = new class('TestName') extends DCATComplexEntity {
            protected $myProperty;

            public function __construct(string $name)
            {
                parent::__construct(['myProperty'], ['myProperty']);
                $this->myProperty = [];
            }

            public function addMyProperty(DCATLiteral $myProperty): void
            {
                $this->myProperty[] = $myProperty;
            }
        };
        $entity->addMyProperty(new DCATLiteral('myValue'));
        $entity->addMyProperty(new DCATLiteral(''));

        $this->assertEquals(
            ['value is empty'],
            $entity->validate()->getMessages()
        );
    }
}
