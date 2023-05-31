<?php

namespace app\controllers\admin;

use wfm\App;
use wfm\Cache;

class CacheController extends AppController
{
    public function indexAction()
    {
        $title = 'упраление кэшем';
        $this->setMeta("Админка :: {$title}");
        $this->set(compact('title'));
    }

    public function deleteAction()
    {
        $langs=App::$app->getProperty('languages');
        $cache_key=get('cache','s');
        $cache= Cache::getInstance();
        if ($cache_key=='category') {
            foreach ($langs as $lang=>$item) {
                $cache->delete("myshop_menu_{$lang}");
            }
        }
         if ($cache_key=='page') {
                    foreach ($langs as $lang=>$item) {
                        $cache->delete("myshop_page_menu_{$lang}");
                    }
                }
         $_SESSION['success']='выбранынй кэш удален';
         redirect();

    }
}