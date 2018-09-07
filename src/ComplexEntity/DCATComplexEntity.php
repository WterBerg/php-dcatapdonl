<?php

namespace DCAT_AP_DONL\ComplexEntities;

use DCAT_AP_DONL\DCATEntity;


/**
 * Class DCATComplexEntity
 *
 * Represents a complex DCAT entity. A entity is considered complex when it
 * contains more than a single value.
 *
 * @package DCAT_AP_DONL\ComplexEntities
 */
abstract class DCATComplexEntity extends DCATEntity {

    /**
     * Returns the DCATComplexEntity as a KeyValue array.
     *
     * @return array A key => value array of the entity
     */
    abstract public function getData(): array;

}
