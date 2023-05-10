<?php
 /**
 * Конфигурационный файл
 * @author C_Morgan
 * Регистрация пользователя письмом
 */


 //Ключ защиты
 if(!defined('KEY'))
 {
     header("HTTP/1.1 404 Not Found");
     exit(file_get_contents('./404.html'));
 }

 //Адрес базы данных
 define('DBSERVER','mysql');

 //Логин БД
 define('DBUSER','sklad-na-php');

 //Пароль БД
 define('DBPASSWORD','secret');

 //БД
 define('DATABASE','sklad-na-php');

 //Префикс БД
 define('DBPREFIX','cm_');

 //Errors
 define('ERROR_CONNECT','Немогу соеденится с БД');

 //Errors
 define('NO_DB_SELECT','Данная БД отсутствует на сервере');

 //Адрес хоста сайта
 define('HOST','http://'. $_SERVER['HTTP_HOST']);
 
 //Адрес почты от кого отправляем
 define('MAIL_AUTOR','Регистрация на '.HOST.' <no-reply@'.HOST.'>');

 define('DIR', __DIR__);
 define('FILES', '/files');