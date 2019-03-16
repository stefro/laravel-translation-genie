<?php

namespace InvolvedGroup\LaravelTranslationGenie\Tests\Feature;

use InvolvedGroup\LaravelTranslationGenie\Tests\TestCase;
use InvolvedGroup\LaravelTranslationGenie\TranslationGenie;

class TranslationGenieTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    /** @test */
    public function it_will_not_have_double_values_in_the_methods()
    {
        \Config::set('translation-genie.laravel_translation_methods', ['trans','__','@lang','trans_choice','\$t']);

        $methods = new TranslationGenie();

        $this->assertEquals(['trans','__','@lang','trans_choice','\$t'],$methods->mergeAllMethods());
    }

    /** @test */
    public function it_will_not_have_double_values_in_the_paths()
    {
        \Config::set('translation-genie.vue_sets', [
            [
                'methods' => ['\$t'],
                'scan_paths' => [resource_path('js')],
                'store_path' => public_path('js/front'),
            ],
            [
                'methods' => ['\$t'],
                'scan_paths' => [resource_path('js')],
                'store_path' => public_path('js/admin'),
            ],
        ]);

        $paths = new TranslationGenie();

        $this->assertEquals(2 , count($paths->mergeAllPaths()));
    }
}
