<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Fornecedor;

class FornecedorController extends Controller
{
    public function index(){
        return view('app.fornecedor.index');
    }

    public function listar(Request $request){
        
        $fornecedores = Fornecedor::with(['produtos'])->where('nome', 'like', '%'.$request->input('nome').'%')
        ->where('site', 'like', '%'.$request->input('site').'%')
        ->where('uf', 'like', '%'.$request->input('uf').'%')
        ->where('email', 'like', '%'.$request->input('email').'%')
        ->paginate(6);
        
        return view('app.fornecedor.listar', ['fornecedores' => $fornecedores, 'request' => $request->all() ]);
    }

    public function adicionar(Request $request){

        $msg = '';
        
        if($request->input('_token') != '' && $request->input('id') == ''){
            //Validações do Formulário da rota app/fornecedor/adicionar
            $regras = [
                'nome' => 'required|min:3|max:40',
                'site' => 'required',
                'uf' => 'required|min:2|max:2',
                'email' => 'email'
            ];
            $feedback = [
                'required' => 'O campo :attribute deve ser preechido.',
                'nome.min' => 'O campo nome deve ter no minimo 3 caracteres.',
                'nome.max' => 'O campo nome deve ter no maximo 40 caracteres.',
                'uf.min' => 'O campo uf deve ter no maximo 2 caracteres.',     
                'uf.max' => 'O campo uf deve ter no maximo 2 caracteres.',
                'email.email' => 'O campo e-mail não foi preenchido corretamente.'      
            ];
            $request->validate($regras, $feedback);
            
            $fornecedor = new Fornecedor();
            $fornecedor->create($request->all());

            $msg = 'Cadastro realizado com sucesso!';

        }
        //EDIÇÃO
        if($request->input('_token') != '' && $request->input('id') != ''){
            $fornecedor = Fornecedor::find($request->input('id'));
            $update = $fornecedor->update($request->all());

            if($update){
                $msg = 'Update realizado com sucesso';
            }else{
                $msg = 'Update teve falha';
            }

            return redirect()->route('app.fornecedor.editar', ['id' => $request->input('id'),'msg' => $msg]);
        }

        return view('app.fornecedor.adicionar', ['msg' => $msg]);
    }

    public function editar($id, $msg = ''){
        $fornecedor = Fornecedor::find($id);
        return view('app.fornecedor.adicionar', ['fornecedor' => $fornecedor, 'msg' => $msg]);
    }

    public function excluir($id, $msg = ''){
        Fornecedor::find($id)->delete();

        $msg = 'Registro deletado com sucesso';
        return view('app.fornecedor.adicionar', ['msg' => $msg]);
    }

}
