<?php

namespace Tests\Feature\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function testLoginRequiresEmailAndPassword(): void
    {
        $this->json('POST', 'api/auth/sign-in')
            ->assertStatus(422)
            ->assertJsonFragment([
                'email'     => ['The email field is required.'],
                'password'  => ['The password field is required.'],
            ]);
    }

    public function testUserLoginSuccessfully(): void
    {
        $user = User::factory()->create([
            'email'     => 'jon@mail.com',
            'password'  => bcrypt('password')
        ]);



        $payload = [
            'email'     => 'jon@mail.com',
            'password'  => 'password'
        ];

        $this->json('POST', 'api/auth/sign-in', $payload)
            ->assertStatus(200)
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
            ]);

    }

}
