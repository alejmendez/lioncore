<?php

namespace App\Http\Controllers\Auth;

use Exception;
use Illuminate\Database\QueryException;

use App\Http\Controllers\BaseController;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;

class AuthController extends BaseController
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->middleware('auth:api', [
            'except' => ['login', 'register']
        ]);
    }

    /**
     * Register new User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register()
    {
        try {
            $this->userRepository->create(
                request([
                    'email',
                    'password',
                    'name'
                ])
            );

            return $this->login();
        } catch (QueryException $e) {
            return response()->json([
                'error' => trans('auth.error_trying_to_create_user')
            ], 401);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 401);
        }
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);
        $jwt_token = auth()->attempt($credentials);

        if (!$jwt_token) {
            return response()->json([
                'error' => 'Unauthorized',
                'message' => trans('auth.invalid_email_or_password')
            ], 401);
        }

        return $this->respondWithToken($jwt_token, 201);
    }

    public function payload()
    {
        return response()->json(auth()->payload());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        try {
            auth()->logout();
            return response()->json([
                'status' => 'ok',
                'message' => trans('auth.successful_logout')
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 'unknown_error',
                'message' => trans('auth.user_could_not_be_logged_out')
            ], 500);
        }
    }
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    public function currentUser()
    {
        $user = auth()->user();

        return response()->json(UserResource::make($user));
    }
    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token, $code = 200)
    {
        $user = auth()->user();

        return response([
            'status' => 'success',
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => UserResource::make($user),
        ], $code)
        ->header('Authorization', $token);
    }
}
