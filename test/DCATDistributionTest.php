<?php

namespace DCAT_AP_DONL\Test;

use DCAT_AP_DONL\DCATDistribution;
use DCAT_AP_DONL\DCATException;
use DCAT_AP_DONL\DCATLiteral;
use PHPUnit\Framework\TestCase;

class DCATDistributionTest extends TestCase
{
    public function testEmptyDistributionsDoNotValidate(): void
    {
        $distribution = new DCATDistribution();

        $this->assertFalse($distribution->validate()->validated());
    }

    public function testSerializedDistributionsAreEqual(): void
    {
        $title         = new DCATLiteral('testValue');
        $distribiton_a = new DCATDistribution();
        $distribiton_b = new DCATDistribution();

        $distribiton_a->setTitle($title);
        $distribiton_b->setTitle($title);

        $this->assertTrue($distribiton_a->equalTo($distribiton_b));
    }

    public function testUnserializeThrowsDCATException(): void
    {
        try {
            $distribution = new DCATDistribution();
            $distribution->unserialize('test');

            $this->fail('expected DCATException');
        } catch (DCATException $e) {
            $this->assertEquals(
                'DCATDistribution::unserialize(string) is not implemented',
                $e->getMessage()
            );
        }
    }
}
