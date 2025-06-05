<?php

/**
 * This file is part of the wterberg/dcat-ap-donl package.
 *
 * This source file is subject to the license that is
 * bundled with this source code in the LICENSE.md file.
 */

namespace DCAT_AP_DONL;

/**
 * Class DCATControlledVocabularyEntry.
 *
 * Represents a DCATLiteral as part of a DCATControlledVocabulary.
 */
class DCATControlledVocabularyEntry extends DCATLiteral
{
    /**
     * @var string
     */
    public const VOCABULARY_ERROR_FORMAT = 'Expected entry of vocabulary %s';

    /**
     * DCATControlledVocabularyEntry constructor.
     *
     * @param string $value                The value of this DCAT controlled vocabulary entry
     * @param string $controlledVocabulary The name of the controlled vocabulary to validate against
     */
    public function __construct(string $value, protected string $controlledVocabulary)
    {
        parent::__construct($value);
    }

    /**
     * Determines and returns whether the DCATControlledVocabularyEntry
     * is valid.
     *
     * A DCATControlledVocabularyEntry is considered valid when:
     * - it passes the validation as defined in `DCATLiteral::validate()`
     * - its value property is contained within the controlled vocabulary of the given controlled
     * vocabulary
     *
     * @see DCATLiteral::validate()
     *
     * @return DCATValidationResult The validation result of this DCAT controlled vocabulary entry
     *
     * @throws DCATException Thrown when trying to validate this entry against a controlled
     *                       vocabulary which does not exist
     */
    public function validate(): DCATValidationResult
    {
        $result     = parent::validate();
        $vocabulary = DCATControlledVocabulary::getVocabulary($this->controlledVocabulary);

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
        return $this->controlledVocabulary;
    }
}
