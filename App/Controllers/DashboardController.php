<?php
namespace App\Controllers;
use MF\Controller\Action;
use MF\Model\Container;
use MF\Model\Model;
class DashboardController extends Action{

    public function motorista(){
        session_start();
        $this->isLogged();
        
        $this->render('motorista', 'dashboardLayout');
    }
    public function secretaria(){
        session_start();
        $this->isLogged();
        $this->render('secretaria', 'dashboardLayout');
    }
    public function gestor(){
        session_start();
        $this->isLogged();
        $this->render('gestor', 'dashboardLayout');
    }
    public function cobrador(){
        session_start();
        $this->isLogged();
        $this->render('cobrador', 'dashboardLayout');
    }
    public function fiscal(){
        session_start();
        $this->isLogged();
        $this->render('fiscal', 'dashboardLayout');
    }
    
}