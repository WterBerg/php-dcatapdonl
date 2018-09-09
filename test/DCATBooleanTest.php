<?php

use PHPUnit\Framework\TestCase;
use DCAT_AP_DONL\DCATBoolean;


class DCATBooleanTest extends TestCase {

    public function testOnlyAcceptsTrueOrFalseValues(): void
    {
        $bool = new DCATBoolean('test', DCATBoolean::TRUE);

        $this->assertTrue($bool->validate()->validated());

        $bool = new DCATBoolean('test', DCATBoolean::FALSE);

        $this->assertTrue($bool->validate()->validated());

        $bool = new DCATBoolean('test', 'string');

        $this->assertEquals(
            ['test: value is not one of [ True, False ]'],
            $bool->validate()->getMessages()
        );
    }

}
