<?php
namespace app\controllers;
use wfm\Controller;

class MainController extends Controller
{
    public function indexAction()
    {
        $this->setMeta('glavnaya stranica','opisanie','keywords');
//        $this->set(['test'=>'TEST']);
    }
}