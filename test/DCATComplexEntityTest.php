<?php

use PHPUnit\Framework\TestCase;
use DCAT_AP_DONL\DCATEntity;
use DCAT_AP_DONL\DCATProperty;
use DCAT_AP_DONL\DCATComplexEntity;


class DCATComplexEntityTest extends TestCase {

    public function testComplexEntitiesAreStillEntities(): void
    {
        $entity = new class('TestName') extends DCATComplexEntity {
            public function __construct(string $name)
            {
                parent::__construct($name, [], []);
            }
        };

        $this->assertEquals('TestName', $entity->getName());
        $this->assertTrue($entity instanceof DCATEntity);
    }

    public function testDoesNotStripInvalidRequiredProperties(): void
    {
        $entity = new class('TestName') extends DCATComplexEntity {

            protected $myProperty;

            public function __construct(string $name)
            {
                parent::__construct($name, ['myProperty'], ['myProperty']);
            }

            public function setMyProperty(DCATProperty $myProperty): void
            {
                $this->myProperty = $myProperty;
            }

        };

        $entity->setMyProperty(new DCATProperty('myProperty', ''));

        $this->assertFalse($entity->validate()->validated());
        $data = $entity->getData();

        $entity->stripInvalidOptionalProperties();

        $this->assertEquals($data, $entity->getData());
    }

    public function testIgnoredUnsetOptionalProperties(): void
    {
        $entity = new class('TestName') extends DCATComplexEntity {

            protected $myProperty;

            public function __construct(string $name)
            {
                parent::__construct($name, ['myProperty'], []);
            }

            public function setMyProperty(DCATProperty $myProperty): void
            {
                $this->myProperty = $myProperty;
            }

        };

        $propertiesStripped = $entity->stripInvalidOptionalProperties();

        $this->assertEquals(0, count($propertiesStripped));
    }

    public function testStripOptionalPropertiesIgnoresNonDCATEntities(): void
    {
        $entity = new class('TestName') extends DCATComplexEntity {

            protected $myProperty;

            public function __construct(string $name)
            {
                parent::__construct($name, ['myProperty'], []);
            }

            public function setMyProperty(int $myProperty): void
            {
                $this->myProperty = $myProperty;
            }

        };
        $entity->setMyProperty(5);
        $propertiesStripped = $entity->stripInvalidOptionalProperties();

        $this->assertEquals([], $propertiesStripped);
    }

    public function testStripOptionalPropertiesIgnoresValidProperties(): void
    {
        $entity = new class('TestName') extends DCATComplexEntity {

            protected $myProperty;

            public function __construct(string $name)
            {
                parent::__construct($name, ['myProperty'], []);
            }

            public function setMyProperty(DCATProperty $myProperty): void
            {
                $this->myProperty = $myProperty;
            }

        };
        $entity->setMyProperty(new DCATProperty('myProperty', 'myValue'));
        $propertiesStripped = $entity->stripInvalidOptionalProperties();

        $this->assertEquals([], $propertiesStripped);
    }

    public function testInvalidOptionalPropertiesAreRemoved(): void
    {
        $entity = new class('TestName') extends DCATComplexEntity {

            protected $myProperty;

            public function __construct(string $name)
            {
                parent::__construct($name, ['myProperty'], []);
            }

            public function setMyProperty(DCATProperty $myProperty): void
            {
                $this->myProperty = $myProperty;
            }

        };
        $entity->setMyProperty(new DCATProperty('myProperty', ''));

        $propertiesStripped = $entity->stripInvalidOptionalProperties();

        $this->assertEquals(['myProperty'], $propertiesStripped);
    }

    public function testRemovesInvalidMultivaluedProperties(): void
    {
        $entity = new class('TestName') extends DCATComplexEntity {

            protected $myProperty;

            public function __construct(string $name)
            {
                parent::__construct($name, ['myProperty'], []);
                $this->myProperty = [];
            }

            public function addMyProperty(DCATProperty $myProperty): void
            {
                $this->myProperty[] = $myProperty;
            }

        };
        $entity->addMyProperty(new DCATProperty('myProperty', ''));
        $entity->addMyProperty(new DCATProperty('myProperty', 'MyValue'));
        $entity->addMyProperty(new DCATProperty('myProperty', 'MyValue2'));

        $propertiesStripped = $entity->stripInvalidOptionalProperties();

        $this->assertEquals(['myProperty'], $propertiesStripped);
        $this->assertEquals(
            ['myProperty' => ['MyValue', 'MyValue2']],
            $entity->getData()
        );
    }

    public function testMultiValuedRequiredPropertyIsInvalidWhenEmpty(): void
    {
        $entity = new class('TestName') extends DCATComplexEntity {

            protected $myProperty;

            public function __construct(string $name)
            {
                parent::__construct($name, ['myProperty'], ['myProperty']);
                $this->myProperty = [];
            }

            public function addMyProperty(DCATProperty $myProperty): void
            {
                $this->myProperty[] = $myProperty;
            }

        };

        $this->assertEquals(
            ['TestName: myProperty is empty'],
            $entity->validate()->getMessages()
        );
    }

    public function testMultiValuedRequiredPropertiesHaveIndividualValidation(): void
    {
        $entity = new class('TestName') extends DCATComplexEntity {

            protected $myProperty;

            public function __construct(string $name)
            {
                parent::__construct($name, ['myProperty'], ['myProperty']);
                $this->myProperty = [];
            }

            public function addMyProperty(DCATProperty $myProperty): void
            {
                $this->myProperty[] = $myProperty;
            }

        };
        $entity->addMyProperty(new DCATProperty('myProperty', 'myValue'));
        $entity->addMyProperty(new DCATProperty('myProperty', ''));

        $this->assertEquals(
            ['TestName: myProperty: value is empty'],
            $entity->validate()->getMessages()
        );
    }

}
