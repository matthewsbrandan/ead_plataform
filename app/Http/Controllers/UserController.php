<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class UserController extends Controller
{
    protected $take;

    public function __construct(){
        $this->take = 20;
    }
    public function create(){
        return view('auth.register');
    }
    public function store(Request $request){
        if(User::whereEmail($request->email)->first()) return redirect()
            ->back()
            ->with('register-error-type','email');

        if(!$user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'type' => $request->type
        ])) return redirect()
            ->back()
            ->with('message','Houve um erro ao cadastrar o usuário');

        Auth::login($user);

        return redirect()->route('home')->with(
            'welcome',
            auth()->user()->name.',<br/>Bem vindo(a) ao '. config('app.name')
        );
    }
    public function profile(){
        return view('user.profile');
    }
    public function notification(){
        return view('user.notification');
    }

    // BEGIN:: FORGOT PASSWORD
    public function forgotPassword(){
        return view('auth.forgot_password');
    }
    public function sendRedefinePassword(Request $request){
        dd('Enviar solicitação de redefinição de senha', $request->all());
    }
    // END:: FORGOT PASSWORD
}