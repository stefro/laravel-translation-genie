<?php

namespace InvolvedGroup\LaravelTranslationGenie;

use Illuminate\Filesystem\Filesystem;
use InvolvedGroup\LaravelTranslationGenie\Services\Scanner;

class TranslationGenie
{
    public function scanAll()
    {
        $paths = $this->mergeAllPaths();
        $methods = $this->mergeAllMethods();

        $test = collect($this->scan($paths, $methods)['single']['single']);

        dd($test->sortKeys());

        dd($this->scan($paths, $methods));

    }

    /**
     * @param array $paths
     * @param array $methods
     * @return array
     */
    private function scan(array $paths, array $methods)
    {
        $scanner = new Scanner(new Filesystem, $paths, $methods);

        return $scanner->findTranslations();
    }

    private function mergeAllPaths(): array
    {
        $paths = config('translation-genie.laravel_scan_path');

        foreach (config('translation-genie.vue_sets') as $set) {
            foreach ($set['paths'] as $path) {
                $paths[] = $path;
            }
        }

        return collect($paths)->unique()->toArray();
    }

    private function mergeAllMethods(): array
    {
        $methods = config('translation-genie.laravel_translation_methods');

        foreach (config('translation-genie.vue_sets') as $set) {
            foreach ($set['methods'] as $method) {
                $methods[] = $method;
            }
        }

        return collect($methods)->unique()->toArray();
    }

}
