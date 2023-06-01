<?php

namespace app\controllers\admin;
use app\models\admin\Slider;

/** @property Slider $model */
class SliderController extends AppController
{
    public function indexAction()
    {
        if ($_SERVER['REQUEST_METHOD']=='POST') {
            $this->model->update_slider();
            $_SESSION['success']='uspex';
            redirect();
        }
        $gallery=$this->model->get_slides();
        $title = 'manage slider';
        $this->setMeta("Adminka :: {$title}");
        $this->set(compact('title','gallery'));
    }

}