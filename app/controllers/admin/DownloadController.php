<?php


namespace app\controllers\admin;


use app\models\admin\Download;
use RedBeanPHP\R;
use wfm\App;
use wfm\Pagination;

/** @property Download $model */
class DownloadController extends AppController
{

    public function indexAction()
    {
        $lang = App::$app->getProperty('language');
        $page = get('page');
        $perpage = 20;
        $total = R::count('download');
        $pagination = new Pagination($page, $perpage, $total);
        $start = $pagination->getStart();

        $downloads = $this->model->get_downloads($lang, $start, $perpage);
        $title = 'Файлы (цифровые товары)';
        $this->setMeta("Админка :: {$title}");
        $this->set(compact('title', 'downloads', 'pagination', 'total'));
    }

    public function addAction()
    {
        if (!empty($_POST)) {
            if ($this->model->download_validate()) {
                if ($data = $this->model->upload_file()) {
                    if ($this->model->save_download()) {
                        $_SESSION['success'] = 'file add';
                    } else {
                        $_SESSION['errors'] = 'error add file';
                    }
                } else {
                    $_SESSION['errors'] = 'error move file';
                }
            }
            redirect();
        }

        $title = 'add Файлa (цифровые товары)';
        $this->setMeta("Админка :: {$title}");
        $this->set(compact('title'));
    }

     public function deleteAction()
     {
         $id = get('id');
         if (R::count('order_download','download_id=?',[$id])) {
             $_SESSION['errors']='ne udalitb';
             redirect();
         }
         if (R::count('product_download','download_id=?',[$id])) {
             $_SESSION['errors']='ne udalitb';
             redirect();
         }

         if ($this->model->download_delete($id)) {
             $_SESSION['success']='file delete';
         } else {
             $_SESSION['errors']='eroror ne udalitb';
         }
         redirect();

     }

}