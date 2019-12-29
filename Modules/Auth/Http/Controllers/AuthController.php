<?php

namespace Modules\Auth\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

use Modules\User\Models\User;
use Modules\Core\Http\Controllers\BaseController;
use Modules\User\Repositories\UserRepository;

/**
 * Controlador de todo el flujo de autenticacion del sistema en base a JWT
 *
 * @author Alejandro Méndez <almendez@gmail.cl>
 * @category Controller
 */
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
    public function register(Request $request)
    {
        try {
            $user = $this->userRepository->create([
                'email'    => $request->email,
                'password' => $request->password,
                'name'     => $request->name,
            ]);

            $token = auth()->login($user);

            return $this->respondWithToken($token, 201);
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
        $rememberMe = request('rememberMe', false);
        $jwt_token = null;

        if (!$jwt_token = JWTAuth::attempt($credentials)) {
            return response()->json([
                'error' => 'Unauthorized',
                'message' => __('Correo o contraseña no válidos.')
            ], 401);
        }

        return $this->respondWithToken($jwt_token);
    }
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function user()
    {
        return response()->json(auth()->user());
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
        return response()->json([
            'user' => auth()->user(),
        ], 200);
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
        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user(),
        ], $code);
    }
}
