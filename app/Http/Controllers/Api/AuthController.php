<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }


    public function login(AuthRequest $request)
    {
        try{
            if (! $token = auth()->attempt($request->validated())) {
                return response()->errorResponse('Unauthenticated', 401);
            }
            $data = [
                'access_token' => $token,
                'token_type' => 'bearer',
                'user' => auth()->user()
            ];
            return response()->successResponse($data, 'Login successful');
        }catch(Exception $exception){
            Log::info($exception->getMessage());
            return response()->errorResponse();
        }

    }

    public function register(UserRequest $request)
    {
        try{
            $data = $request->only(['name', 'email']);
            $data['password'] = bcrypt($request->password);
            $user = User::create($data);
            return response()->successResponse(new UserResource($user), 'Registration successful', 201);
        }catch(Exception $exception){
            Log::info($exception->getMessage());
            return response()->errorResponse();
        }

    }

}
