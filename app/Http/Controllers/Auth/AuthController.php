<?php

namespace App\Http\Controllers\Auth;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

use App\Http\Controllers\BaseController;
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
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'error' => __('Error al intentar crear Usuario')
            ], 401);
        } catch (\Exception $e) {
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
        $jwt_token = JWTAuth::attempt($credentials);

        if (!$jwt_token) {
            return response()->json([
                'error' => 'Unauthorized',
                'message' => __('Correo o contraseña no válidos.')
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
        $this->validate(request()->all(), [
            'token' => 'required'
        ]);

        try {
            JWTAuth::invalidate(request('token'));
            return  response()->json([
                'status' => 'ok',
                'message' => __('Cierre de sesión exitoso.')
            ]);
        } catch (JWTException  $exception) {
            return  response()->json([
                'status' => 'unknown_error',
                'message' => __('Al usuario no se le pudo cerrar la sesión.')
            ], 500);
        }
        auth()->logout();
        return response()->json([
            'message' => __('Successfully logged out')
        ]);
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
