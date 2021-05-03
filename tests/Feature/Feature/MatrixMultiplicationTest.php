<?php

namespace Tests\Feature\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MatrixMultiplicationTest extends TestCase
{
    public function testAllParametersAreRequired() : void
    {
        $user = User::factory()->create([
            'email'     => 'jon@mail.com',
            'password'  => bcrypt('password')
        ]);
        $token = $user->createToken('API Token')->plainTextToken;
        $headers = ['Authorization' => "Bearer $token"];
        $this->json('get', 'api/matrix/multiply', [], $headers)
            ->assertStatus(422)
            ->assertJsonFragment([
                'a'  => ['The a field is required.'],
                'b'  => ['The b field is required.']
            ]);
    }

    public function testAllParametersAreValidMatrix() : void
    {
        $user = User::factory()->create([
            'email'     => 'jon@mail.com',
            'password'  => bcrypt('password')
        ]);
        $token = $user->createToken('API Token')->plainTextToken;
        $headers = ['Authorization' => "Bearer $token"];
        $this->json('get', 'api/matrix/multiply', ['a' => '[]', 'b' => '[]'], $headers)
            ->assertStatus(422)
            ->assertJsonFragment([
                'a'  => ['The a must be a valid matrix.'],
                'b'  => ['The b must be a valid matrix.']
            ]);
    }

    public function testOnlyValidMatricesAreMultiplied(): void
    {
        $user = User::factory()->create([
            'email'     => 'jon@mail.com',
            'password'  => bcrypt('password')
        ]);
        $token = $user->createToken('API Token')->plainTextToken;
        $headers = ['Authorization' => "Bearer $token"];
        $this->json('get', 'api/matrix/multiply', ['a' => '[[1,2]]', 'b' => '[[1]]'], $headers)
            ->assertStatus(400);
    }


    public function testMatrixAreCorrectlyMultiplied(): void {
        $user = User::factory()->create([
            'email'     => 'jon@mail.com',
            'password'  => bcrypt('password')
        ]);
        $token = $user->createToken('API Token')->plainTextToken;
        $headers = ['Authorization' => "Bearer $token"];

        $this->json('get', 'api/matrix/multiply', [
            'a' => '[[1,2],[8,4]]',
            'b' => '[[9,8],[8,-4]]',
        ], $headers)
            ->assertStatus(200);
    }


    public function testReturnedMatrixResultIsProperlyFormatted(): void
    {
        $user = User::factory()->create([
            'email'     => 'jon@mail.com',
            'password'  => bcrypt('password')
        ]);
        $token = $user->createToken('API Token')->plainTextToken;
        $headers = ['Authorization' => "Bearer $token"];

        $this->json('get', 'api/matrix/multiply', [
            'a' => '[[-4,4,6],[7,-3,-1]]',
            'b' => '[[5,1,0],[-2,6,-1],[3,2,4]]'
        ], $headers)
            ->assertStatus(200)
            ->assertJson([
                "data" => [
                    "0" =>[
                        'A' => -10,
                        'B' => 32,
                        'C' => 20
                    ],
                    "1"  =>[
                        'A' => 38,
                        'B' => -13,
                        'C' => -1
                    ]
                ]
            ]);
    }
}
