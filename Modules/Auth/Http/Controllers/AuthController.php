<?php

namespace Modules\Auth\Http\Controllers;

use Illuminate\Http\Request;

use Modules\User\Models\User;
use Modules\Core\Http\Controllers\BaseController;

/**
 * Controlador de todo el flujo de autenticacion del sistema en base a JWT
 *
 * @author Alejandro Méndez <almendez@netred.cl>
 * @category Controller
 */
class AuthController extends BaseController
{
    /**
     * Constructor de clase, se aplica middleware 'auth:api'
     * a todos los metodos menos a login y register
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Register new User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        try {
            $user = User::create([
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
        if (!$token = auth()->attempt($credentials, $rememberMe)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->respondWithToken($token);
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
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
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
