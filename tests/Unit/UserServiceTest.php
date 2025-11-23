<?php

namespace Tests\Unit;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_user_via_service()
    {
        Mail::fake();

        $service = new UserService;

        $data = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'Password123!',
        ];

        $user = $service->createUser($data);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('test@example.com', $user->email);

        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
    }
}
