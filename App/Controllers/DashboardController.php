<?php
namespace App\Controllers;
use MF\Controller\Action;
class DashboardController extends Action{

    public function motorista(){
        $this->render('motorista', 'dashboardLayout');
    }
    public function secretaria(){
        $this->render('secretaria', 'dashboardLayout');
    }
    public function gestor(){
        $this->render('gestor', 'dashboardLayout');
    }
    public function cobrador(){
        $this->render('cobrador', 'dashboardLayout');
    }
    public function fiscal(){
        $this->render('fiscal', 'dashboardLayout');
    }
}