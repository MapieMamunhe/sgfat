<?php
namespace App\Controllers;

use App\Models\Funcionario;
use MF\Controller\Action;
use MF\Model\Container;

class RegistarController extends Action{
    public function pesquisarFuncionario(){
        session_start();
        $this->isLogged();
        $this->render('pesquisarFuncionario', 'navegacaoLayout');
    }
    public function pegarFuncionarioPorDocumento(){
        session_start();
        $this->isLogged();
        $funcionario = Container::getModel('Funcionario');
        $documento = $_POST['documento'];
        $numeroDocumento = $_POST['numero'];
        $funcionario ->__set('tipoDocumento',$documento);
        $funcionario ->__set('numeroDocumento',$numeroDocumento);
        $dados = $funcionario->getFuncionarioPorDocumento();

       
        if(!empty($dados)){
            header('location: /pesquisarFuncionario?existeFuncionario=true');
        }else{
            header('location: /formRegistoFuncionario');
        }
    }
    public function formRegistoFuncionario(){
        session_start();
        $this->isLogged();
        $this->render('formRegistoFuncionario', 'registoLayout');
    }
    public function continuarRegisto(){
        session_start();
        $this->isLogged();
        $dados=$_POST;
        foreach($dados as $k=>$v){
            $dados[$k] = htmlspecialchars($v);
        }
        $this->view->dados_funcionario = $dados;
        $this->render('confirmarDados', 'navegacaoLayout');
    }
    public function registarFuncionario(){
        session_start();
        $this->isLogged();
        
        $dados = unserialize($_POST['dados']);
        $funcionario = Container::getModel('Funcionario');
        //Sanitizando os dados
        date("Y-m-d", strtotime($dados['dataNascimento']));
        foreach($dados as $k=>$v){
            $dados[$k] = htmlspecialchars($v);
            $funcionario->__set($k, $v);
        }
        
        if($dados['Funcao_idFuncao']==4){//motorista
            if(empty($dados['cartaConducao'])){
                $this->view->mensagem="O numero de carta de conducao <br /> &eacute; obrigatoria para motoristas";
                $this->render('erroCadastrar');
            }
        } else if(!$funcionario->validarCadastro()){
            $this->view->mensagem="Um ou mais dados de cadastro invalidos";
            $this->render('erroCadastrar');
        }else{
            $funcionario->salvarComSeusDados($dados);
            $this->render('registado');
        }
       
    }
}