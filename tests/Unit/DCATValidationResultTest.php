<?php

/**
 * This file is part of the wterberg/dcat-ap-donl package.
 *
 * This source file is subject to the license that is
 * bundled with this source code in the LICENSE.md file.
 */

namespace Tests\Unit;

use DCAT_AP_DONL\DCATValidationResult;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class DCATValidationResultTest extends TestCase
{
    public function testValidatesWhenThereAreNoErrorMessages(): void
    {
        $validation = new DCATValidationResult();

        $this->assertTrue($validation->validated());
    }

    public function testMessagesInvalidatesTheValidation(): void
    {
        $validation = new DCATValidationResult();
        $validation->addMessage('New Message');

        $this->assertFalse($validation->validated());
    }

    public function testAllowsAddingMultipleMessages(): void
    {
        $validation = new DCATValidationResult();
        $validation->addMessages(['New Message', 'Another Message']);

        $this->assertEquals(['New Message', 'Another Message'], $validation->getMessages());
    }

    public function testMessagesAreRetrievable(): void
    {
        $validation = new DCATValidationResult();
        $validation->addMessage('New Message');

        $this->assertEquals(['New Message'], $validation->getMessages());
    }

    public function testNoticesDoNotInvalidateTheResult(): void
    {
        $validation = new DCATValidationResult();
        $validation->addNotice('New Notice');

        $this->assertTrue($validation->validated());
    }

    public function testNoticesAreRetrievable(): void
    {
        $validation = new DCATValidationResult();
        $validation->addNotice('New Notice');

        $this->assertEquals(['New Notice'], $validation->getNotices());
    }

    public function testAllowsAddingMultipleNotices(): void
    {
        $validation = new DCATValidationResult();
        $validation->addNotices(['New Notice', 'Another Notice']);

        $this->assertEquals(['New Notice', 'Another Notice'], $validation->getNotices());
    }
}
