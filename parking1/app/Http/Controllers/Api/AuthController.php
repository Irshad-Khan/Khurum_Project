<?php

namespace App\Http\Controllers\Api;

use App\Contracts\AuthInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Http\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    use ApiResponseTrait;

    protected $guard;
    protected $authInterface;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(AuthInterface $authInterface)
    {
        $this->middleware('auth:api', ['except' => ['login','register','forgotPassword']]);
        $this->authInterface = $authInterface;
        $this->guard = "api";
    }

    /**
     * Get a JWT token via given credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        
        if (!$token = auth($this->guard)->attempt($credentials)) {
            return $this->responseWithError('Email or Password is Incorrect!', Response::HTTP_UNAUTHORIZED);
        }
        
        return $this->respondWithToken($token);
    }
    
    /**
     * User signup for Individual
     *
     * @param Type $var
     * @return void
     */
    public function register(RegisterRequest $request)
    {
        return $this->responseWithSuccess(true,'User Created Successfully!',
        (new UserResource($this->authInterface->signup($request))), Response::HTTP_OK);
    }

    /**
     * Get the authenticated User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile()
    {
        return response()->json($this->guard()->user());
    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $this->guard()->logout();
        return $this->responseWithSuccess(true, 'User Logged out Successfully',null,Response::HTTP_OK);

    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth($this->guard)->factory()->getTTL() * 60
        ]);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard();
    }

    /**
     * Send Password Reset Link
     *
     * @param Request $request
     * @return void
     */
    public function forgotPassword(ForgotPasswordRequest $request)
    {
        return $this->responseWithSuccess(true, $this->authInterface->forgotPassword($request),null,Response::HTTP_OK);
    }
}
