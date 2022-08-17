<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class LoginController extends Controller
{
    public function index(Request $request){

        $erro = '';
        if($request->get('erro') == 1){
            $erro = 'O usuário ou senha são inválidos';     
        }

        if($request->get('erro') == 2){
            $erro = 'Necessário realizar login para acessar a pagina';     
        }
        return view('site.login', ['titulo' => 'Login', 'erro' => $erro]);
    }

    public function autenticar(Request $request){
        
        //REGRA DE VALIDAÇÃO
        $regras = [
            'usuario' => 'email',
            'senha' => 'required'
        ];

        //MENSAGENS DE FEEDBACK
        $feedback = [
            'usuario.email' => 'O campo usuário (e-mail) é obrigatorio.',
            'senha.required' => 'O campo senha deve ser informado'
        ];

        $request->validate($regras, $feedback);

        //PARAMETROS DE LOGIN
        $email = $request->get('usuario');
        $password = $request->get('senha');

        //echo "Usuário: $email | Senha: $password";
        //echo '<pre>';
        //print_r($request->all());

        //INICIAR MODEL USER
        $user = new User();

        $usuario = $user->where('email', $email)
                        ->where('password', $password)
                        ->get()
                        ->first();

        if(isset($usuario->name)){
            session_start();
            $_SESSION['nome'] = $usuario->name;
            $_SESSION['email'] = $usuario->email;            
            
            return redirect()->route('app.home');

        }else{
            return redirect()->route('site.login', ['erro' => 1]);
        }
    }

    public function sair(){
        session_destroy();
        return redirect()->route('site.login');

    }

}
