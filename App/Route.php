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
			'route' => '/dashboards/motorista',
			'controller' => 'dashboardController',
			'action' => 'motorista'
		);
		

		$this->setRoutes($routes);
	}

}

?>