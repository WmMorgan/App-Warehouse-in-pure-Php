<?php

namespace func\actions;

use func\Core;
use func\Session;

class Register extends Core
{

    public $layout = 'guest';

    public function __invoke()
    {
        $this->isAuth() ? $this->redirect('') : null;

        $this->registration();

        $this->render('registration');
    }

    private function registration()
    {
        if ($this->validation()) {

            $salt = salt();
            $pass = md5(md5($_POST['pass']) . $salt);

            $sql = 'INSERT INTO `' . DBPREFIX . 'user`
						VALUES(
								null,
								:email,
								:pass,
								:salt,
								"' . md5($salt) . '",
								0
								)';

            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':email', $_POST['email'], \PDO::PARAM_STR);
            $stmt->bindValue(':pass', $pass, \PDO::PARAM_STR);
            $stmt->bindValue(':salt', $salt, \PDO::PARAM_STR);
            $stmt->execute();

            $url = HOST . '/register/activate?key=' . md5($salt);
            $title = 'Регистрация на ' . HOST;
            $message = 'Для активации Вашего акаунта пройдите по ссылке 
				<a href="' . $url . '">' . $url . '</a>';

            sendMessageMail($_POST['email'], MAIL_AUTOR, $title, $message);

            $this->redirect('register/confirmEmail');
            exit;
        }
    }

    public function confirmEmail() {
        $this->render('confirmEmail');
    }


    public function activate() {
        if (!isset($_GET['key']) && empty($_GET['key']))
            $this->redirect('register');

        $stmt = $this->db->prepare("SELECT login 
			FROM `". DBPREFIX ."user`
			WHERE `active_hex` = :key");
        $stmt->bindValue(':key', $_GET['key'], \PDO::PARAM_STR);
        $stmt->execute();
        $rows = $stmt->fetch(\PDO::FETCH_ASSOC);

        if(empty($rows))
            $this->err[] = 'Ключ активации не верен!';

        if(count($this->err) < 1)
        {
            $email = $rows['login'];

            $stmt = $this->db->prepare('UPDATE `'. DBPREFIX .'reg`
				SET `status` = 1
				WHERE `login` = :email');
            $stmt->bindValue(':email', $email, \PDO::PARAM_STR);
            $stmt->execute();

            $title = 'Ваш аккаунт на '.HOST.' успешно активирован';
            $message = 'Поздравляю Вас, Ваш аккаунт на '.HOST.' успешно активирован';

            sendMessageMail($email, MAIL_AUTOR, $title, $message);
            $this->session()->setFlash(Session::SUCCESS, "Ваш аккаунт успешно активирован!");
            $this->redirect('login');
        }

        $this->render('confirmEmail');
    }


    /**
     * @return bool
     */
    private function validation():bool
    {
        if (isset($_POST['submit'])) {
            //Утюжим пришедшие данные
            if (empty($_POST['email']))
                $this->err[] = 'Поле Email не может быть пустым!';
            else {
                if (emailValid($_POST['email']) === false)
                    $this->err[] = 'Не правильно введен E-mail' . "\n";
            }

            if (empty($_POST['pass']))
                $this->err[] = 'Поле Пароль не может быть пустым';

            if (empty($_POST['pass2']))
                $this->err[] = 'Поле Подтверждения пароля не может быть пустым';

            if (count($this->err) > 0)
                return false;
            else
                if ($_POST['pass'] != $_POST['pass2'])
                    $this->err[] = 'Пароли не совподают';

            if (count($this->err) > 0)
                return false;
            else
            $stmt = $this->db->prepare('SELECT `login` 
					FROM `' . DBPREFIX . 'user`
					WHERE `login` = :login');
            $stmt->bindValue(':login', $_POST['email'], \PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            if (count($rows) > 0)
                $this->err[] = 'К сожалению Логин: <b>' . $_POST['email'] . '</b> занят!';

            if (count($this->err) > 0)
                return false;

        } else {
            return false;
        }

        // валдации успешно
        return true;
    }

}
