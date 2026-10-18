<?php

namespace App\Console\Commands;

use App\Support\EnvConfiguration;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use PDO;
use Throwable;
use function Laravel\Prompts\confirm;
use function Laravel\Prompts\intro;
use function Laravel\Prompts\outro;
use function Laravel\Prompts\password;
use function Laravel\Prompts\text;
use function Laravel\Prompts\warning;

class ConfigureDatabase extends Command
{
    protected $signature = 'rino:db';

    protected $description = 'Configure the Rino database';

    public function handle(): int
    {
        intro('Rino Database Configuration');

        $current = EnvConfiguration::read();

        $host = text(
            label: 'Database host',
            default: $current['DB_HOST'] ?? '127.0.0.1',
            required: true,
        );

        $port = text(
            label: 'Database port',
            default: $current['DB_PORT'] ?? '3306',
            required: true,
            validate: fn (string $value) => ctype_digit($value)
                && (int) $value >= 1
                && (int) $value <= 65535
                    ? null
                    : 'Enter a valid port between 1 and 65535.',
        );

        $database = text(
            label: 'Database name',
            default: $current['DB_DATABASE'] ?? 'rino',
            required: true,
        );

        $username = text(
            label: 'Database username',
            default: $current['DB_USERNAME'] ?? 'rino',
            required: true,
        );

        $dbPassword = $current['DB_PASSWORD'] ?? '';

        if (
            $dbPassword === '' ||
            confirm(
                label: 'Change existing database password?',
                default: false,
            )
        ) {
            $dbPassword = password(
                label: 'Database password',
                required: false,
            );
        }

        EnvConfiguration::write([
            'DB_CONNECTION' => 'mysql',
            'DB_HOST' => $host,
            'DB_PORT' => $port,
            'DB_DATABASE' => $database,
            'DB_USERNAME' => $username,
            'DB_PASSWORD' => $dbPassword,
        ]);

        Artisan::call('config:clear');

        try {
            new PDO(
                "mysql:host={$host};port={$port};dbname={$database};charset=utf8mb4",
                $username,
                $dbPassword,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_TIMEOUT => 5,
                ]
            );

            outro('Database configured and connected successfully.');
        } catch (Throwable) {
            warning('Database configuration saved, but connection could not be verified.');

            outro('Database configuration saved successfully.');
        }

        return self::SUCCESS;
    }
}
