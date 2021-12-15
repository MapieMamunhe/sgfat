<?php

namespace App;

use MF\Init\Bootstrap;

class Route extends Bootstrap {

	protected function initRoutes() {

		/*$routes['home'] = array(
			'route' => '/',
			'controller' => 'indexController',
			'action' => 'index'
		);*/
		$routes['login'] = array(
			'route' => '/',
			'controller' => 'indexController',
			'action' => 'login'
		);
		$routes['dashboardMotorista'] = array(
			'route' => '/dashboard/motorista',
			'controller' => 'dashboardController',
			'action' => 'motorista'
		);
		$routes['dashboardCobrador'] = array(
			'route' => '/dashboard/cobrador',
			'controller' => 'dashboardController',
			'action' => 'cobrador'
		);

		
		$routes['dashboardGestor'] = array(
			'route' => '/dashboard/gestor',
			'controller' => 'dashboardController',
			'action' => 'gestor'
		);
		//Registar FUncionario
		$routes['pesquisarFuncionario'] = array(
			'route' => '/pesquisarFuncionario',
			'controller' => 'registarController',
			'action' => 'pesquisarFuncionario'
		);
		$routes['pegaFuncionario'] = array(
			'route' => '/pegaFuncionario',
			'controller' => 'registarController',
			'action' => 'pegarFuncionarioPorDocumento'
		);
		$routes['formRegisto'] = array(
			'route' => '/formRegistoFuncionario',
			'controller' => 'registarController',
			'action' => 'formRegistoFuncionario'
		);
		$routes['dashboardSecretaria'] = array(
			'route' => '/dashboard/secretaria',
			'controller' => 'dashboardController',
			'action' => 'secretaria'
		);
		$routes['dashboardFiscal'] = array(
			'route' => '/dashboard/fiscal',
			'controller' => 'dashboardController',
			'action' => 'fiscal'
		);
		$routes['autenticar'] = array(
			'route' => '/autenticar',
			'controller' => 'AuthController',
			'action' => 'autenticar'
		);

		$this->setRoutes($routes);
	}

}

?>