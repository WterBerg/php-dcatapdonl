<?php

use DCAT_AP_DONL\DCATControlledVocabulary;
use DCAT_AP_DONL\DCATControlledVocabularyEntry;
use DCAT_AP_DONL\DCATException;
use PHPUnit\Framework\TestCase;

class DCATControlledVocabularyEntryTest extends TestCase
{
    public function testVocabularyIsDefinedInEntry(): void
    {
        $entry = new DCATControlledVocabularyEntry('Value', 'Vocabulary');

        $this->assertEquals('Vocabulary', $entry->getControlledVocabulary());
    }

    public function testEntryValidatesWhenPartOfTheVocabulary(): void
    {
        try {
            DCATControlledVocabulary::addCustomVocabulary('Vocabulary', ['Value']);
            $entry = new DCATControlledVocabularyEntry('Value', 'Vocabulary');

            $this->assertTrue($entry->validate()->validated());
        } catch (DCATException $e) {
            $this->fail();
        }
    }

    public function testEntryFailsValidationWhenPartOfTheVocabulary(): void
    {
        try {
            DCATControlledVocabulary::addCustomVocabulary('Vocabulary2', ['Value']);
            $entry = new DCATControlledVocabularyEntry('Value2', 'Vocabulary2');

            $this->assertFalse($entry->validate()->validated());
        } catch (DCATException $e) {
            $this->fail();
        }
    }
}
