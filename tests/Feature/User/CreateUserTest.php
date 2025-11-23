<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserWelcomeMail;
use App\Mail\AdminNewUserNotificationMail;

class CreateUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_be_created_successfully()
    {
        Mail::fake();

        $response = $this->postJson('/api/users', [
            'name' => 'Husen Test',
            'email' => 'husen@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('users', [
            'email' => 'husen@example.com'
        ]);

        Mail::assertSent(UserWelcomeMail::class);
        Mail::assertSent(AdminNewUserNotificationMail::class);
    }
}
