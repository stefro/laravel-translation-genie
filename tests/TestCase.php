<?php

namespace InvolvedGroup\LaravelTranslationGenie\Tests;

use InvolvedGroup\LaravelTranslationGenie\TranslationGenieServiceProvider;

/**
 * Class TestCase
 *
 * @package \InvolvedGroup\LaravelTranslationGenie\Tests
 */
abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }
    public function getPackageProviders($app)
    {
        return [
            TranslationGenieServiceProvider::class
        ];
    }
    protected function getEnvironmentSetUp($app)
    {
        //
    }
}
