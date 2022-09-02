<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->prepareData())) {
            return response()->json([
                'test' => $request->prepareData(),
                'message' => 'Authentication failed!'
            ], 401);
        }

        $user = Auth::user();

        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        $token->save();


        $user['token'] = $tokenResult->accessToken;
        $response =  array('success' => true, 'data' => $user, 'message' => "Login success");
        return response()->json($response);


    }

    public function logout(Request $request) {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logout Success',
        ]);
    }
}
