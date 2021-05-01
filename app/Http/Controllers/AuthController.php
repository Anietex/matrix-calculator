<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignInRequest;
use App\Http\Requests\SignUpRequest;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use ApiResponse;

    /**
     * Handles signing up of new users
     *
     * @param SignUpRequest $request
     * @return JsonResponse
     */
    public function signUp(SignUpRequest $request) : JsonResponse {

        $user = new User();
        $user->name = $request->name;
        $user->password = bcrypt($request->password);
        $user->email = $request->email;
        $user->save();

        $token = $user->createToken('API Token')->plainTextToken;

        $responseData = [
            'user'  => $user,
            'token' => $token,
        ];

       return  $this->success($responseData,'You have successfully signed up', 201);
    }

    /**
     * Handles signing in of users
     *
     * @param SignInRequest $request
     * @return JsonResponse
     */
    public function signIn(SignInRequest $request) : JsonResponse {

        if(!Auth::attempt($request->only(['email','password']))){
            return $this->error('Invalid email or password', 401);
        }

        $token = \auth()->user()->createToken('API Token')->plainTextToken;

        $response = [
            'user'  => \auth()->user(),
            'token' => $token
        ];

        return $this->success($response);

    }

    public function signOut() : JsonResponse{

        \auth()->user()->tokens()->delete();

       return $this->success([], 'Logged out successfully');
    }
}
