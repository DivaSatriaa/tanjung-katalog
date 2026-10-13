<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

#[Signature('make:admin {--name= : Nama admin} {--email= : Email admin}')]
#[Description('Buat akun admin baru atau jadikan user yang sudah ada sebagai admin')]
class MakeAdminUser extends Command
{
    public function handle(): int
    {
        $name = $this->option('name') ?: $this->ask('Nama admin');
        $email = $this->option('email') ?: $this->ask('Email admin');

        $validator = Validator::make(
            ['name' => $name, 'email' => $email],
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'max:255'],
            ],
        );

        if ($validator->fails()) {
            $this->error($validator->errors()->first());

            return self::FAILURE;
        }

        $user = User::query()->where('email', $email)->first();

        if ($user !== null) {
            $user->forceFill(['is_admin' => true])->save();

            $this->info("{$email} sekarang menjadi admin. Password tidak diubah.");

            return self::SUCCESS;
        }

        $password = $this->secret('Password (minimal 8 karakter)');

        if (! is_string($password) || strlen($password) < 8) {
            $this->error('Password minimal 8 karakter.');

            return self::FAILURE;
        }

        if ($password !== $this->secret('Ulangi password')) {
            $this->error('Konfirmasi password tidak cocok.');

            return self::FAILURE;
        }

        User::query()->create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'is_admin' => true,
        ]);

        $this->info("Admin {$email} berhasil dibuat.");

        return self::SUCCESS;
    }
}
