<?php

namespace InvolvedGroup\LaravelTranslationGenie;

use Illuminate\Filesystem\Filesystem;
use InvolvedGroup\LaravelTranslationGenie\Services\Scanner;

class TranslationGenie
{
    protected $i18n_filename = 'vue-i18n-translations';

    public function scanAll()
    {
        $paths = $this->mergeAllPaths();
        $methods = $this->mergeAllMethods();

        return $this->scan($paths, $methods);
    }

    /**
     * @param  array  $paths
     * @param  array  $methods
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

        $this->getTranslationJsonFiles()->each(function ($file) use ($single) {
            $this->updateSingleTranslationFile($file, $single);
        });

    }

    private function updateSingleTranslationFile($file, $single)
    {
        $filecontent = collect(json_decode($file->getContents()));
        $diff = $single->diffKeys($filecontent);

        // If the language file is the default locale, we'll make sure the value is the same as the key.
        $language = explode('.', $file->getFilename())[0];
        if($language == config('app.locale')){
            foreach($diff as $key => $value){
                $diff[$key] = $key;
            }
        }

        $new = $filecontent->merge($diff)->sortKeys();

        file_put_contents($file, json_encode($new, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    }

    public function updateJSFiles()
    {
        foreach (config('translation-genie.vue_sets') as $set) {
            $this->prepareSet($set);
        }
    }

    protected function prepareSet($set)
    {
        if(!file_exists($set['store_path'])){
            if (!mkdir($concurrentDirectory = $set['store_path']) && !is_dir($concurrentDirectory)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
            }
        }

        if(config('translation-genie.single_file')){
            $this->updateVueSetSingleFile($set);
        } else {
            $this->updateMultiFile($set);
        }
    }

    private function updateVueSetSingleFile($set)
    {
        $filename = $set['store_path'].DIRECTORY_SEPARATOR.$this->i18n_filename.'.js';
        if (!file_exists($filename)) {
            fopen($filename, "w");
        }

        $keys = $this->scan($set['scan_paths'], $set['methods'])['single'];

        $data = $this->i18nData($keys);

        file_put_contents($filename, "export default {$this->jsonPrettyPrint($data)}");
    }

    private function i18nData($keys)
    {
        $data = collect($this->getTranslationJsonFiles())->flatMap(function ($file) use ($keys) {
            $key = str_replace('.json', '', $file->getFilename());

            $selected_content = collect(json_decode($file->getContents()))
                ->filter(function ($value, $key) use ($keys) {
                    return isset($keys[$key]);
                })->filter(function($value){
                    return $value != '';
                });

            return [
                $key => $selected_content
            ];
        });

        return $data;
    }

    private function updateMultiFile($set)
    {
        $data = $this->getKeysAndTranslations($set);
    }

    /**
     * @param $set
     * @return false|string
     */
    private function getKeysAndTranslations($set)
    {
        $keys = $this->scan($set['scan_paths'], $set['methods'])['single'];

        $data = $this->i18nData($keys);

        $data->each(function($translations, $lang) use ($set) {
            $filename = $set['store_path'].DIRECTORY_SEPARATOR.$this->i18n_filename.'-'.$lang.'.js';
            if (!file_exists($filename)) {
                fopen($filename, "w");
            }
            file_put_contents($filename, "export default {$this->jsonPrettyPrint($translations)}");
        });
    }

    /**
     * @return false|string
     */
    private function jsonPrettyPrint($data)
    {
        return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

}
