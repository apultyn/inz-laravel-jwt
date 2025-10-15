<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Book;
use App\Models\User;


class EndpointSecurityTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;
    public function test_create_book_unauth(): void
    {
        $bookData = ['title' => 'Nowa Książka', 'author' => 'Autor'];
        $this->postJson('/api/books', $bookData)
            ->assertStatus(401);
    }

    public function test_create_book_user(): void
    {
        $user = User::factory()->create();
        $bookData = ['title' => 'Nowa Książka', 'author' => 'Autor'];

        $this->actingAs($user, 'api')
            ->postJson('/api/books', $bookData)
            ->assertStatus(403);
    }

    public function test_create_book_admin(): void
    {
        $admin = User::factory()->admin()->create();
        $bookData = ['title' => 'Nowa Książka od Admina', 'author' => 'Admin'];

        $this->actingAs($admin, 'api')
            ->postJson('/api/books', $bookData)
            ->assertStatus(201);
    }
}
