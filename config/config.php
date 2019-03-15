<?php

/*
 * You can place your custom package configuration in here.
 */
return [
    'laravel_translation_methods' => ['trans','__','@lang','trans_choice'],

    'laravel_scan_path' => [app_path(), resource_path()],

    'vue_sets' => [
        [
            'name' => 'front',
            'methods' => ['\$t'],
            'paths' => [resource_path('js')]
        ]
    ]
];
