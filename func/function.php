<?php
/**
 * Файл с пользовательскими функциями
 * @author C_Morgan
 * Регистрация пользователя письмом
 */

spl_autoload_register(function ($class) {
    $path = str_replace('\\', '/', $class . '.php');
    if (file_exists($path)) {
        require_once $path;
    }
});

/**
 * @param $to
 * @param $from
 * @param $title
 * @param $message
 * @return bool|string
 */
function sendMessageMail($to, $from, $title, $message)
{

    //Формируем заголовок письма
    $subject = $title;
    $subject = '=?utf-8?b?' . base64_encode($subject) . '?=';

    //Формируем заголовки для почтового сервера
    $headers = "Content-type: text/html; charset=\"utf-8\"\r\n";
    $headers .= "From: " . $from . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Date: " . date('D, d M Y h:i:s O') . "\r\n";

    //Отправляем данные на ящик админа сайта
    if (!mail($to, $subject, $message, $headers))
        return 'Ошибка отправки письма!';
    else
        return true;
}

/**
 * @param $data
 * @return string
 */
function showErrorMessage($data)
{
    $err = '<ul id="errors">' . "\n";

    if (is_array($data)) {
        foreach ($data as $val)
            $err .= '<li style="color:red;">' . $val . '</li>' . "\n";
    } else
        $err .= '<li style="color:red;">' . $data . '</li>' . "\n";

    $err .= '</ul>' . "\n";

    return $err;
}


/**
 * @return false|string
 */
function salt()
{
    $salt = substr(md5(uniqid()), -8);
    return $salt;
}

/**
 * @param $email
 * @return bool
 */
function emailValid($email)
{
    if (function_exists('filter_var')) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    } else {
        if (!preg_match("/^[a-z0-9_.-]+@([a-z0-9]+\.)+[a-z]{2,6}$/i", $email)) {
            return false;
        } else {
            return true;
        }
    }
}


/**
 * @param $db
 * @param null $url
 * @return mixed
 * @throws Exception
 */
function run($db, $url = null)
{
    $url = $url ?: 'index';
    $chpu = explode('/', $url);
    $classname = 'func\actions\\' . ucfirst($chpu[0]);

    if (class_exists($classname)) {
        $class = new $classname($db, $chpu);

        if (isset($chpu[1]) && !empty($chpu[1])) {
            $chpu1 = trim($chpu[1], '/');

            $reflection = new ReflectionMethod($classname, $chpu1);
            if ($reflection->isPublic())
                return $class->{$chpu1}();
            else
                throw new Exception('#1 Страница не найдена');
        } else
            if (method_exists($classname, '__invoke')) {
                return $class();
            } else {
                throw new Exception('#2 Страница не найдена');
            }
    } else {
        throw new Exception('#3 Страница не найдена');
    }
}
