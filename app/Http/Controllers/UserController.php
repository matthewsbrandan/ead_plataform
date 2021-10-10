<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

use App\Services\SenderService;

use App\Models\PasswordReset;
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
    public function changeType($type){
        auth()->user()->update(['type' => $type]);
        return redirect()->back()->with('message','Perfil atualizado com sucesso');
    }
    public function update(Request $request){
        $data = [
            'name' => $request->name
        ];

        if($request->file('thumbnail')){
            $path = "uploads/profile/";
            ['names' => $names,'errors' => $errors] = $this->uploadImages([$request->file('thumbnail')],$path);
    
            if(count($errors) > 0 || count($names) == 0) return redirect()->back()->with(
                'message', 'Houve um erro ao fazer o upload da imagem'
            );
    
            $thumbnail = $names[0];
            $data+= ['thumbnail' => $thumbnail];
        }

        auth()->user()->update($data);
        return redirect()->back()->with('message','Perfil atualizado com sucesso!');
    }
    public function changePassword(Request $request){
        if (Hash::check($request->password, auth()->user()->password)) {
            $data = ['password' => bcrypt($request->new_password)];
            auth()->user()->update($data);
            return redirect()->back()->with('message','Senha alterada com sucesso!');
        }
        return redirect()->back()->with('invalid-password','Senha inválida!');
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
        if(!User::whereEmail($request->email)->first()) return redirect()->back()
            ->with('message','Não existe nenhuma conta com este Email.');

        $reset = PasswordReset::whereEmail($request->email)->first();
        if($reset){
            $now = \Carbon\Carbon::now();
            $diff = $reset->created_at->diffInMinutes($now);
            $message_time = $diff < 1 ? "": ($diff == 1 ? " à 1 minuto": " à $diff minutos");
            if($diff < 5) return redirect()->back()->with(
                "message",
                "Já foi solicitada um redefinição de senha$message_time, verifique seu email.<br/>Caso não chegue aguarde mais alguns minutos e tente novamente."
            );
            else PasswordReset::whereEmail($request->email)->delete();
        }

        $token = Str::random(8);
        PasswordReset::create([
            'email' => $request->email,
            'token' => $token
        ]);

        $sender = new SenderService();
        $response = $sender->send("send/forgot-password",[
            'to_address' => $request->email,
            'link' => route('redefine_password',[
                'email' => $request->email,
                'token' => $token
            ])
        ]);

        if(isset($response['result']) && $response['result']) return redirect()->back()->with(
            'message',
            'Solicitação de redefinição enviada com sucesso, verifique sua caixa de email e acesso o link que te enviamos'
        );
    }
    public function redefinePassword($email, $token){
        if(!$pass = PasswordReset::with('user')
            ->whereEmail($email)
            ->whereToken($token)
            ->first()
        ) return redirect()->route('forgot_password')->with(
            'message',
            'Token ou email, inválidos, tente enviar novamente.'
        );
        
        return view('auth.redefine_password',[
            'name' => explode(' ',$pass->user->name)[0],
            'email' => $email,
            'token' => $token
        ]);

    }
    public function storePassword(Request $request){
        if(!PasswordReset::whereEmail($request->email)->first()) return redirect()->back()->with(
            'message',
            'Não há nenhuma solicitação de redefinição de senha para este email!'
        );
        if(!$pass = PasswordReset::with('user')
            ->whereEmail($request->email)
            ->whereToken($request->token)
            ->first()
        ) return redirect()->back()->with(
            'message',
            'Token de redefinição de senha inválido'
        );
        $pass->user->update(["password" => bcrypt($request->password)]);

        Auth::login($pass->user);

        PasswordReset::whereEmail($request->email)
            ->whereToken($request->token)
            ->delete();
            
        return redirect()->route('home')->with('message','Senha alterada com sucesso!');
    }
    // END:: FORGOT PASSWORD
}