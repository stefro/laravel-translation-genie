<?php

namespace InvolvedGroup\LaravelTranslationGenie\Tests;

use Orchestra\Testbench\TestCase;

class ScannerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return ['InvolvedGroup\LaravelTranslationGenie\TranslationGenieServiceProvider'];
    }

}
