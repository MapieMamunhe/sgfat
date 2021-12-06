<?php

namespace app\model;
use app\core\Model;
class Usuario extends Model{
    private $telefone;
    private $senha;
    public function __construct($telefone, $senha)
    {
        $this->telefone = $telefone;
        $this->senha = $senha;
    }

    public function login(){
        $con = $this->iniciarConexao();
        $query = "select nome_perfil from usuario ".
                "join perfil on id_perfil = perfil_id "
                ."where telefone_usuario = :telefone and senha_usuario = :senha";

        $stmt = $con->prepare($query);
        $stmt ->bindValue(":telefone", $this->telefone);
        $stmt ->bindValue(":senha", $this->senha);

        $stmt->execute();
        $perfil = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        if((isset($perfil)) && count($perfil)==1){
            $perfil = $perfil[0];
            return $perfil;
        }else{
            
            return  array('nome_perfil'=>'invalido');
        }
        
       
    }

}



?>