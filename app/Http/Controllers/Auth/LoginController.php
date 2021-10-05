<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function authenticate(Request $request){
        if(Auth::check()) Auth::logout();

        if(!User::whereEmail($request->email)->first()) return redirect()
            ->back()
            ->with('auth-error-type','email');

        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) return redirect()
            ->back()
            ->with('auth-error-type','password');

        return redirect()->route('home');
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('index');
    }
}