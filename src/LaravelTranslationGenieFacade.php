<?php

namespace InvolvedGroup\LaravelTranslationGenie;

use Illuminate\Support\Facades\Facade;

/**
 * @see \InvolvedGroup\LaravelTranslationGenie\Skeleton\SkeletonClass
 */
class LaravelTranslationGenieFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-translation-genie';
    }
}
