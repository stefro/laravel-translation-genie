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

        return $this->scan($paths, $methods);
    }

    /**
     * @param array $paths
     * @param array $methods
     * @return array
     */
    public function scan(array $paths, array $methods)
    {
        $scanner = new Scanner(new Filesystem, $paths, $methods);

        return $scanner->findTranslations();
    }

    public function mergeAllPaths(): array
    {
        $paths = config('translation-genie.laravel_scan_paths');
        foreach (config('translation-genie.vue_sets') as $set) {
            foreach ($set['scan_paths'] as $path) {
                $paths[] = $path;
            }
        }

        return collect($paths)->unique()->toArray();
    }

    public function mergeAllMethods(): array
    {
        $methods = config('translation-genie.laravel_translation_methods');

        foreach (config('translation-genie.vue_sets', []) as $set) {
            foreach ($set['methods'] as $method) {
                $methods[] = $method;
            }
        }

        return collect($methods)->unique()->toArray();
    }

    public function getTranslationJsonFiles()
    {
        $disk = new Filesystem();

        return collect($disk->allFiles('resources/lang'))
            ->filter(function ($file) use ($disk) {
                return $disk->extension($file) == 'json';
            });
    }

    public function updateTranslationFiles()
    {
        $single = collect($this->scanAll()['single']);

        $this->getTranslationJsonFiles()->each(function($file) use ($single) {
            $this->updateSingleTranslationFile($file, $single);
        });

    }

    private function updateSingleTranslationFile($file, $single)
    {
        $filecontent = collect(json_decode($file->getContents()));
        $diff = $single->diffKeys($filecontent);

        $new = $filecontent->merge($diff)->sortKeys();

        file_put_contents($file, json_encode($new, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    }

}
