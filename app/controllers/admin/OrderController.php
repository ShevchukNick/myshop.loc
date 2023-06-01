<?php

namespace app\controllers\admin;

use app\models\admin\Order;
use RedBeanPHP\R;
use wfm\Pagination;

/** @property Order $model */
class OrderController extends AppController
{
    public function indexAction()
    {
        $status = get('status');
        $status = ($status == 'new') ? ' status = 0 ' : '';

        $page=get('page');
        $perpage=5;
        $total=R::count('orders',$status);
        $pagination=new Pagination($page,$perpage,$total);
        $start = $pagination->getStart();


        $orders = $this->model->get_orders($start,$perpage,$status);

        $title = 'list orders';
        $this->setMeta("Админка :: {$title}");
        $this->set(compact('title','orders','pagination','total'));
    }

    public function editAction()
    {
        $id = get('id');
        if (isset($_GET['status'])) {
            $status=get('status');
            if ($this->model->change_status($id,$status)) {
                $_SESSION['success']='status izmenen';
            } else {
                $_SESSION['errors']='error status izmenen';

            }
        }
        $order=$this->model->get_order($id);
        if (!$order) {
            throw new \Exception('not found order',404);
        }
        $title = "zakaz nomer: {$id}";
        $this->setMeta("Админка :: {$title}");
        $this->set(compact('title','order'));
    }
}