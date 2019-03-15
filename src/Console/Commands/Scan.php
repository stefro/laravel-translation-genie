<?php

namespace InvolvedGroup\LaravelTranslationGenie\Console\Commands;

use Illuminate\Console\Command;
use InvolvedGroup\LaravelTranslationGenie\TranslationGenie;

class Scan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translation-genie:scan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scan for translations in the code and create (if new) these as keys in the translation files.';

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
        return (new TranslationGenie())->scanAll();
    }
}
