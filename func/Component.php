<?php
/**
 * @author C_Morgan
 * @date May 12, 16:11
 */

namespace func;

use func\actions\Users;

trait Component
{
    protected $session;
    protected $user;

    protected function isAuth(): mixed
    {
        if (isset($_SESSION['user']) && $this->user())
            return true;

        return false;
    }

    protected function session()
    {
        if ($this->session == null) {
            $this->session = new Session();
        }
        return $this->session;
    }

    protected function isAdmin(): bool
    {
        if ($this->user()['role'] !== Users::ROLE_ADMIN)
            return false;

        return true;
    }

    protected function user()
    {
        if ($this->user == null) {
            $sql = 'SELECT * FROM `' . DBPREFIX . 'user` WHERE id = :id';
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':id' => $this->session()->get('user')]);
            $this->user = $stmt->fetch(\PDO::FETCH_ASSOC);
        }

        return $this->user;
    }

    protected function getAvatar()
    {

        $name = preg_replace('/@(.*)/', '', $this->user()['login']);
        $get = 'https://ui-avatars.com/api/?name=' . $name . '&rounded=true&background=random';
        return $get;
    }
}