<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    private $payload = [
        'name'      => 'test',
        'email'     => 'test@mail.com',
        'password'  => '12345678',
    ];
    private $url = 'api/register';

    public function testLoginRequresNameEmailAndPassword()
    {
        $this->json('POST', $this->url)
            ->assertStatus(422)
            ->assertJsonStructure([
                'name',
                'email',
                'password',
            ]);
    }

    public function testLoginRequiresPasswordConfirmation()
    {
        $this->json('POST', $this->url, $this->payload)
            ->assertStatus(422)
            ->assertJson([
                'password' => ['The password confirmation does not match.'],
            ]);
    }

    public function testLoginSuccessfully()
    {
        $payload = $this->payload;
        $payload['password_confirmation'] = $payload['password'];

        $this->json('POST', $this->url, $payload)
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'name',
                    'email',
                    'api_token',    
                ]
            ]);
    }
}
