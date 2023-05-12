<?php

namespace func\actions;

use func\Core;

class Login extends Core
{
    public $layout = 'guest';

    protected function init() {}


    public function __invoke()
    {
        $this->isAuth() ? $this->redirect('') : null;

        $this->login();

        $this->render('login');
    }


    private function login()
    {

        if (isset($_POST['submit'])) {
            if (empty($_POST['email']))
                $this->err[] = 'Не введен Логин';

            if (empty($_POST['pass']))
                $this->err[] = 'Не введен Пароль';

            if ($_POST['email'] == true && emailValid($_POST['email']) === false)
                $this->err[] = 'Не корректный E-mail';

            if (count($this->err) > 0)
                return false;
            else {
                $sql = 'SELECT * 
				FROM `' . DBPREFIX . 'user`
				WHERE `login` = :email
				AND `status` = :status';

                $stmt = $this->db->prepare($sql);
                $stmt->bindValue(':email', $_POST['email'], \PDO::PARAM_STR);
                $stmt->bindValue(':status', Register::ACTIVE, \PDO::PARAM_INT);
                $stmt->execute();

                $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

                if (count($rows) > 0) {
                    if (md5(md5($_POST['pass']) . $rows[0]['salt']) == $rows[0]['pass']) {
                        $_SESSION['user'] = $rows[0]['id'];

                        $this->redirect('');
                    } else
                        $this->err = 'Неверный пароль!';
                } else {
                    $this->err = 'Логин <b>' . $_POST['email'] . '</b> не найден!';
                }
            }
        }
    }

    public function logout() {
        if ($this->isAuth()) {
            $this->session()->clear();

            $this->redirect('login');
            exit;
        } else {
            $this->redirect('login');
        }
    }


}