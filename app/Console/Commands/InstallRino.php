<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use RuntimeException;
use Throwable;
use function Laravel\Prompts\confirm;
use function Laravel\Prompts\intro;
use function Laravel\Prompts\outro;
use function Laravel\Prompts\password;
use function Laravel\Prompts\text;

class InstallRino extends Command
{
    protected $signature = 'rino:install {--server-only : Configure server services after application setup}';

    protected $description = 'Interactively configure and install Rino CMS';

    public function handle(): int
    {
        intro('Rino CMS Installer');

        if ($this->option('server-only')) {
            return $this->configureServerOnly();
        }

        if (is_file(base_path('bootstrap/cache/config.php'))) {
            $this->error('Cached configuration detected. Run php artisan config:clear before installing.');
            return self::FAILURE;
        }

        if (PHP_VERSION_ID < 80300 || PHP_VERSION_ID >= 80400) {
            $this->error('The tested automated installer requires PHP 8.3.');
            return self::FAILURE;
        }

        foreach (['pdo_mysql', 'mbstring', 'xml', 'curl', 'bcmath', 'intl', 'gd', 'zip'] as $extension) {
            if (! extension_loaded($extension)) {
                $this->error('Missing PHP extension: ' . $extension);
                return self::FAILURE;
            }
        }

        if (! is_writable(base_path()) || ! is_writable(storage_path()) || ! is_writable(base_path('bootstrap/cache'))) {
            $this->error('The project directory, storage, and bootstrap/cache must be writable by the current user.');
            return self::FAILURE;
        }

        if (file_exists(storage_path('app/rino-installed.lock'))) {
            $this->error('Rino is already installed. The installer will not overwrite it.');
            return self::FAILURE;
        }

        if (! confirm(label: 'Configure a new Rino installation?', default: true)) {
            return self::SUCCESS;
        }

        $envFile = base_path('.env');

        if (is_file($envFile)) {
            if (! confirm(label: 'An .env file exists. Back it up and update the Rino settings?', default: false)) {
                return self::FAILURE;
            }
        } elseif (! is_file(base_path('.env.example'))) {
            $this->error('Missing .env.example.');
            return self::FAILURE;
        }

        $domain = text(
            label: 'Website domain',
            placeholder: 'example.com',
            required: true,
            validate: fn (string $value) => filter_var($value, FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME) && str_contains($value, '.')
                ? null : 'Enter a valid domain without http:// or https://.',
        );

        $https = confirm(label: 'Use HTTPS for this domain?', default: true);
        $dbHost = text(label: 'Database host', default: '127.0.0.1', required: true);
        $dbPort = text(
            label: 'Database port',
            default: '3306',
            required: true,
            validate: fn (string $v) => ctype_digit($v) && (int) $v >= 1 && (int) $v <= 65535 ? null : 'Enter a valid port.',
        );
        $dbName = text(
            label: 'Database name',
            default: 'rino',
            required: true,
            validate: fn (string $v) => preg_match('/^[a-zA-Z0-9_]+$/D', $v) ? null : 'Use letters, numbers, and underscores.',
        );
        $dbUser = text(label: 'Database username', default: 'rino', required: true);
        $dbPass = password(label: 'Database password', required: true);

        if (! $this->checkFrontendPrerequisites()) {
            return self::FAILURE;
        }

        $this->info('Checking database connection...');

        if (! $this->databaseReady($dbHost, $dbPort, $dbName, $dbUser, $dbPass)) {
            $this->warn('The database connection is not ready.');

            if ($dbHost !== '127.0.0.1' && $dbHost !== 'localhost') {
                $this->error('Automatic database creation is supported for a local MySQL server only.');
                return self::FAILURE;
            }

            if (! confirm(label: 'Create the local MySQL database and user using sudo?', default: false)) {
                return self::FAILURE;
            }

            if (! $this->createLocalDatabase($dbName, $dbUser, $dbPass)) {
                return self::FAILURE;
            }

            if (! $this->databaseReady($dbHost, $dbPort, $dbName, $dbUser, $dbPass)) {
                $this->error('Database still cannot be reached. Check the MySQL service and credentials.');
                return self::FAILURE;
            }
        }

        try {
            $pdo = new \PDO(
                "mysql:host={$dbHost};port={$dbPort};dbname={$dbName};charset=utf8mb4",
                $dbUser,
                $dbPass,
                [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION, \PDO::ATTR_TIMEOUT => 5],
            );
            $tables = (int) $pdo->query('SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = DATABASE()')->fetchColumn();
            if ($tables > 0) {
                $this->error('The database already contains tables. Installation was stopped to protect existing data.');
                $this->warn('If a previous installation failed, back up and inspect that database before retrying. The installer never clears tables automatically.');
                return self::FAILURE;
            }
        } catch (Throwable $e) {
            $this->error('Database check failed: ' . $e->getMessage());
            return self::FAILURE;
        }

        if (! confirm(label: 'Install database tables, default content, and the first administrator?', default: true)) {
            return self::SUCCESS;
        }

        $adminName = text(label: 'Administrator name', required: true);
        $adminEmail = text(
            label: 'Administrator email',
            required: true,
            validate: fn (string $v) => Validator::make(['email' => $v], ['email' => 'required|email|max:255'])->fails()
                ? 'Enter a valid email address.' : null,
        );
        $adminPassword = password(
            label: 'Administrator password',
            required: true,
            validate: fn (string $v) => mb_strlen($v) >= 4 ? null : 'Use at least 4 characters.',
        );

        if (! $this->buildFrontend()) {
            return self::FAILURE;
        }

        if (is_file($envFile)) {
            $backup = $envFile . '.backup-' . date('Ymd-His');
            if (! copy($envFile, $backup)) {
                $this->error('Could not back up the existing .env file.');
                return self::FAILURE;
            }
        } elseif (! copy(base_path('.env.example'), $envFile)) {
            $this->error('Could not create .env.');
            return self::FAILURE;
        }

        try {
            $this->putEnvValues($envFile, [
                'APP_NAME' => 'Rino',
                'APP_ENV' => 'production',
                'APP_DEBUG' => 'false',
                'APP_URL' => ($https ? 'https://' : 'http://') . $domain,
                'DB_CONNECTION' => 'mysql',
                'DB_URL' => '',
                'DB_HOST' => $dbHost,
                'DB_PORT' => $dbPort,
                'DB_DATABASE' => $dbName,
                'DB_USERNAME' => $dbUser,
                'DB_PASSWORD' => $dbPass,
                'SESSION_DRIVER' => 'database',
                'CACHE_STORE' => 'database',
                'QUEUE_CONNECTION' => 'database',
                'FILESYSTEM_DISK' => 'public',
            ]);

            @chmod($envFile, 0640);
            Artisan::call('config:clear');
            config([
                'database.default' => 'mysql',
                'database.connections.mysql.url' => null,
                'database.connections.mysql.host' => $dbHost,
                'database.connections.mysql.port' => $dbPort,
                'database.connections.mysql.database' => $dbName,
                'database.connections.mysql.username' => $dbUser,
                'database.connections.mysql.password' => $dbPass,
                'app.url' => ($https ? 'https://' : 'http://') . $domain,
                'filesystems.default' => 'public',
            ]);
            DB::purge('mysql');

            if (! filled(config('app.key'))) {
                $key = 'base64:' . base64_encode(random_bytes(32));
                $this->putEnvValues($envFile, ['APP_KEY' => $key]);
                config(['app.key' => $key]);
            }

            $this->runArtisan('migrate', ['--force' => true]);
            $this->runArtisan('db:seed', ['--force' => true]);
            $this->runArtisan('storage:link');
            $this->fixWritablePermissions();

            User::query()->create([
                'name' => $adminName,
                'email' => $adminEmail,
                'password' => Hash::make($adminPassword),
            ])->forceFill(['is_admin' => true])->save();

            $this->runArtisan('optimize:clear');

            if (! is_dir(storage_path('app'))) {
                mkdir(storage_path('app'), 0775, true);
            }

            if (file_put_contents(storage_path('app/rino-installed.lock'), date(DATE_ATOM) . "\n", LOCK_EX) === false) {
                throw new RuntimeException('Unable to write installation lock.');
            }
        } catch (Throwable $e) {
            $this->error('Installation stopped: ' . $e->getMessage());
            $this->warn('Your database or .env may be partially configured. Do not reset or erase anything without checking first.');
            return self::FAILURE;
        }

        outro('Rino application setup complete. Server configuration may still be required.');
        $this->line('Website: ' . ($https ? 'https://' : 'http://') . $domain);
        $this->line('Admin:   ' . ($https ? 'https://' : 'http://') . $domain . '/admin');
        if (confirm(label: 'Configure Nginx, queue, scheduler and optional SSL?', default: false)) {
            return $this->configureServer($domain);
        }

        $this->warn('Server setup was skipped. Complete it using php artisan rino:install --server-only before publishing the website.');

        return self::SUCCESS;
    }

