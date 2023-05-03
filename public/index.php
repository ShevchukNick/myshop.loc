<?php

if (PHP_MAJOR_VERSION < 8) {
    die('Необходима версия ПХП >= 8');
}


require_once dirname(__DIR__) . '/config/init.php';

new \wfm\App();
//throw new Exception('Возникла ошибка',404);
//var_dump(\wfm\App::$app->getProperties());