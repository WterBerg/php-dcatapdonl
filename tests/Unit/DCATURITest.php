<?php

/**
 * This file is part of the wterberg/dcat-ap-donl package.
 *
 * This source file is subject to the license that is
 * bundled with this source code in the LICENSE.md file.
 */

namespace Tests\Unit;

use DCAT_AP_DONL\DCATURI;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
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
