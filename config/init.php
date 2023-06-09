<?php
define("DEBUG",1);
define("ROOT",dirname(__DIR__));
define("WWW",ROOT . '/public');
define('APP', ROOT . '/app');
define('CORE', ROOT . '/vendor/wfm');
define('HELPERS', ROOT . '/vendor/wfm/helpers');
define('CACHE', ROOT . '/tmp/cache');
define('LOGS', ROOT . '/tmp/logs');
define('CONFIG', ROOT . '/config');
define('LAYOUT', 'myshop');
define("PATH", 'http://myshop.loc');
define('ADMIN', 'http://myshop.loc/admin');
define('NO_IMAGE', '/public/uploads/no_image.jpg');

require_once ROOT . '/vendor/autoload.php';