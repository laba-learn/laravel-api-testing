<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    private $url = 'api/login';

    public function testLoginRequired()
    {   
        $this->json('POST', $this->url)
            ->assertStatus(422)
            ->assertJsonStructure([
                'email',
                'password',
            ]);
            
    }

    public function testLoginSuccessfully() 
    {

        $payload = collect([
            'email'      => 'test@mail.com',
            'password'  => '12345678',
        ]);

        // Create user
        factory(User::class)->create([
            'email'     => $payload->get('email'),
            'password'  => Hash::make($payload->get('password')),
        ]);

        $this->json('POST', $this->url, $payload->toArray())
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'email',
                    'name',
                    'api_token',
                ]
            ]);
    }
}
