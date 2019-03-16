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
        $app['config']->set('translation-genie.laravel_translation_methods', ['trans', '__', '@lang', 'trans_choice']);
        $app['config']->set('translation-genie.laravel_scan_paths', [__DIR__ . '/Files/scripts']);
        $app['config']->set('translation-genie.vue_sets', [
            [
                'methods' => ['\$t'],
                'scan_paths' => [resource_path('js')],
                'store_path' => public_path('js/front'),
            ],
            [
                'methods' => ['\$t'],
                'scan_paths' => [resource_path('js/admin')],
                'store_path' => public_path('js/admin'),
            ]
        ]);
    }
}
