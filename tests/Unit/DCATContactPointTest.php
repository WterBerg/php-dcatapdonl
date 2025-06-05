<?php

/**
 * This file is part of the wterberg/dcat-ap-donl package.
 *
 * This source file is subject to the license that is
 * bundled with this source code in the LICENSE.md file.
 */

namespace Tests\Unit;

use DCAT_AP_DONL\DCATContactPoint;
use DCAT_AP_DONL\DCATLiteral;
use DCAT_AP_DONL\DCATURI;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class DCATContactPointTest extends TestCase
{
    public function testNamePropertyIsRequired(): void
    {
        $cp = new DCATContactPoint();

        $this->assertEquals(
            [
                'fullName: value is missing',
                'at least one property must be provided',
                'email, webpage or phone is required',
            ],
            $cp->validate()->getMessages()
        );
    }

    public function testEmailWebpageOrPhoneIsRequired(): void
    {
        $cp = new DCATContactPoint();
        $cp->setFullName(new DCATLiteral('Test'));

        $this->assertEquals(
            ['email, webpage or phone is required'],
            $cp->validate()->getMessages()
        );
    }

    public function testValidatesWhenFullnameAndEmailArePresent(): void
    {
        $cp = new DCATContactPoint();
        $cp->setFullName(new DCATLiteral('Test'));
        $cp->setEmail(new DCATLiteral('myemail@domain.com'));

        $this->assertTrue($cp->validate()->validated());
    }

    public function testValidatesWhenFullnameAndPhoneArePresent(): void
    {
        $cp = new DCATContactPoint();
        $cp->setFullName(new DCATLiteral('Test'));
        $cp->setPhone(new DCATLiteral('012-3456789'));

        $this->assertTrue($cp->validate()->validated());
    }

    public function testValidatesWhenFullnameAndWebpageArePresent(): void
    {
        $cp = new DCATContactPoint();
        $cp->setFullName(new DCATLiteral('Test'));
        $cp->setWebpage(new DCATURI('https://example.com'));

        $this->assertTrue($cp->validate()->validated());
    }

    public function testGetterMethodsArePresentAndFunctional(): void
    {
        $cp = new DCATContactPoint();
        $cp->setFullName(new DCATLiteral('Willem ter Berg'));
        $cp->setTitle(new DCATLiteral('Ing.'));
        $cp->setAddress(new DCATLiteral('Nijmegen, The Netherlands'));
        $cp->setEmail(new DCATLiteral('wrpterberg@gmail.com'));
        $cp->setWebpage(new DCATURI('https://github.com/WterBerg'));
        $cp->setPhone(new DCATLiteral('012-3456789'));

        $this->assertEquals('Willem ter Berg', $cp->getFullName()->getData());
        $this->assertEquals('Ing.', $cp->getTitle()->getData());
        $this->assertEquals('Nijmegen, The Netherlands', $cp->getAddress()->getData());
        $this->assertEquals('wrpterberg@gmail.com', $cp->getEmail()->getData());
        $this->assertEquals('https://github.com/WterBerg', $cp->getWebpage()->getData());
        $this->assertEquals('012-3456789', $cp->getPhone()->getData());
    }
}