    private function configureServerOnly(): int
    {
        if (! is_file(storage_path('app/rino-installed.lock'))) {
            $this->error('Complete the application installation first.');
            return self::FAILURE;
        }

        $url = (string) config('app.url');
        $domain = parse_url($url, PHP_URL_HOST);
        if (! is_string($domain) || ! filter_var($domain, FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME)) {
            $this->error('APP_URL must contain a valid domain.');
            return self::FAILURE;
        }

        return $this->configureServer($domain);
    }

    private function configureServer(string $domain): int
    {
        $script = base_path('install/server-setup.sh');
        if (! is_file($script)) {
            $this->error('Missing install/server-setup.sh');
            return self::FAILURE;
        }
        $this->warn('Server configuration uses sudo and requests permission before changes.');
        passthru('sudo bash ' . escapeshellarg($script) . ' ' . escapeshellarg($domain), $status);
        if ($status !== 0) {
            $this->error('Server setup did not complete. Retry with php artisan rino:install --server-only.');
            return self::FAILURE;
        }
        $this->info('Server setup finished. Verify the services listed in the output before launch.');
        return self::SUCCESS;
    }

    private function checkFrontendPrerequisites(): bool
    {
        if (! is_file(base_path('package.json'))) {
            $this->error('Missing package.json.');
            return false;
        }
        foreach (['node', 'npm'] as $program) {
            exec('command -v ' . escapeshellarg($program) . ' 2>/dev/null', $out, $status);
            if ($status !== 0) {
                $this->error($program . ' is missing. Install Node.js 22 and npm before continuing.');
                return false;
            }
            $out = [];
        }
        if (! is_file(base_path('package-lock.json'))) {
            $this->error('Missing package-lock.json. This installer uses npm ci.');
            return false;
        }
        return true;
    }

