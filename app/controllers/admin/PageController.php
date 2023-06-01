<?php

namespace app\controllers\admin;

use app\models\admin\Page;
use RedBeanPHP\R;
use wfm\App;
use wfm\Pagination;

/** @property Page $model */
class PageController extends AppController
{
    public function indexAction()
    {
        $lang = App::$app->getProperty('language');
        $page = get('page');
        $perpage = 5;
        $total = R::count('page');
        $pagination = new Pagination($page, $perpage, $total);
        $start = $pagination->getStart();

        $pages = $this->model->get_pages($lang, $start, $perpage);
        $title = 'list of pages';
        $this->setMeta("Админка :: {$title}");
        $this->set(compact('title', 'pages', 'pagination', 'total'));

    }

    public function deleteAction()
    {
        $id = get('id');
        if ($this->model->deletePage($id)) {
            $_SESSION['success'] = 'Страница удалена';
        } else {
            $_SESSION['errors'] = 'Ошибка удаления страницы';
        }
        redirect();
    }

    public function addAction()
    {
        if (!empty($_POST)) {
            if ($this->model->page_validate()) {
                if ($this->model->save_page()) {
                    $_SESSION['success'] = 'Страница добавлена';
                } else {
                    $_SESSION['errors'] = 'Ошибка добавления страницы';
                }
            }
            redirect();
        }

        $title = 'Новая страница';
        $this->setMeta("Админка :: {$title}");
        $this->set(compact('title'));
    }

    public function editAction()
    {
        $id=get('id');
        if (!empty($_POST)) {
            if ($this->model->page_validate()) {
                if ($this->model->update_page($id)) {
                    $_SESSION['success'] = 'Страница save';
                } else {
                    $_SESSION['errors'] = 'Ошибка update страницы';
                }
            }
                redirect();
        }

        $page=$this->model->get_page($id);
        if (!$page) {
            throw new \Exception('notfound page');
        }
        $title = 'edit страница';
        $this->setMeta("Админка :: {$title}");
        $this->set(compact('title','page'));

    }


}