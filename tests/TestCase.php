<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * Track the output buffering level at the start of each test so we only
     * close buffers that were opened during the test or by the tested code.
     * PHPUnit treats it as risky when a test closes buffers it didn't open,
     * so we respect the initial level.
     *
     * @var int
     */
    protected int $initialObLevel = 0;

    protected function setUp(): void
    {
        parent::setUp();

        // Record the buffer level at test start
        $this->initialObLevel = ob_get_level();
    }

    protected function tearDown(): void
    {
        // Close any output buffers opened after the test started
        while (ob_get_level() > $this->initialObLevel) {
            @ob_end_clean();
        }

        parent::tearDown();
    }
}
