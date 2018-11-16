<?php

use DCAT_AP_DONL\DCATURI;
use PHPUnit\Framework\TestCase;

class DCATURITest extends TestCase
{
    public function testHttpLinksAreAllowed(): void
    {
        $uri = new DCATURI('http://somesite.com');

        $this->assertTrue($uri->validate()->validated());
    }

    public function testHttpsLinksAreAllowed(): void
    {
        $uri = new DCATURI('https://somesite.com');

        $this->assertTrue($uri->validate()->validated());
    }

    public function testProtocolIsRequired(): void
    {
        $uri        = new DCATURI('www.somesite.com');
        $anotherUri = new DCATURI('somesite.com');

        $this->assertEquals(
            ['value www.somesite.com is not a valid URI'],
            $uri->validate()->getMessages()
        );
        $this->assertEquals(
            ['value somesite.com is not a valid URI'],
            $anotherUri->validate()->getMessages()
        );
    }
}
