<?php

 //Ключ защиты
 if(!defined('KEY'))
 {
     header("HTTP/1.1 404 Not Found");
     include_once __DIR__.'/../views/404.php';
     exit;
 }

//Подключение к базе данных mySQL с помощью PDO
try {
    $db = new PDO('mysql:host='.DBSERVER.';dbname='.DATABASE, DBUSER, DBPASSWORD, array(
    	PDO::ATTR_PERSISTENT => true
    	));
    $db->exec("set names utf8");

} catch (PDOException $e) {
    print "Ошибка соединеия!: " . $e->getMessage() . "<br/>";
    die();
}

