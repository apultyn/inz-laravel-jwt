<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Book;
use App\Models\User;
use App\Models\Review;


class ReviewControllerSecurityTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;

    public function test_create_review_unauth(): void
    {
        $book = Book::factory()->create();

        $reviewData = [
            'book_id' => $book->id,
            'stars' => 5,
            'comment' => 'fine'
        ];
        $this->postJson('/api/reviews', $reviewData)
            ->assertStatus(401);
    }

    public function test_create_review_user(): void
    {
        $book = Book::factory()->create();
        $user = User::factory()->create();

        $reviewData = [
            'book_id' => $book->id,
            'stars' => 5,
            'comment' => 'fine'
        ];
        $this->actingAs($user, 'api')
            ->postJson('/api/reviews', $reviewData)
            ->assertStatus(201);

        $this->assertDatabaseHas('reviews', [...$reviewData, 'user_id' => $user->id]);
    }

    public function test_create_review_admin(): void
    {
        $book = Book::factory()->create();
        $admin = User::factory()->admin()->create();

        $reviewData = [
            'book_id' => $book->id,
            'stars' => 5,
            'comment' => 'fine'
        ];
        $this->actingAs($admin, 'api')
            ->postJson('/api/reviews', $reviewData)
            ->assertStatus(201);

        $this->assertDatabaseHas('reviews', [...$reviewData, 'user_id' => $admin->id]);
    }
}