<?php

namespace func\actions;

use func\Session;

class Sklad extends \func\Core
{

    public function __invoke()
    {
        $skladi = $this->getAll();

        $this->render('index', [
            'skladi' => $skladi
        ]);
    }

    public function create()
    {

        if ($this->validate() && $this->save()) {
            $this->session()->setFlash(Session::SUCCESS, "Склад успешно создан");
            $this->redirect('sklad');
            exit;
        }

        $this->render('create');

    }

    public function update() {
        if (!isset($_GET['id']) || !is_numeric($_GET['id']))
            $this->redirect('sklad');

        $sklad = $this->getOne($_GET['id']);
        $_POST['name'] = $_POST['name'] ?? $sklad['name'];

        if ($this->validate() && $this->updateOne($_GET['id'])) {
            $this->session()->setFlash(Session::SUCCESS, "Склад успешно сохранено");
        }

        $this->render('update');
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['id'])) {
            $this->redirect('sklad');
            exit;
        }

        $delete = $this->db->prepare("DELETE FROM `" . DBPREFIX . "sklad` WHERE id=?");
        if ($delete->execute([$_POST['id']])) {
            $this->session()->setFlash(Session::SUCCESS, 'Склад удалена');
            $this->redirect('sklad');
        }

    }

    private $nameLength = 255;

    private function validate(): bool
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            if (empty($_POST['name']))
                $this->err[] = 'Поле Название не может быть пустым!';
            else {
                if (strlen($_POST['name']) > $this->nameLength)
                    $this->err[] = 'Длина Называния не должна превышать ' . $this->nameLength . ' символов.' . "\n";
            }
            if (count($this->err) > 0)
                return false;

            // успешний валидации
            return true;
        }
        return false;
    }

    private function save()
    {
        $sql = "INSERT INTO `" . DBPREFIX . "sklad` (`name`, created_at) VALUES (?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$_POST['name'], time()]);
    }

    private function updateOne($id) {

        $sql = 'UPDATE `'.DBPREFIX.'sklad`
        SET name = :name
        WHERE id = :id';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->bindParam(':name', $_POST['name']);

        return $stmt->execute();
    }

    private function getAll() {
        $sql = 'SELECT *
        FROM `'.DBPREFIX.'sklad`';
        $stmt = $this->db->query($sql);
        $all = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $all;
    }

    private function getOne($id) {
        $sql = 'SELECT *
        FROM `'.DBPREFIX.'sklad` WHERE id = :id';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);

    }

}