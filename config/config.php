<?php

/*
 * You can place your custom package configuration in here.
 */
return [
    'laravel_translation_methods' => ['trans','__','@lang','trans_choice'],

    'laravel_scan_paths' => [app_path(), resource_path()],

    'vue_sets' => [
        [
            'methods' => ['\$t'],
            'scan_paths' => [resource_path('js')],
            'store_path' => resource_path('js/admin/translations'),
        ],
//        [
//            'methods' => ['\$t'],
//            'scan_paths' => [resource_path('js/admin')],
//            'store_path' => public_path('js/admin'),
//        ]
    ]
];
