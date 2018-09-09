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

}
