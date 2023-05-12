<?php

namespace func\actions;

class Users extends \func\Core
{
    const ROLE_ADMIN = 10;

    public $status = [
        Register::ACTIVE => "Активно",
        Register::NO_ACTIVE => "Не активно"
    ];

    public function __invoke()
    {
        $users = $this->getAllUsers();
        $this->render('index', [
            'users' => $users
        ]);
    }

    /**
     * @return array
     */
    private function getAllUsers(): array
    {
        $sql = 'SELECT * FROM `' . DBPREFIX . 'user`';
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }


}