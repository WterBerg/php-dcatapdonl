<?php

namespace DCAT_AP_DONL\Test;

use DCAT_AP_DONL\DCATControlledVocabularyEntry;
use DCAT_AP_DONL\DCATException;
use DCAT_AP_DONL\DCATLiteral;
use DCAT_AP_DONL\DCATSpatial;
use PHPUnit\Framework\TestCase;

class DCATSpatialTest extends TestCase
{
    public function testBothSchemeAndValueAreRequired(): void
    {
        try {
            $spatial = new DCATSpatial();

            $this->assertEquals(
                [
                    'scheme: value is missing',
                    'value: value is missing',
                    'at least one property must be provided',
                ],
                $spatial->validate()->getMessages()
            );
        } catch (DCATException $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testGettersArePresentAndFunctional(): void
    {
        $spatial = new DCATSpatial();
        $spatial->setScheme(new DCATControlledVocabularyEntry('myScheme', 'Overheid:SpatialScheme'));
        $spatial->setValue(new DCATLiteral('myValue'));

        $this->assertEquals('myScheme', $spatial->getScheme()->getData());
        $this->assertEquals('myValue', $spatial->getValue()->getData());
    }

    public function testValidPostcodeHuisnummersValidate(): void
    {
        try {
            $spatial = new DCATSpatial();
            $spatial->setScheme(
                new DCATControlledVocabularyEntry(
                    'http://standaarden.overheid.nl/owms/4.0/doc/syntax-codeerschemas/overheid.postcodehuisnummer',
                    'Overheid:SpatialScheme'
                )
            );
            $spatial->setValue(new DCATLiteral('1234AB'));

            $this->assertTrue($spatial->validate()->validated());
        } catch (DCATException $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testInvalidPostcodeHuisnummersFailValidation(): void
    {
        try {
            $spatial = new DCATSpatial();
            $spatial->setScheme(
                new DCATControlledVocabularyEntry(
                    'http://standaarden.overheid.nl/owms/4.0/doc/syntax-codeerschemas/overheid.postcodehuisnummer',
                    'Overheid:SpatialScheme'
                )
            );
            $spatial->setValue(new DCATLiteral('AB'));

            $this->assertEquals([
                'value AB fails to validate against scheme http://standaarden.overheid.nl/owms/4.0/doc/syntax-codeerschemas/overheid.postcodehuisnummer',
            ], $spatial->validate()->getMessages());
        } catch (DCATException $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testValidEpsg28992Validates(): void
    {
        try {
            $spatial = new DCATSpatial();
            $spatial->setScheme(
                new DCATControlledVocabularyEntry(
                    'http://standaarden.overheid.nl/owms/4.0/doc/syntax-codeerschemas/overheid.epsg28992',
                    'Overheid:SpatialScheme'
                )
            );
            $spatial->setValue(new DCATLiteral('111111 123456.098'));

            $this->assertTrue($spatial->validate()->validated());
        } catch (DCATException $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testInvalidEpsg28992DoesNotValidate(): void
    {
        try {
            $spatial = new DCATSpatial();
            $spatial->setScheme(
                new DCATControlledVocabularyEntry(
                    'http://standaarden.overheid.nl/owms/4.0/doc/syntax-codeerschemas/overheid.epsg28992',
                    'Overheid:SpatialScheme'
                )
            );
            $spatial->setValue(new DCATLiteral('1111 0987'));

            $this->assertEquals([
                'value 1111 0987 fails to validate against scheme http://standaarden.overheid.nl/owms/4.0/doc/syntax-codeerschemas/overheid.epsg28992',
            ], $spatial->validate()->getMessages());
        } catch (DCATException $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testValidGemeentenValidate(): void
    {
        try {
            $spatial = new DCATSpatial();
            $spatial->setScheme(
                new DCATControlledVocabularyEntry(
                    'http://standaarden.overheid.nl/owms/4.0/doc/waardelijsten/overheid.gemeente',
                    'Overheid:SpatialScheme'
                )
            );
            $spatial->setValue(new DCATLiteral('http://standaarden.overheid.nl/owms/terms/Ubbergen_(gemeente)'));

            $this->assertTrue($spatial->validate()->validated());
        } catch (DCATException $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testInvalidGemeentenDoNotValidate(): void
    {
        try {
            $spatial = new DCATSpatial();
            $spatial->setScheme(
                new DCATControlledVocabularyEntry(
                    'http://standaarden.overheid.nl/owms/4.0/doc/waardelijsten/overheid.gemeente',
                    'Overheid:SpatialScheme'
                )
            );
            $spatial->setValue(new DCATLiteral('Ubbergen'));

            $this->assertEquals([
                'value Ubbergen fails to validate against scheme http://standaarden.overheid.nl/owms/4.0/doc/waardelijsten/overheid.gemeente',
            ], $spatial->validate()->getMessages());
        } catch (DCATException $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testValidProvinciesValidate(): void
    {
        try {
            $spatial = new DCATSpatial();
            $spatial->setScheme(
                new DCATControlledVocabularyEntry(
                    'http://standaarden.overheid.nl/owms/4.0/doc/waardelijsten/overheid.provincie',
                    'Overheid:SpatialScheme'
                )
            );
            $spatial->setValue(new DCATLiteral('http://standaarden.overheid.nl/owms/terms/Gelderland'));

            $this->assertTrue($spatial->validate()->validated());
        } catch (DCATException $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testInvalidProvinciesDoNotValidate(): void
    {
        try {
            $spatial = new DCATSpatial();
            $spatial->setScheme(
                new DCATControlledVocabularyEntry(
                    'http://standaarden.overheid.nl/owms/4.0/doc/waardelijsten/overheid.provincie',
                    'Overheid:SpatialScheme'
                )
            );
            $spatial->setValue(new DCATLiteral('I_do_not_exist'));

            $this->assertEquals([
                'value I_do_not_exist fails to validate against scheme http://standaarden.overheid.nl/owms/4.0/doc/waardelijsten/overheid.provincie',
            ], $spatial->validate()->getMessages());
        } catch (DCATException $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testValidWaterschappenValidate(): void
    {
        try {
            $spatial = new DCATSpatial();
            $spatial->setScheme(
                new DCATControlledVocabularyEntry(
                    'http://standaarden.overheid.nl/owms/4.0/doc/waardelijsten/overheid.waterschap',
                    'Overheid:SpatialScheme'
                )
            );
            $spatial->setValue(new DCATLiteral('http://standaarden.overheid.nl/owms/terms/Hoogheemraadschap_van_Rijnland'));

            $this->assertTrue($spatial->validate()->validated());
        } catch (DCATException $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testInvalidWaterschappenDoNotValidate(): void
    {
        try {
            $spatial = new DCATSpatial();
            $spatial->setScheme(
                new DCATControlledVocabularyEntry(
                    'http://standaarden.overheid.nl/owms/4.0/doc/waardelijsten/overheid.waterschap',
                    'Overheid:SpatialScheme'
                )
            );
            $spatial->setValue(new DCATLiteral('testValue'));

            $this->assertEquals([
                'value testValue fails to validate against scheme http://standaarden.overheid.nl/owms/4.0/doc/waardelijsten/overheid.waterschap',
            ], $spatial->validate()->getMessages());
        } catch (DCATException $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testValidKoninkrijksdeelValidate(): void
    {
        try {
            $spatial = new DCATSpatial();
            $spatial->setScheme(
                new DCATControlledVocabularyEntry(
                    'http://standaarden.overheid.nl/owms/4.0/doc/waardelijsten/overheid.koninkrijksdeel',
                    'Overheid:SpatialScheme'
                )
            );
            $spatial->setValue(new DCATLiteral('http://standaarden.overheid.nl/owms/terms/Nederland'));

            $this->assertTrue($spatial->validate()->validated());
        } catch (DCATException $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testInvalidKoninkrijksdeelDoNotValidate(): void
    {
        try {
            $spatial = new DCATSpatial();
            $spatial->setScheme(
                new DCATControlledVocabularyEntry(
                    'http://standaarden.overheid.nl/owms/4.0/doc/waardelijsten/overheid.koninkrijksdeel',
                    'Overheid:SpatialScheme'
                )
            );
            $spatial->setValue(new DCATLiteral('Duitsland'));

            $this->assertEquals([
                'value Duitsland fails to validate against scheme http://standaarden.overheid.nl/owms/4.0/doc/waardelijsten/overheid.koninkrijksdeel',
            ], $spatial->validate()->getMessages());
        } catch (DCATException $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testThrowsExceptionOnIllegalScheme(): void
    {
        try {
            $spatial = new DCATSpatial();
            $spatial->setScheme(
                new DCATControlledVocabularyEntry(
                    'random value',
                    'Overheid:SpatialScheme'
                )
            );
            $spatial->setValue(new DCATLiteral('Duitsland'));
            $spatial->validate();

            $this->fail();
        } catch (DCATException $e) {
            $this->assertEquals('invalid scheme specified for Spatial', $e->getMessage());
        }
    }
}
