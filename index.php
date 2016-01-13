<?php
echo 'qqq'; die();
// FRONT CONTROLLER
// Общие настройки
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
// Подключение файлов системы

define('ROOT', dirname(__FILE__));
require_once(ROOT . '/components/Autoload.php');

// Вызов Router !!!!!!!!!!!!!!!!!
// Cделал коммит 13.01.2016!!!
// еще коммит
// в ветке мастер 2 произошло изменение!
$router = new Router();
$router->run();
