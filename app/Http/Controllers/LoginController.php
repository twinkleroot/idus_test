<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    public function __construct()
    {
        
    }

    public function login(Request $request) : JsonResponse
    {
        $credentials = $request->only('email', 'password');

        // if (! $token = auth('web')->attempt($credentials)) { 
        //     return response()->json(['error' => 'Unauthorized'], 401); 
        // }

        $result = ['msg' => 'login failed!'];
        if (Auth::attempt($credentials)) {
            // 로그인 처리, 어떻게?
            $result['msg'] = 'login success!';
        }

        return response()->json($result);
    }

    public function logout() : JsonResponse
    {
        Auth::logout();

        return response()->json([
            'msg' => 'logout success!'
        ]);
    }
}