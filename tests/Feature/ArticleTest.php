<?php

namespace Tests\Feature;

use App\User;
use App\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    private $url = 'api/articles';

    public function testArticleCreatedSuccessfully()
    {
        $payload = [
            'title' => 'lorem',
            'body'  => 'ipsum',
        ];

        // Create article
        $this->json('POST', $this->url, $payload, $this->generateHeader())
            ->assertStatus(201)
            ->assertJson($payload);
    }

    public function testArticleUpdatedSuccessfully() {

        // Create article
        $article = factory(Article::class)->create([
            'title' => 'new article',
            'body'  => 'new content',
        ]);

        // Update article
        $payload = [
            'title' => 'lorem update',
            'body'  => 'ipsum update',
        ];
        $this->json('PUT', "{$this->url}/{$article->id}", $payload, $this->generateHeader())
            ->assertStatus(200)
            ->assertJson($payload);
    }

    public function testArticleDeletedSuccessfully() {

        // Create article
        $article = factory(Article::class)->create([
            'title' => 'new article',
            'body'  => 'new content',
        ]);

        // Delete article
        $this->json('DELETE', "/{$this->url}/{$article->id}", [], $this->generateHeader())
            ->assertStatus(200)
            ->assertJson(['success' => true]);
    }

    public function testArticleAreListedCorrectly() {

        // Get listed data
        $this->json('GET', $this->url, [], $this->generateHeader())
            ->assertStatus(200)
            ->assertJsonCount(10)
            ->assertJsonStructure([
                '*' => ['id', 'body', 'title', 'created_at', 'updated_at'],
            ]);
    }

    private function generateHeader() {

        // Register user
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];
        return $headers;
    }
}
