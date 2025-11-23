<?php

namespace App\Services;

use App\Mail\AdminNewUserNotificationMail;
use App\Mail\UserWelcomeMail;
use App\Models\User;
use App\Queries\UserQuery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class UserService
{
    /**
     * @throws \Throwable
     */
    public function createUser(array $data): User
    {
        DB::beginTransaction();

        try {

            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => $data['role'] ?? 'user',
            ]);

            Mail::to($user->email)->send(new UserWelcomeMail($user));

            $adminEmail = config('mail.admin_email'); // we will add this later
            Mail::to($adminEmail)->send(new AdminNewUserNotificationMail($user));

            DB::commit();

            return $user;
        } catch (\Throwable $e) {

            DB::rollBack();

            Log::error('Failed creating user', [
                'error' => $e->getMessage(),
                'data' => $data,
            ]);

            throw $e;
        }
    }

    public function getUsers(Request $request)
    {
        return UserQuery::apply($request);
    }
}
