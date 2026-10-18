<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use function Laravel\Prompts\intro;
use function Laravel\Prompts\outro;
use function Laravel\Prompts\password;
use function Laravel\Prompts\text;

class CreateAdmin extends Command
{
    protected $signature = 'rino:admin';

    protected $description = 'Create a Rino administrator account';

    public function handle(): int
    {
        intro('Rino Administrator Setup');

        $name = text(
            label: 'Administrator name',
            required: true,
            validate: fn (string $value) => mb_strlen($value) > 255
                ? 'Name must not exceed 255 characters.'
                : null,
        );

        $email = text(
            label: 'Administrator email',
            required: true,
            validate: function (string $value) {
                $validator = Validator::make(
                    ['email' => $value],
                    [
                        'email' => [
                            'required',
                            'email',
                            'max:255',
                            'unique:users,email',
                        ],
                    ],
                );

                return $validator->fails()
                    ? $validator->errors()->first('email')
                    : null;
            },
        );

        $adminPassword = password(
            label: 'Administrator password',
            required: true,
            validate: fn (string $value) => mb_strlen($value) < 4
                ? 'Password must contain at least 4 characters.'
                : null,
        );

        $user = new User();

        $user->name = $name;
        $user->email = $email;
        $user->password = Hash::make($adminPassword);
        $user->is_admin = true;

        $user->save();

        outro('Administrator created successfully.');

        return self::SUCCESS;
    }
}
