<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AlunoController extends Controller{
    public function index(){//Carregar o index
        $data = array();
        return view('aluno/index', $data);      
    }
    
    public function cadastrar(Request $request){//Função cadastrar novo aluno
        $data = array();
        $data["lista"] = \App\Curso::all();
        if($request->isMethod("POST")){
            try{             
                $matricula = $request->input("matricula");
                $nome = $request->input("nome");
                $telefone = $request->input("telefone");
                $sexo = $request->input("sexo");
                $email = $request->input("email");
                $endereco = $request->input("endereco");
                $bairro = $request->input("bairro");
                $cep = $request->input("cep");
                $cidade = $request->input("cidade");
                $estado = $request->input("estado");
                $idcurso = $request->input("idcurso");
                $datanasc = $request->input("datanasc");
                $estadocivil = $request->input("estadocivil");
                $nacionalidade = $request->input("nacionalidade");
                
                $file = $request->file("foto");
                $ext = $file->getClientOriginalExtension();
                $size = $file->getSize();
                
               
                    
                    $curso = \App\Curso::find($idcurso);

                    $a = new \App\Aluno();
                    $e = new \App\Endereco();
                    
                    $a->matricula = $matricula;
                    $a->nome = $nome;
                    $a->telefone = $telefone;
                    $a->sexo = $sexo;
                    $a->email = $email;
                    $a->foto = $fileName;
                    $a->datanasc = $datanasc;
                    $a->estadocivil = $estadocivil;
                    $a->nacionalidade = $nacionalidade;
                    
                    $a->curso()->associate($curso);

                    $e->endereco = $endereco;
                    $e->bairro = $bairro;
                    $e->cidade = $cidade;
                    $e->cep = $cep;
                    $e->estado = $estado;
                    
                    $a->save();
                    
                    $e->aluno()->associate($a);
                    
                    $e->save();
                    
                    $file->move("fotos", $fileName);
                    
                    $data["resp"] = "<div class='alert alert-success'>"
                            . $nome . ", cadastrado com sucesso!</div>";
                }
            } catch (Exception $ex) {
                $data["resp"] = "<div class='alert alert-danger'>"
                        . "Dados não enviados!</div>";
                }
        }
        return view('aluno/cadastrar', $data);
    }
    
    public function buscar(Request $request){//Função buscar aluno
        $data = array();
        $aDao = new \App\Repository\AlunoDao(new \App\Aluno);
        if($request->isMethod("POST")){
            $nome = $request->input("nome");
            $data["lista"] = $aDao->buscar($nome);
        }else{
            $data["lista"] = $aDao->listar();
        }
        return view('aluno/buscar', $data);
    }
    
    public function  detalhes($id, Request $request){//Função editar o aluno
        $data = array();
        $data["lista"] = \App\Curso::all();
        try{
            $alu = \App\Aluno::find($id);
            if($request->isMethod("POST")){
               
                $nome = $request->input("nome", "");
                $telefone = $request->input("telefone", "");
                $email = $request->input("email", "");
                $endereco = $request->input("endereco", "");
                $bairro = $request->input("bairro", "");
                $cep = $request->input("cep", "");
                $cidade = $request->input("cidade", "");
                $estado = $request->input("estado", "");
                $idcurso = $request->input("idcurso", "");
                
              
    
    public function excluir($idaluno){//Função excluir aluno
        $data = array();
        $alu = \App\Aluno::find($idaluno);
        if($alu == null){
            $data["resp"] = "<div class='alert alert-danger'>"
                    . "Aluno não encontrado</div>";
        }else{
            $alu->endereco()->delete();
            $alu->delete();
            
            $data["resp"] = "<div class='alert alert-success'>"
                    . "Aluno excluído com sucesso</div>";
        }       
        return view("aluno/buscar", $data);
    }
}
