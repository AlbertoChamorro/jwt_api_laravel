<?php

namespace App\Http\Controllers;
use App\Http\Requests\RegisterFormRequest;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use App\User;

class AuthController extends Controller
{

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
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (!$token = JWTAuth::attempt($credentials)) {
            return response([
                'status_code' => 2000,
                'error' => 'credenciales inválidas'
            ], 200);
        }
        return response([
            'accessToken' => $token
        ]);
    }
    public function userProfile(Request $request)
    {
        // $user = User::find(Auth::user()->id);
        // return response([
        //     'data' => $user
        // ]);

        // $this->validate($request, [
        //     'token' => 'required'
        // ]);
 
        $token = $request->header('Authorization');
        $user = JWTAuth::authenticate($token);
 
        return response()->json(['data' => $user]);
    }
    /**
     * Log out
     * Invalidate the token, so user cannot use it anymore
     * They have to relogin to get a new token
     *
     * @param Request $request
     */
    public function logout(Request $request) {

        $token = $request->header('Authorization');

        try {
            JWTAuth::invalidate($token);
            return response([
                'data' => true
            ]);
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response([
                'error' => 'Ha ocurrido un error.'
            ], 200);
        }
    }

    public function renewToken()
    {
        return response([
            'data' => true
        ]);
    }
}