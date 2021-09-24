<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function index(){
        return view('welcome');
    }
    public function login(){
        return view('login');
    }
    public function logar(Request $request){
        $user = User::where('email',$request->email)->first();
        if(!$user) return redirect()->route('login')->with('fail','Email não encontrado');

        if(!Hash::check($request->password,$user->password)) return redirect()->route('login')->with('fail','Senha inválida');

        return redirect()->route('home');
    }
    public function register(){
        return view('register');
    }
    public function store(Request $request){
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ];
        User::create($data);
        
        return redirect()->route('login')->with('success','Usuário Cadastrado com Sucesso!');
    }
    public function home(){
        $users = User::get();
        return view('home',['users' => $users]);
    }
}
