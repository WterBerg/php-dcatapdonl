<?php

use PHPUnit\Framework\TestCase;
use DCAT_AP_DONL\DCATURI;


class DCATURITest extends TestCase {

    public function testHttpLinksAreAllowed(): void
    {
        $uri = new DCATURI('Uri', 'http://somesite.com');

        $this->assertTrue($uri->validate()->validated());
    }

    public function testHttpsLinksAreAllowed(): void
    {
        $uri = new DCATURI('Uri', 'https://somesite.com');

        $this->assertTrue($uri->validate()->validated());
    }

    public function testProtocolIsRequired(): void
    {
        $uri = new DCATURI('Uri', 'www.somesite.com');
        $anotherUri = new DCATURI('Uri', 'somesite.com');

        $this->assertEquals(['Uri: value www.somesite.com is not a valid URI'], $uri->validate()->getMessages());
        $this->assertEquals(['Uri: value somesite.com is not a valid URI'], $anotherUri->validate()->getMessages());
    }

}
