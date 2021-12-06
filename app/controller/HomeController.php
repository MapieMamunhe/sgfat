<?php
namespace app\controller;
require_once("../../vendor/autoload.php");

class HomeController{
    public function loadView($viewName){
        include_once '../view/'.$viewName.'/index.php';
    }

}
$home = (new HomeController());