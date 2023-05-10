<?php

//Запускаем сессию
session_start();

//Устанавливаем кодировку и вывод всех ошибок
header('Content-Type: text/html; charset=UTF8');
error_reporting(E_ALL);


//Определяем переменную для переключателя
$url = isset($_GET['url']) ? $_GET['url'] : false;
$user = isset($_SESSION['user']) ? $_SESSION['user'] : false;

//Устанавливаем ключ защиты
define('KEY', true);

//Подключаем конфигурационный файл
require_once './config.php';
require_once './bd/bd.php';
require_once './func/function.php';


/** @var string $db */

try {

    run($db, $url);

} catch (Exception $e) {
    exit($e->getMessage());
    include_once 'views/404.php';
}