    private function buildFrontend(): bool
    {
        if (! confirm(label: 'Install frontend packages and build production assets?', default: true)) {
            $this->error('Frontend build is required for source ZIP installations.');
            return false;
        }

        foreach ([['npm', 'ci', '--no-audit', '--no-fund'], ['npm', 'run', 'build']] as $args) {
            $parts = array_map('escapeshellarg', $args);
            $command = 'cd ' . escapeshellarg(base_path()) . ' && ' . implode(' ', $parts);
            $this->line('Running ' . implode(' ', $args));
            passthru($command, $status);
            if ($status !== 0) {
                $this->error('Frontend build failed. Fix the error before retrying installation.');
                return false;
            }
        }
        if (! is_file(public_path('build/manifest.json'))) {
            $this->error('Frontend build finished without generating public/build/manifest.json.');
            return false;
        }
        return true;
    }

    private function fixWritablePermissions(): void
    {
        foreach ([storage_path(), base_path('bootstrap/cache')] as $directory) {
            if (! is_dir($directory) || ! is_writable($directory)) {
                throw new RuntimeException('Directory is not writable: ' . $directory);
            }
        }
        $this->line('Verified Laravel writable directories.');
        $this->warn('For Nginx, ensure www-data can write storage and bootstrap/cache as explained in the manual guide.');
    }

