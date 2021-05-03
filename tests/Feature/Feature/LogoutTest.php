<?php

namespace Tests\Feature\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    public function testUserLogsOutSuccessfully(): void
    {
        $user = User::factory()->create([
            'email'     => 'jon@mail.com',
            'password'  => bcrypt('password')
        ]);
        $token = $user->createToken('API Token')->plainTextToken;
        $headers = ['Authorization' => "Bearer $token"];
        $this->json('get', 'api/matrix/multiply?a=[[0,3,5],[5,5,2]]&b=[[3,4],[3,-2],[4,-2]]', [], $headers)->assertStatus(200);
        $this->json('post', '/api/auth/sign-out', [], $headers)->assertStatus(200);

        $tokens = $user->tokens->toArray();

        $this->assertEmpty($tokens);
    }

    public function testProtectedContentNotAccessedAfterLogout(): void
    {
        $user = User::factory()->create([
            'email'     => 'jon@mail.com',
            'password'  => bcrypt('password')
        ]);
        $token = $user->createToken('API Token')->plainTextToken;
        $headers = ['Authorization' => "Bearer $token"];
        $user->tokens()->delete();
        $this->json('get', 'api/matrix/multiply?a=[[0,3,5],[5,5,2]]&b=[[3,4],[3,-2],[4,-2]]', [], $headers)->assertStatus(401);

    }
}
