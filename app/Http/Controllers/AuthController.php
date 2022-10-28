<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function login(Request $request)
    {
        $credentials = $request->only('username','password');
        if (Auth::attempt(['email' => $request->username, 'password' => $request->password])) {

            // dd('login');
            return response()->json([
                'status' => 'success',
                'message' => 'Login Success',
                'user' => Auth::user()
            ],200);
        }else {
            return response()->json([
                'status' => 'fail',
                'message' => 'Login fail',
            ],401);
        }
    }

}
