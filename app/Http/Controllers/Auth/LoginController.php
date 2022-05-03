<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Redirect;

use App\Http\Controllers\Controller;
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

        if($request->has('redirect_to')) return Redirect::to($request->redirect_to);
        return redirect()->route('home');
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('index');
    }
}