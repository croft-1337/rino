<?php

namespace App\Console\Commands;

use App\Support\EnvConfiguration;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use function Laravel\Prompts\intro;
use function Laravel\Prompts\outro;
use function Laravel\Prompts\text;

class ConfigureRino extends Command
{
    protected $signature = 'rino:init';

    protected $description = 'Configure the Rino application';

    public function handle(): int
    {
        intro('Rino Application Configuration');

        $current = EnvConfiguration::read();

        $name = text(
            label: 'Application name',
            default: $current['APP_NAME'] ?? 'Rino',
            required: true,
            validate: fn (string $value) => mb_strlen($value) > 255
                ? 'Application name must not exceed 255 characters.'
                : null,
        );

        $url = text(
            label: 'Application URL',
            default: $current['APP_URL'] ?? 'http://localhost',
            required: true,
            validate: fn (string $value) => filter_var($value, FILTER_VALIDATE_URL)
                && in_array(parse_url($value, PHP_URL_SCHEME), ['http', 'https'], true)
                    ? null
                    : 'Enter a valid HTTP or HTTPS URL.',
        );

        $settings = [
            'APP_NAME' => $name,
            'APP_URL' => rtrim($url, '/'),
        ];

        if (empty($current['APP_KEY'])) {
            $settings['APP_KEY'] = 'base64:'.base64_encode(random_bytes(32));
        }

        EnvConfiguration::write($settings);

        Artisan::call('config:clear');

        outro('Application configured successfully.');

        return self::SUCCESS;
    }
}
