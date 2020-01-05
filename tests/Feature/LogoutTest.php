<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    private $url = 'api/logout';
    private $urlArticles = 'api/articles';

    public function testUserIsLoggedOutSuccessfully() 
    {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $this->json('GET', $this->urlArticles, [], $headers)->assertStatus(200);
        $this->json('POST', $this->url, [], $headers)->assertStatus(200);

        $user = User::find($user->id);
        $this->assertEquals(null, $user->api_token);
    }

    public function testUserWithNullToken()
    {
        // Simulating login
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        // Simulating logout
        $user->api_token = null;
        $user->save();

        $this->json('GET', $this->urlArticles, [], $headers)->assertStatus(401);
    }
}
