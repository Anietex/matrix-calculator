<?php

namespace Tests\Feature\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    public function testRegistrationRequiresBasicInfo(): void
    {
        $this->json('post', '/api/auth/sign-up')
            ->assertStatus(422)
            ->assertJsonFragment([
                'name' => ['The name field is required.'],
                'email' => ['The email field is required.'],
                'password' => ['The password field is required.'],
            ]);
    }

    public function testRegistrationRequiresPasswordConfirmation(): void {
        $payload = [
            'name' => 'John',
            'email' => 'john@mail.com',
            'password' => 'password',
        ];

        $this->json('post', '/api/auth/sign-up', $payload)
            ->assertStatus(422)
            ->assertJsonFragment([
                'password' => ['The password confirmation does not match.'],
            ]);
    }

    public function testSuccessfulRegistration(): void
    {
        $payload = [
            'name' => 'John',
            'email' => 'john@mail.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $this->json('post', '/api/auth/sign-up', $payload)
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'user' => [
                        'id',
                        'name',
                        'email',
                        'created_at',
                        'updated_at',
                    ],
                    'token'
                ],
            ]);;
    }
}
