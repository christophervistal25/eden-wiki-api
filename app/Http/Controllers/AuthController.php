<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers;
use App\User;

class AuthController extends Controller
{

    public function login(Request $request)
    {

        //validate incoming request 
        $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only(['email', 'password']);

        if (!$token = Auth::attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function register(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        $user =  User::create([
            'email' => $request->email,
            'password' => app('hash')->make($request->password),
        ]);

        $token = auth()->login($user);

        return $this->respondWithToken($token);
    }
}
