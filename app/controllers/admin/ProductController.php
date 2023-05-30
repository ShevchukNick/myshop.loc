<?php

namespace app\controllers\admin;

use app\models\admin\Product;
use RedBeanPHP\R;
use wfm\App;
use wfm\Pagination;


/** @property Product $model */
class ProductController extends AppController
{
    public function indexAction()
    {
        $lang = App::$app->getProperty('language');
        $page = get('page');
        $perpage = 6;
        $total= R::count('product');
        $pagination = new Pagination($page,$perpage,$total);
        $start = $pagination->getStart();

        $products = $this->model->get_products($lang,$start,$perpage);
        $title = 'Список товаров';
        $this->setMeta("Adminka :: {$title}");
        $this->set(compact('title','products','pagination','total'));
    }

    public function addAction()
    {
        if (!empty($_POST)) {
            if ($this->model->product_validate()){
                if ($this->model->save_product()) {
                    $_SESSION['success']= 'товар добавлен';
                } else {
                    $_SESSION['errors'] = 'error add tovara';
                }

            }
            redirect();
        }

        $title = 'Новый товар';
        $this->setMeta("Adminka :: {$title}");
        $this->set(compact('title'));
    }

    public function getDownloadAction()
    {
        $q = get('q', 's');
        $downloads = $this->model->get_downloads($q);
        echo json_encode($downloads);
        die;

    }
}