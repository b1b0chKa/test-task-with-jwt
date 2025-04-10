<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ValidateRequest;
use App\Http\Resources\AuthResource;
use App\Http\Resources\RegisterResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function register(RegisterRequest $request)
	{
		$user = User::create($request->validated());

		return new RegisterResource($user);
	}

	public function login(ValidateRequest $request)
	{
		$credentials = $request->only('email', 'password');
        $token = Auth::attempt($credentials);

		if (!$token)
			return response(null, 401);

		$user = Auth::user();
	return new AuthResource($user);

	}

	public function logout()
	{
		Auth::logout();
		return response()->json([
			'message' => 'You are logout',
		]);
	}
	
	public function refresh()
    {
        return response()->json([
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }
}
