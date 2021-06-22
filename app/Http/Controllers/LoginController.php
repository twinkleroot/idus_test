<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    private $result;

    public function __construct()
    {
        $this->result = [
            'code' => 1000,
            'message' => 'success.'
        ];
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $httpResponseCode = 200;

        if (Auth::attempt($credentials)) {
            // 로그인 처리
        } else {
            $this->result['code'] = 2000;
            $this->result['message'] = 'login fail.';
            $httpResponseCode = 401;
        }

        return response()->json($this->result, $httpResponseCode);
    }

    public function logout()
    {
        Auth::logout();

        return response()->json($this->result);
    }
}