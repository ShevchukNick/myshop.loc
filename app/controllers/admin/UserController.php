<?php


namespace app\controllers\admin;

use app\models\admin\User;
use RedBeanPHP\R;
use wfm\Pagination;

/** @property User $model */
class UserController extends AppController
{

    public function indexAction()
    {
        $page=get('page');
        $perpage=20;
        $total=R::count('user');
        $pagination=new Pagination($page,$perpage,$total);
        $start=$pagination->getStart();

        $users=$this->model->get_users($start,$perpage);
        $title = 'list of users';
        $this->setMeta("Админка :: {$title}");
        $this->set(compact('title','users','pagination','total'));
    }

    public function loginAdminAction()
    {
        if ($this->model::isAdmin()) {
            redirect(ADMIN);
        }

        $this->layout = 'login';
        if (!empty($_POST)) {
            if ($this->model->login(true)) {
                $_SESSION['success'] = 'Вы успешно авторизованы';
            } else {
                $_SESSION['errors'] = 'Логин/пароль введены неверно';
            }
            if ($this->model::isAdmin()) {
                redirect(ADMIN);
            } else {
                redirect();
            }
        }

    }

    public function logoutAction()
    {
        if ($this->model::isAdmin()) {
            unset($_SESSION['user']);
        }
        redirect(ADMIN . '/user/login-admin');
    }

}