<?php

namespace DCAT_AP_DONL;

/**
 * Class DCATControlledVocabularyEntry.
 *
 * Represents a DCATLiteral as part of a DCATControlledVocabulary.
 */
class DCATControlledVocabularyEntry extends DCATLiteral
{
    /** @var string */
    protected $controlled_vocabulary;

    /**
     * DCATControlledVocabularyEntry constructor.
     *
     * @param string $value                 The value of this DCAT controlled vocabulary entry
     * @param string $controlled_vocabulary The name of the controlled vocabulary to validate
     *                                      against
     */
    public function __construct(string $value, string $controlled_vocabulary)
    {
        parent::__construct($value);

        $this->controlled_vocabulary = $controlled_vocabulary;
    }

    /**
     * Determines and returns whether or not the DCATControlledVocabularyEntry
     * is valid.
     *
     * A DCATControlledVocabularyEntry is considered valid when:
     * - it passes the validation as defined in `DCATLiteral::validate()`
     * - its value property is contained within the controlled vocabulary of the given controlled
     * vocabulary
     *
     * @see DCATLiteral::validate()
     *
     * @throws DCATException Thrown when trying to validate this entry against a controlled
     *                       vocabulary which does not exist
     *
     * @return DCATValidationResult The validation result of this DCAT controlled vocabulary entry
     */
    public function validate(): DCATValidationResult
    {
        $result     = parent::validate();
        $vocabulary = DCATControlledVocabulary::getVocabulary($this->controlled_vocabulary);

        if (!$vocabulary->containsEntry($this->value)) {
            $result->addMessage(
                'value ' . $this->getData() . ' is not part of vocabulary ' .
                $this->getControlledVocabulary()
            );
        }

        return $result;
    }

    /**
     * Returns the controlled vocabulary which this DCATControlledVocabularyEntry validates against.
     *
     * @return string The name of the controlled vocabulary
     */
    public function getControlledVocabulary(): string
    {
        return $this->controlled_vocabulary;
    }
}
