<?php

namespace InvolvedGroup\LaravelTranslationGenie\Console\Commands;

use Illuminate\Console\Command;
use InvolvedGroup\LaravelTranslationGenie\TranslationGenie;

class UpdateVuei18nFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translation-genie:update-js-files';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Vue i18n files. Only with keys that are translated in the masterfiles.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        return (new TranslationGenie())->updateJSFiles();
    }
}