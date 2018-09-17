<?php

use PHPUnit\Framework\TestCase;
use DCAT_AP_DONL\DCATProperty;
use DCAT_AP_DONL\DCATURI;
use DCAT_AP_DONL\DCATContactPoint;


class DCATContactPointTest extends TestCase {

    public function testNamePropertyIsRequired(): void
    {
        $cp = new DCATContactPoint();

        $this->assertEquals(
            [
                'ContactPoint: fullName is missing',
                'ContactPoint: at least one property must be provided',
                'ContactPoint: email, webpage or phone is required'
            ],
            $cp->validate()->getMessages()
        );
    }

    public function testEmailWebpageOrPhoneIsRequired(): void
    {
        $cp = new DCATContactPoint();
        $cp->setFullName(new DCATProperty('fullName', 'Test'));

        $this->assertEquals(
            ['ContactPoint: email, webpage or phone is required'],
            $cp->validate()->getMessages()
        );
    }

    public function testValidatesWhenFullnameAndEmailArePresent(): void
    {
        $cp = new DCATContactPoint();
        $cp->setFullName(new DCATProperty('fullName', 'Test'));
        $cp->setEmail(new DCATProperty('email', 'myemail@domain.com'));

        $this->assertTrue($cp->validate()->validated());
    }

    public function testValidatesWhenFullnameAndPhoneArePresent(): void
    {
        $cp = new DCATContactPoint();
        $cp->setFullName(new DCATProperty('fullName', 'Test'));
        $cp->setPhone(new DCATProperty('phone', '012-3456789'));

        $this->assertTrue($cp->validate()->validated());
    }

    public function testValidatesWhenFullnameAndWebpageArePresent(): void
    {
        $cp = new DCATContactPoint();
        $cp->setFullName(new DCATProperty('fullName', 'Test'));
        $cp->setWebpage(new DCATURI('webpage', 'https://example.com'));

        $this->assertTrue($cp->validate()->validated());
    }

    public function testGetterMethodsArePresentAndFunctional(): void
    {
        $cp = new DCATContactPoint();
        $cp->setFullName(new DCATProperty('name', 'Willem ter Berg'));
        $cp->setTitle(new DCATProperty('title', 'Ing.'));
        $cp->setAddress(new DCATProperty('address', 'Nijmegen, The Netherlands'));
        $cp->setEmail(new DCATProperty('email', 'wrpterberg@gmail.com'));
        $cp->setWebpage(new DCATURI('website', 'https://github.com/WterBerg'));
        $cp->setPhone(new DCATProperty('phone', '012-3456789'));

        $this->assertEquals('Willem ter Berg', $cp->getFullName()->getData());
        $this->assertEquals('Ing.', $cp->getTitle()->getData());
        $this->assertEquals('Nijmegen, The Netherlands', $cp->getAddress()->getData());
        $this->assertEquals('wrpterberg@gmail.com', $cp->getEmail()->getData());
        $this->assertEquals('https://github.com/WterBerg', $cp->getWebpage()->getData());
        $this->assertEquals('012-3456789', $cp->getPhone()->getData());
    }

}
