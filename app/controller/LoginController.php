<?php
    namespace app\controller;
    require_once("../../vendor/autoload.php");
    use app\model\Usuario;

    //Sanitizar dados do formulario
    $dados = sanitizarDados();
    //Instanciar um novo usuario
    $usuario = new Usuario($dados[0], $dados[1]);

    //Fazer login para pegar o perfil
    $perfil = $usuario->login();

    //Incluir o homecontroller para saber para onde cada utilizador vai(incluindo um invalido)
    include_once ("HomeController.php");
     
    
    if(($perfil['nome_perfil']!="invalido")){//Se for um utilizador valido
        session_start();
        $_SESSION["perfil"] = $perfil["nome_perfil"];
        $home->loadView($perfil['nome_perfil']);//Ler a view do utilizador em questao
    }else{
        //Se por acaso nao tiver inserido dados validos
        include_once '../view/invalido/login-invalido.html';
    }
    

    function sanitizarDados(){
        foreach ($_POST as $valor) {
            $dados[]= (htmlspecialchars($valor));
        }
        return $dados;
    }
