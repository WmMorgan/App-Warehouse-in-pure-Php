<?php

session_start();

//Устанавливаем кодировку и вывод всех ошибок
header('Content-Type: text/html; charset=UTF8');
//error_reporting(E_ALL);


$url = isset($_GET['url']) ? $_GET['url'] : false;
$user = isset($_SESSION['user']) ? $_SESSION['user'] : false;

define('KEY', true);

//Подключаем конфигурационный файл
require_once './config.php';
require_once './bd/bd.php';
require_once './func/function.php';


/** @var string $db */

try {

    run(DB(), $url);

} catch (Exception $e) {
//    die($e->getMessage());
    include_once 'views/404.php';
}
