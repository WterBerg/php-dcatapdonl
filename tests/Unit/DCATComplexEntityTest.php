<?php

/**
 * This file is part of the wterberg/dcat-ap-donl package.
 *
 * This source file is subject to the license that is
 * bundled with this source code in the LICENSE.md file.
 */

namespace Tests\Unit;

use DCAT_AP_DONL\DCATComplexEntity;
use DCAT_AP_DONL\DCATLiteral;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class DCATComplexEntityTest extends TestCase
{
    public function testMultiValuedRequiredPropertyIsInvalidWhenEmpty(): void
    {
        $entity = new class () extends DCATComplexEntity {
            protected $myProperty;

            public function __construct()
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
            ['myProperty: value is empty'],
            $entity->validate()->getMessages()
        );
    }

    public function testMultiValuedRequiredPropertiesHaveIndividualValidation(): void
    {
        $entity = new class ('TestName') extends DCATComplexEntity {
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
            ['myProperty: value is empty'],
            $entity->validate()->getMessages()
        );
    }

    public function testMultiValuedPropertiesArePartOfTheDataObject(): void
    {
        $entity = new class ('TestName') extends DCATComplexEntity {
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

        $this->assertTrue(is_array($entity->getData()['myProperty']));
    }
}
