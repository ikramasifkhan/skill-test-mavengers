<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;

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


    public function login(LoginRequest $request)
    {
        try{
            if (! $token = auth()->attempt($request->validated())) {
                return response()->errorResponse('Invalid email or password', 401);
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

    public function logout(){
        try{
            auth()->logout();
            return response()->successResponse([], 'Logout successful', 200);
        }catch(Exception $exception){
            Log::info($exception->getMessage());
            return response()->errorResponse();
        }
    }

}
