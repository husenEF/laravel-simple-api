<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserService
{
    public function createUser(array $data): User
    {
        DB::beginTransaction();

        try {

            $user = User::create([
                'name'     => $data['name'],
                'email'    => $data['email'],
                'password' => Hash::make($data['password']),
                'role'     => $data['role'] ?? 'user',
            ]);

            // contoh: kirim email (opsional)
            // Mail::to($user->email)->send(new UserWelcomeMail($user));

            DB::commit();

            return $user;

        } catch (\Throwable $e) {

            DB::rollBack();

            Log::error('Failed creating user', [
                'error' => $e->getMessage(),
                'data'  => $data,
            ]);

            throw $e;
        }
    }
}
