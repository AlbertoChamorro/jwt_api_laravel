<?php

namespace App\Http\Controllers;
use App\Http\Requests\RegisterFormRequest;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use App\User;

/**
 * @resource Account
 *
 * This endpoints allow operations on accounts
 */

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        // middleware - [ api | auth:api ]
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Register User
     */
    public function register(RegisterFormRequest $request)
    {
        $user = new User;
        $user->email = $request->email;
        $user->name = $request->name;
        $user->password = bcrypt($request->password);
        $user->save();

        return response([
            'data' => $user
        ], 200);
    }


    /**
     * Login
     * Get a JWT via given credentials.
     */
    public function login(Request $request)
    {
        // $credentials = $request->only('email', 'password');
        // if (!$token = JWTAuth::attempt($credentials)) {
        //     return response([
        //         'status_code' => 2000,
        //         'error' => 'credenciales inválidas'
        //     ], 200);
        // }
        // return response([
        //     'accessToken' => $token
        // ]);

        $credentials = $request->only('email', 'password');

        if (!$token = auth()->attempt($credentials)) {
            return response()->json([
                'error' => 'Credenciales inválidas',
                'status_code' => 4001
            ], 401);
        }

        return $this->respondWithToken($token);
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
            'accessToken' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    /**
     * Profile User
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile(Request $request)
    {
        // auth()->user()
        $token = $request->header('Authorization');
        $user = JWTAuth::authenticate($token);
 
        return response()->json(['data' => $user]);
    }

    /**
     * LogOut
     * Invalidate the token, so user cannot use it anymore
     * They have to relogin to get a new token
     *
     * @param Request $request
     */
    public function logout(Request $request) {

        // $token = $request->header('Authorization');

        // try {
        //     JWTAuth::invalidate($token);
        //     return response([
        //         'data' => true
        //     ]);
        // } catch (JWTException $e) {
        //     // something went wrong whilst attempting to encode the token
        //     return response([
        //         'error' => 'Ha ocurrido un error.'
        //     ], 200);
        // }
        auth()->logout();

        return response()->json([ 'data' => true ]);
    }

    /**
     * Renew Token.
     */
    public function renewToken()
    {
       return $this->respondWithToken(auth()->refresh());
    }
}