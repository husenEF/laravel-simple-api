<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetUsersTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_users_with_pagination_and_filters()
    {
        User::factory()->count(5)->create();

        $response = $this->getJson('/api/users?search=&sortBy=name&page=1');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'email',
                        'role',
                        'created_at',
                        'orders_count',
                        'can_edit',
                    ],
                ],
            ]);
    }
}
