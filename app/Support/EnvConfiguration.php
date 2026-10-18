<?php

namespace App\Support;

use RuntimeException;

final class EnvConfiguration
{
    public static function read(): array
    {
        $path = base_path('.env');

        if (! is_file($path)) {
            return [];
        }

        $values = [];

        foreach (file($path, FILE_IGNORE_NEW_LINES) ?: [] as $line) {
            if (preg_match('/^\s*([A-Z][A-Z0-9_]*)\s*=\s*(.*)$/', $line, $matches) !== 1) {
                continue;
            }

            $value = trim($matches[2]);

            if (
                strlen($value) >= 2 &&
                in_array($value[0], ['"', "'"], true) &&
                str_ends_with($value, $value[0])
            ) {
                $value = substr($value, 1, -1);
            }

            $values[$matches[1]] = $value;
        }

        return $values;
    }

    public static function write(array $values): void
    {
        $path = base_path('.env');

        if (! is_file($path)) {
            $example = base_path('.env.example');

            if (! is_file($example) || ! copy($example, $path)) {
                throw new RuntimeException('Unable to create .env.');
            }
        }

        $content = file_get_contents($path);

        if ($content === false) {
            throw new RuntimeException('Unable to read .env.');
        }

        foreach ($values as $key => $value) {
            $encoded = '"'.str_replace(
                ['\\', '"'],
                ['\\\\', '\\"'],
                (string) $value
            ).'"';

            $line = $key.'='.$encoded;

            $pattern = '/^[ \t]*'.preg_quote($key, '/').'[ \t]*=.*$/m';

            if (preg_match($pattern, $content)) {
                $content = preg_replace($pattern, $line, $content, 1);
            } else {
                $content = rtrim($content)."\n".$line."\n";
            }
        }

        if (file_put_contents($path, $content, LOCK_EX) === false) {
            throw new RuntimeException('Unable to save .env.');
        }
    }
}
