<?php

namespace Tests\Unit;

use App\Models\User;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserPolicyTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_cannot_be_edited()
    {
        $policy = new UserPolicy;

        $editor = User::factory()->create(['role' => 'manager']);
        $admin = User::factory()->create(['role' => 'administrator']);

        $this->assertFalse($policy->update($editor, $admin));
    }
}
