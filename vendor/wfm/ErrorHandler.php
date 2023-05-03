<?php

namespace wfm;

class ErrorHandler
{
    public function __construct()
    {
        if (DEBUG) {
            error_reporting(-1);
        } else {
            error_reporting(0);
        }
        set_exception_handler([$this, 'exeptionHandler']);
        set_error_handler([$this, 'errorHandler']);
        ob_start();
        register_shutdown_function([$this,'fatalErrorHandler']);
    }

    public function errorHandler($errno,$errstr,$errfile,$errline)
    {
        $this->logErrors($errstr,$errfile,$errline);
        $this->displayErrors($errno,$errstr,$errfile,$errline);
    }

    public function fatalErrorHandler()
    {
        $error = error_get_last();
        if (!empty($error) && $error['type'] & (E_ERROR | E_PARSE | E_COMPILE_ERROR | E_CORE_ERROR)) {
            $this->logErrors($error['message'], $error['file'], $error['line']);
            ob_end_clean();
            $this->displayErrors($error['type'],$error['message'], $error['file'], $error['line']);
        } else {
            ob_end_flush();
        }
    }

    public function exeptionHandler(\Throwable $e)
    {
        $this->logErrors($e->getMessage(),$e->getFile(),$e->getLine());
        $this->displayErrors('Исключение',$e->getMessage(),$e->getFile(),$e->getLine(),$e->getCode());
    }

    protected function logErrors($message = '', $file = '', $line = '')
    {
        file_put_contents(LOGS . '/errors.log',"[" . date('Y-m-d H:i:s') . "] Текст ошибки: {$message} | Файл: {$file} | Строка: {$line} \n================\n",FILE_APPEND);
    }

    protected function displayErrors($errno,$errstr,$errfile,$errline,$responce=500)
    {
        if ($responce==0) {
            $responce = 404;
        }
        http_response_code($responce);
        if ($responce==404 && !DEBUG) {
            require_once WWW . '/errors/404.php';
            die();
        }
        if (DEBUG) {
            require_once WWW . '/errors/development.php';
        } else {
            require_once WWW . '/errors/production.php';
        }
        die();
    }
}