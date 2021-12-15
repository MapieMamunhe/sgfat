<?php

namespace App\Models;

use MF\Model\Model;

class Funcionario extends Model {

	private $funcao;
	private $nome;
	private $telefone;
	private $senha;
	private $documento;
	private $numeroDocumento;

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

	//validar se um cadastro pode ser feito
	public function validarCadastro() {
		$valido = true;

		if(strlen($this->__get('nome')) < 3) {
			$valido = false;
		}

		if(strlen($this->__get('telefone')) < 3) {
			$valido = false;
		}

		if(strlen($this->__get('senha')) < 3) {
			$valido = false;
		}


		return $valido;
	}

	//recuperar um usuário por telefone
	public function getFuncionarioPorTelefone() {
		$query = "select nome, telefone1 from funcionario where telefone1 = :telefone";
		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':telefone', $this->__get('telefone'));
		$stmt->execute();

		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}
	//Recuperar FUncionario por documento
	public function getFuncionarioPorDocumento() {
		$query = "select nome, telefone1 from funcionario 
		where tipoDocumento = :documento and numeroDocumento = :numeroDocumento";
		$stmt = $this->db->prepare($query);

		$stmt->bindValue(':documento', $this->__get('documento'));
		$stmt->bindValue(':numeroDocumento', $this->__get('numeroDocumento'));
		
		$stmt->execute();
		return $stmt->fetch(\PDO::FETCH_ASSOC);
	}


	public function autenticar() {

		$query = "select da.telefone1 as telefone, da.senha as senha, fu.nome as funcao, 
			f.nome + ' ' + f.apelido as nome
			from dadosacesso da
			join funcionario f on f.telefone1 = da.telefone1
			join funcao fu on f.Funcao_idFuncao = fu.idFuncao
			where da.telefone1 = :telefone and da.senha = :senha";
		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':telefone', $this->__get('telefone'));
		$stmt->bindValue(':senha', $this->__get('senha'));
		$stmt->execute();

		$Funcionario = $stmt->fetch(\PDO::FETCH_ASSOC);
		echo '<pre>';
			print_r($Funcionario);
		echo '</pre>';
		if($Funcionario['funcao'] != '' && $Funcionario['nome'] != '') {
			$this->__set('funcao', $Funcionario['funcao']);
			$this->__set('nome', $Funcionario['nome']);
			$this->__set('telefone', $Funcionario['telefone']);
		}

		return $this;
	}
}

?>