<?php

namespace DCAT_AP_DONL;


/**
 * Class DCATControlledVocabularyEntry
 *
 * Represents a DCATProperty as part of a DCATControlledVocabulary.
 *
 * @package DCAT_AP_DONL
 */
class DCATControlledVocabularyEntry extends DCATProperty {

    /** @var string */
    protected $controlled_vocabulary;

    /**
     * DCATControlledVocabularyEntry constructor.
     *
     * @param string $name The name of this DCAT controlled vocabulary entry
     * @param string $value The value of this DCAT controlled vocabulary entry
     * @param string $controlled_vocabulary The name of the controlled
     * vocabulary to validate against
     */
    public function __construct(string $name, string $value,
                                string $controlled_vocabulary)
    {
        parent::__construct($name, $value);
        $this->controlled_vocabulary = $controlled_vocabulary;
    }

    /**
     * Determines and returns whether or not the DCATControlledVocabularyEntry
     * is valid.
     *
     * A DCATControlledVocabularyEntry is considered valid when:
     * - it passes the validation as defined in `DCATProperty::validate()`
     * - its value property is contained within the controlled vocabulary of the
     * given controlled vocabulary
     *
     * @see DCATProperty::validate()
     * @return DCATValidationResult The validation result of this DCAT
     * controlled vocabulary entry
     * @throws DCATException Thrown when trying to validate this entry against a
     * controlled vocabulary which does not exist
     */
    public function validate(): DCATValidationResult
    {
        $result = parent::validate();
        $vocabulary = DCATControlledVocabulary::getVocabulary(
            $this->controlled_vocabulary
        );

        if (!$vocabulary->containsEntry($this->value)) {
            $result->addMessage(
                sprintf(
                    '%s: value %s is not part of vocabulary %s',
                    $this->getName(),
                    $this->getData(),
                    $this->getControlledVocabulary()
                )
            );
        }

        return $result;
    }

    /**
     * Returns the controlled vocabulary which this
     * DCATControlledVocabularyEntry validates against.
     *
     * @return string The name of the controlled vocabulary
     */
    public function getControlledVocabulary(): string
    {
        return $this->controlled_vocabulary;
    }

}
