<?php

namespace app\controllers\admin;

use app\models\admin\Category;
use RedBeanPHP\R;
/** @property Category $model */
class CategoryController extends AppController
{
    public function indexAction()
    {
        $title = 'Категории';
        $this->setMeta("Adminka :: {$title}");
        $this->set(compact('title'));
    }

    public function deleteAction()
    {
        $id = get('id');
        $errors = '';
        $children = R::count('category','parent_id = ?',[$id]);
        $products = R::count('product','category_id = ?',[$id]);
        if ($children) {
            $errors .= 'Ошибка.В категории есть вложенные категории';
        }
        if ($products) {
            $errors .= 'Ошибка.В категории есть вложенные products';
        }
        if ($errors) {
            $_SESSION['errors'] = $errors;
        } else {
            R::exec("DELETE FROM category where id=?",[$id]);
            R::exec("DELETE FROM category_description where category_id=?",[$id]);
            $_SESSION['success']= 'Сатегория удалена';
        }
        redirect();
    }

    public function addAction()
    {
        if (!empty($_POST)) {

            if ($this->model->category_validate()) {
                if ($this->model->save_category()) {
                    $_SESSION['success']='categori9 dobalena';
                } else {
                    $_SESSION['errors']='error!';
                }
            }
            redirect();
        }
        $title = 'Добавление категории';
        $this->setMeta("Adminka :: {$title}");
        $this->set(compact('title'));
    }
}