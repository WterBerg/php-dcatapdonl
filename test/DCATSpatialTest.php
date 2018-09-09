<?php

use PHPUnit\Framework\TestCase;
use DCAT_AP_DONL\DCATSpatial;


class DCATSpatialTest extends TestCase {

    public function testBothSchemeAndValueAreRequired(): void
    {
        $spatial = new DCATSpatial();

        $this->assertEquals(
            [
                'Spatial: scheme is missing',
                'Spatial: value is missing',
                'Spatial: at least one property must be provided'
            ],
            $spatial->validate()->getMessages()
        );
    }

}