    private function databaseReady(string $host, string $port, string $database, string $user, string $password): bool
    {
        try {
            new \PDO(
                "mysql:host={$host};port={$port};dbname={$database};charset=utf8mb4",
                $user,
                $password,
                [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION, \PDO::ATTR_TIMEOUT => 5],
            );

            return true;
        } catch (Throwable) {
            return false;
        }
    }

    private function createLocalDatabase(string $database, string $username, string $password): bool
    {
        if (! preg_match('/^[A-Za-z0-9_]+$/D', $database) ||
            ! preg_match('/^[A-Za-z0-9_]+$/D', $username) ||
            strlen($username) > 32) {
            $this->error('For automatic MySQL setup, database names and usernames must use letters, numbers, or underscores.');
            return false;
        }

        $hexPassword = bin2hex($password);
        $sql = "CREATE DATABASE IF NOT EXISTS `{$database}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;\n";
        $sql .= "SET @pwd = CONVERT(0x{$hexPassword} USING utf8mb4);\n";
        $sql .= "SET @statement = CONCAT(\"CREATE USER IF NOT EXISTS '{$username}'@'127.0.0.1' IDENTIFIED BY \" , QUOTE(@pwd));\n";
        $sql .= "PREPARE command FROM @statement; EXECUTE command; DEALLOCATE PREPARE command;\n";
        $sql .= "GRANT ALL PRIVILEGES ON `{$database}`.* TO '{$username}'@'127.0.0.1';\n";

        passthru('sudo -v', $sudoStatus);
        if ($sudoStatus !== 0) {
            $this->error('Sudo authorization failed.');
            return false;
        }

        $process = proc_open(
            ['sudo', '-n', 'mysql', '--batch'],
            [0 => ['pipe', 'r'], 1 => ['pipe', 'w'], 2 => ['pipe', 'w']],
            $pipes,
        );

        if (! is_resource($process)) {
            $this->error('Unable to launch MySQL.');
            return false;
        }

        fwrite($pipes[0], $sql);
        fclose($pipes[0]);
        stream_get_contents($pipes[1]);
        fclose($pipes[1]);
        $error = stream_get_contents($pipes[2]);
        fclose($pipes[2]);
        $status = proc_close($process);

        if ($status !== 0) {
            $this->error('Database setup failed. Ensure local MySQL is running and your SSH user has sudo privileges.');
            $this->line(trim($error));
            $this->warn('Verify your sudo permission and retry.');
            return false;
        }

        $this->info('Database and user configured.');
        return true;
    }

    private function runArtisan(string $command, array $parameters = []): void
    {
        $status = Artisan::call($command, $parameters);
        $this->output->write(Artisan::output());

        if ($status !== 0) {
            throw new RuntimeException("Command failed: {$command}");
        }
    }

    private function putEnvValues(string $path, array $values): void
    {
        $content = file_get_contents($path);

        if ($content === false) {
            throw new RuntimeException('Unable to read .env.');
        }

        foreach ($values as $key => $value) {
            $encoded = '"' . str_replace(['\\', '"', "\n", "\r"], ['\\\\', '\\"', '\\n', '\\r'], (string) $value) . '"';
            $line = $key . '=' . $encoded;
            $pattern = '/^\s*#?\s*' . preg_quote($key, '/') . '=.*$/m';

            if (preg_match($pattern, $content)) {
                $content = preg_replace_callback($pattern, static fn () => $line, $content, 1);
            } else {
                $content .= "\n" . $line;
            }
        }

        if (file_put_contents($path, $content, LOCK_EX) === false) {
            throw new RuntimeException('Unable to write .env.');
        }
    }
}
