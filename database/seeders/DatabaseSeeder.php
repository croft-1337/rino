<?php

namespace Database\Seeders;

use App\Support\Defaults\BlogDefaults;
use App\Support\Defaults\DefaultContent;
use App\Support\Defaults\KnowledgebaseDefaults;
use App\Support\Defaults\SettingsDefaults;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        SettingsDefaults::seed();

        DefaultContent::seed();

        BlogDefaults::seed();

        KnowledgebaseDefaults::seed();
    }
}