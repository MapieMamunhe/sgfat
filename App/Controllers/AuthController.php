<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class AuthController extends Action {


	public function autenticar() {
		
		$funcionario = Container::getModel('Funcionario');
		
		$funcionario->__set('telefone', $_POST['telefone']);
		$funcionario->__set('senha', $_POST['senha']);
		
		$funcionario->autenticar();

		if($funcionario->__get('funcao') != '' && $funcionario->__get('nome')!='') {
			
			session_start();

			$_SESSION['funcao'] = $funcionario->__get('funcao');
			$_SESSION['nome'] = $funcionario->__get('nome');

			header('Location: /dashboard/'.$_SESSION['funcao']);

		} else {
			header('Location: /?login=erro');
		}

	}

	public function sair() {
		session_start();
		session_destroy();
		header('Location: /');
	}
}