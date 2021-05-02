<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Repositories\UserRepository;
use Illuminate\Database\QueryException;
use Exception;

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
                'error' => __('Error trying to create User')
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
                'message' => __('Invalid email or password')
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
                'message' => __('Successful logout')
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 'unknown_error',
                'message' => __('User could not be logged out')
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

        return response()->json([
            'status' => 'success',
            'data' => $user
        ]);
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
            'user' => $user->getAllInformation(),
        ], $code)
        ->header('Authorization', $token);
    }
}
