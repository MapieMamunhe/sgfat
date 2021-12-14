<?php
namespace App\Controllers;
use MF\Controller\Action;
class DashboardController extends Action{

    public function motorista(){
        $this->render('motorista', 'dashboardLayout');
    }
}