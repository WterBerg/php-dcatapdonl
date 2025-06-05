<?php

/**
 * This file is part of the wterberg/dcat-ap-donl package.
 *
 * This source file is subject to the license that is
 * bundled with this source code in the LICENSE.md file.
 */

namespace DCAT_AP_DONL;

/**
 * Class DCATValidationResult.
 *
 * Represents the validation result of a DCATEntity.
 */
class DCATValidationResult
{
    /**
     * @var string[]
     */
    protected array $messages = [];

    /**
     * @var string[]
     */
    protected array $notices = [];

    /**
     * Returns whether the DCATEntity validated successfully.
     *
     * @return bool Whether the validation was successful
     */
    public function validated(): bool
    {
        return 0 === count($this->getMessages());
    }

    /**
     * Returns all the validation messages.
     *
     * @return string[] The validation error messages
     */
    public function getMessages(): array
    {
        return $this->messages;
    }

    /**
     * Add a validation error message.
     *
     * @param string $message The message to add
     */
    public function addMessage(string $message): void
    {
        $this->messages[] = $message;
    }

    /**
     * Add a group of error messages.
     *
     * @param string[] $messages The messages to add
     */
    public function addMessages(array $messages): void
    {
        $this->messages = array_merge($this->messages, $messages);
    }

    /**
     * Returns all the set notices for this validation result.
     *
     * @return string[] The validation notices
     */
    public function getNotices(): array
    {
        return $this->notices;
    }

    /**
     * Add a notice to the validation result.
     *
     * @param string $notice The notice to add
     */
    public function addNotice(string $notice): void
    {
        $this->notices[] = $notice;
    }

    /**
     * Add several notices to the validation result.
     *
     * @param string[] $notices The notices to add
     */
    public function addNotices(array $notices): void
    {
        $this->notices = array_merge($this->notices, $notices);
    }
}
