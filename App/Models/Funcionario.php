<?php

namespace App\Models;

use MF\Model\Model;

class Funcionario extends Model {

	private $funcao;//nome da funcao do funcionario
	private $nome, $apelido;

	private $bairro, $cartaConducao, $categoriaCartaConducao,
	 $dataNascimento, $distrito, $formacaoAcademica,
	  $Funcao_idFuncao, $idFuncionario, $nivelAcademico,
	   $nuit, $numeroCasa, $numeroDocumento,
	    $provincia, $quarteirao, $sexo,
	   $telefone1;
	   
	private $senha;
	private $tipoDocumento;

	public function __get($atributo) {
		return $this->$atributo;
	}

	public function __set($atributo, $valor) {
		$this->$atributo = $valor;
	}

	//salvar
	public function salvar() {

		$query = "insert into Funcionarios(nome, telefone, senha)values(:nome, :telefone, :senha)";
		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':nome', $this->__get('nome'));
		$stmt->bindValue(':telefone', $this->__get('telefone'));
		$stmt->bindValue(':senha', $this->__get('senha')); //md5() -> hash 32 caracteres
		$stmt->execute();

		return $this;
	}
	public function salvarComSeusDados($dados) {

		$query = "insert into funcionario(nome,apelido, sexo,". 
				"dataNascimento, tipoDocumento, numeroDocumento, ".
				"nuit, Funcao_idFuncao, telefone1, cartaConducao, ". 
				"categoriaCartaConducao, nivelAcademico,formacaoAcademica, provincia, distrito, ". 
				"bairro, quarteirao, numeroCasa )values(:nome,:apelido, :sexo,". 
				":dataNascimento, :tipoDocumento, :numeroDocumento, ".
				":nuit, :Funcao_idFuncao, :telefone1, :cartaConducao, ". 
				":categoriaCartaConducao, :nivelAcademico, :formacaoAcademica, :provincia, :distrito, ". 
				":bairro, :quarteirao, :numeroCasa)";
		$stmt = $this->db->prepare($query);
		foreach ($dados as $key => $value) {
			$stmt->bindValue(':'.$key, $value);
		} 
		$stmt->execute();

		return $this;
	}

	//validar se um cadastro pode ser feito
	public function validarCadastro() {
		$valido = true;

		if(!empty($this->getFuncionarioPorNuit())){
            $valido = false;
        }
		if(!empty($this->getFuncionarioPorTelefone())){
			$valido = false;
		}
		if(!empty($this->getFuncionarioPorDocumento())){
			$valido = false;
		}
		if(isset($this->getFuncionarioPorCartaConducao()['cartaConducao'])){
			$valido = false;
		}
		if(strlen($this->__get('nome')) < 3) {
			$valido = false;
		}

		return $valido;
	}

	//recuperar um usuário por telefone
	public function getFuncionarioPorTelefone() {
		$query = "select nome, telefone1 from funcionario where telefone1 = :telefone";
		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':telefone', $this->__get('telefone1'));
		$stmt->execute();
		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}

	//Recupera funcionario por nuit
	public function getFuncionarioPorNuit() {
		$query = "select nome, telefone1 from funcionario where nuit = :nuit";
		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':nuit', $this->__get('nuit'));
		$stmt->execute();

		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}
	//Recuperar FUncionario por documento
	public function getFuncionarioPorDocumento() {
		$query = "select nome, telefone1 from funcionario 
		where tipoDocumento = :documento and numeroDocumento = :numeroDocumento";
		$stmt = $this->db->prepare($query);

		$stmt->bindValue(':documento', $this->__get('tipoDocumento'));
		$stmt->bindValue(':numeroDocumento', $this->__get('numeroDocumento'));
		
		$stmt->execute();
		return $stmt->fetch(\PDO::FETCH_ASSOC);
	}
//Recuperar FUncionario por Carta de conducao
	public function getFuncionarioPorCartaConducao() {
		$query = "select nome, telefone1, cartaConducao from funcionario 
		where cartaConducao = :cartaConducao";
		$stmt = $this->db->prepare($query);

		$stmt->bindValue(':cartaConducao', $this->__get('cartaConducao'));
		
		$stmt->execute();
		return $stmt->fetch(\PDO::FETCH_ASSOC);
	}

	public function autenticar() {

		$query = "select da.telefone1 as telefone,
			 da.senha as senha, fu.nome as funcao, 
			concat(f.nome, ' ' , f.apelido) as nome
			from dadosacesso da
			join funcionario f on f.telefone1 = da.telefone1
			join funcao fu on f.Funcao_idFuncao = fu.idFuncao
			where da.telefone1 = :telefone and da.senha = :senha";
		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':telefone', $this->__get('telefone1'));
		$stmt->bindValue(':senha', $this->__get('senha'));
		$stmt->execute();

		$Funcionario = $stmt->fetch(\PDO::FETCH_ASSOC);
		
		if($Funcionario['funcao'] != '' && $Funcionario['nome'] != '') {
			$this->__set('funcao', $Funcionario['funcao']);
			$this->__set('nome', $Funcionario['nome']);
			$this->__set('telefone1', $Funcionario['telefone']);
		}

		return $this;
	}
}

?>